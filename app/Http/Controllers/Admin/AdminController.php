<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\AdminSeller;
use App\Models\Admin;
use App\Models\Seller;
use App\Models\Role;
use App\Models\Branch;
use App\Models\Shift;
use App\Models\Category;
use App\Models\Region;
use App\Models\Department;
use Brian2694\Toastr\Facades\Toastr;
use App\CPU\Helpers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct(
        private Admin $admin,
        private Seller $seller,
        private Shift $shift,
        private AdminSeller $adminseller,
    ){}

    /* ----------------------- Helpers ----------------------- */

    /**
     * التحقق من الصلاحية حسب الـ role->data (array of strings)
     */
    private function ensurePermissionOrBack(Request $request, string $permissionKey): ?RedirectResponse
    {
        $adminId = Auth::guard('admin')->id();
        $admin = DB::table('admins')->where('id', $adminId)->first();

        if (!$admin) {
            Toastr::warning('غير مسموح لك! كلم المدير.');
            return redirect()->back();
        }

        $role = DB::table('roles')->where('id', $admin->role_id)->first();
        if (!$role) {
            Toastr::warning('غير مسموح لك! كلم المدير.');
            return redirect()->back();
        }

        $decoded = json_decode($role->data, true);
        if (is_string($decoded)) $decoded = json_decode($decoded, true);
        if (!is_array($decoded) || !in_array($permissionKey, $decoded)) {
            Toastr::warning('غير مسموح لك! كلم المدير.');
            return redirect()->back();
        }

        return null; // OK
    }

    /* ----------------------- Index / Filters ----------------------- */

public function index(Request $request)
{
    if ($resp = $this->ensurePermissionOrBack($request, 'admin.store')) return $resp;

    $q = trim((string) $request->query('q', ''));

    $admins = Admin::query()
        // بحث نصي
        ->when($q !== '', function ($query) use ($q) {
            $query->where(function ($qq) use ($q) {
                $qq->where('f_name', 'like', "%{$q}%")
                   ->orWhere('l_name', 'like', "%{$q}%")
                   ->orWhere('email',  'like', "%{$q}%");
            });
        })

        // فلتر الفرع
        ->when($request->has('branch_id') && $request->query('branch_id') !== '' && $request->query('branch_id') !== 'all', function ($q2) use ($request) {
            $q2->where('branch_id', (int) $request->query('branch_id'));
        })

        // فلتر القسم
        ->when($request->has('department_id') && $request->query('department_id') !== '' && $request->query('department_id') !== 'all', function ($q2) use ($request) {
            $q2->where('department_id', (int) $request->query('department_id'));
        })

        // فلتر المدير: يدعم manager_id=null للي بدون مدير
        ->when($request->has('manager_id'), function ($q2) use ($request) {
            $m = $request->query('manager_id');

            if ($m === '' || $m === 'all') {
                return; // تجاهل
            }

            if ($m === 'null') {
                $q2->whereNull('manager_id');
            } else {
                $q2->where('manager_id', (int) $m);
            }
        })

        ->with([
            'department:id,name',
            'manager:id,f_name,l_name',
            'branch:id,name',
        ])
        ->orderBy('f_name')
        ->paginate(Helpers::pagination_limit())
        ->appends($request->query()); // يعادل withQueryString()

    $sellers     = Seller::all();
    $roles       = Role::all();
    $shifts      = Shift::all();
    $branches    = Branch::all();
    $departments = Department::orderBy('name')->get(['id','name']);
    $managers    = Admin::orderBy('f_name')->get(['id','f_name','l_name']);

    return view('admin-views.admin.index', compact(
        'admins','sellers','roles','branches','shifts',
        'departments','managers','q'
    ) + [
        'branchId'     => $request->query('branch_id'),
        'departmentId' => $request->query('department_id'),
        'managerId'    => $request->query('manager_id'),
    ]);
}


    /* ----------------------- Map ----------------------- */

    public function showmap(Request $request)
    {
        if ($resp = $this->ensurePermissionOrBack($request, 'seller.map')) return $resp;

        $admins = Admin::select('f_name', 'latitude', 'longitude')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        return view('admin-views.map.index', compact('admins'));
    }

    /* ----------------------- Store ----------------------- */

    public function store(Request $request): RedirectResponse
    {
        if ($resp = $this->ensurePermissionOrBack($request, 'admin.store')) return $resp;

        $request->validate([
            'f_name'        => 'required',
            'l_name'        => 'required',
            'latitude'      => 'nullable',
            'longitude'     => 'nullable',
            'email'         => 'required|email|unique:admins',
            'password'      => 'required|min:8',
            'role_id'       => 'nullable|exists:roles,id',
            'branch_id'     => 'nullable|exists:branches,id',
            'shift_id'      => 'nullable|exists:shifts,id',
            // الإضافات المطلوبة:
            'department_id' => ['nullable','exists:departments,id'],
            'manager_id'    => ['nullable','exists:admins,id'],
            'sellers'       => ['nullable','array'],
            'sellers.*'     => ['exists:sellers,id'],
        ]);

        DB::beginTransaction();

        try {
            /** @var Admin $admin */
            $admin = $this->admin;
            $admin->f_name       = $request->f_name;
            $admin->l_name       = $request->l_name;
            $admin->latitude     = $request->latitude;
            $admin->longitude    = $request->longitude;
            $admin->email        = $request->email;
            $admin->role_id      = $request->role_id;
            $admin->branch_id    = $request->branch_id;
            $admin->shift_id     = $request->shift_id ?? 1;
            // الإضافات:
            $admin->department_id= $request->department_id;
            $admin->manager_id   = $request->manager_id;

            // منع أن يكون مدير نفسه (لو ادخل نفس الـ id)
            if (!empty($admin->manager_id)) {
                // في الإنشاء لسه مفيش id، فتأكد فقط إن الـ manager_id ليس مساويًا لـ admin->id بعد الحفظ
            }

            $admin->password     = Hash::make($request->password);
            $admin->save();

            // الآن ممكن نتحقق أن المدير ليس هو نفسه بعد توليد الـ id
            if (!empty($admin->manager_id) && (int)$admin->manager_id === (int)$admin->id) {
                DB::rollBack();
                Toastr::error('لا يمكن أن يكون الموظف مديرًا لنفسه.');
                return back()->withInput();
            }

            // ربط السيلرز (إن وجدت)
            if (is_array($request->sellers)) {
                foreach ($request->sellers as $item) {
                    $adminseller = new AdminSeller;
                    $adminseller->seller_id = $item;
                    $adminseller->admin_id  = $admin->id;
                    $adminseller->save();
                }
            }

            DB::commit();

            Toastr::success('تمت إضافة الأدمن بنجاح');
            return back();

        } catch (\Exception $e) {
            DB::rollBack();
            Toastr::error('فشل إضافة الأدمن. حاول مرة أخرى.');
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /* ----------------------- List ----------------------- */

    public function list(Request $request)
    {
        if ($resp = $this->ensurePermissionOrBack($request, 'admin.index')) return $resp;
      $q            = $request->query('q');
        $branchId     = $request->query('branch_id');
        $departmentId = $request->query('department_id');
        $managerId    = $request->query('manager_id');

        $admins = $this->admin->where('role', 'admin')
            ->with(['department:id,name', 'manager:id,f_name,l_name', 'branch:id,name'])
            ->paginate(Helpers::pagination_limit());
                    $sellers    = Seller::all();
        $roles      = Role::all();
        $shifts     = Shift::all();
        $branches   = Branch::all();
        $departments= Department::orderBy('name')->get(['id','name']);
        $managers   = Admin::orderBy('f_name')->get(['id','f_name','l_name']);


        return view('admin-views.admin.list', compact('admins','sellers','roles','branches','shifts',
            'departments','managers','q','branchId','departmentId','managerId'));
    }

    /* ----------------------- Edit ----------------------- */

    public function edit(Request $request)
    {
        if ($resp = $this->ensurePermissionOrBack($request, 'admin.update')) return $resp;

        $roles      = Role::all();
        $branches   = Branch::all();
        $shifts     = Shift::all();
        $regions    = Region::all();
        $sellers    = $this->seller->get();
        $categories = Category::all();
        $departments= Department::orderBy('name')->get(['id','name']);
        $managers   = Admin::orderBy('f_name')->get(['id','f_name','l_name']);

        $admin = $this->admin->where('id',$request->id)->first();

        return view('admin-views.admin.edit', compact(
            'admin', 'regions', 'categories', 'sellers', 'roles', 'branches', 'shifts', 'departments', 'managers'
        ));
    }

    /* ----------------------- Update ----------------------- */

    public function update(Request $request): RedirectResponse
    {
        if ($resp = $this->ensurePermissionOrBack($request, 'admin.update')) return $resp;

        $admin = $this->admin->where('id', $request->id)->first();

        $request->validate([
            'f_name'        => 'required',
            'l_name'        => 'required',
            'latitude'      => 'nullable',
            'longitude'     => 'nullable',
            'email'         => 'required|email|unique:admins,email,' . $admin->id,
            'role_id'       => 'nullable|exists:roles,id',
            'branch_id'     => 'nullable|exists:branches,id',
            'shift_id'      => 'nullable|exists:shifts,id',
            // الإضافات المطلوبة:
            'department_id' => ['nullable','exists:departments,id'],
            'manager_id'    => ['nullable','exists:admins,id'],
            'sellers'       => ['nullable','array'],
            'sellers.*'     => ['exists:sellers,id'],
        ]);

        // منع أن يكون مدير نفسه
        if (!empty($request->manager_id) && (int)$request->manager_id === (int)$admin->id) {
            Toastr::error('لا يمكن أن يكون الموظف مديرًا لنفسه.');
            return back()->withErrors(['manager_id' => 'لا يمكن أن يكون الموظف مديرًا لنفسه.'])->withInput();
        }

        DB::beginTransaction();

        try {
            $admin->f_name       = $request->f_name;
            $admin->l_name       = $request->l_name;
            $admin->latitude     = $request->latitude;
            $admin->longitude    = $request->longitude;
            $admin->email        = $request->email;
            $admin->role_id      = $request->role_id;
            $admin->branch_id    = $request->branch_id;
            $admin->shift_id     = $request->shift_id ?? $admin->shift_id;
            // الإضافات:
            $admin->department_id= $request->department_id;
            $admin->manager_id   = $request->manager_id;

            // إعادة ربط السيلرز
            AdminSeller::where('admin_id', $admin->id)->delete();
            if (is_array($request->sellers)) {
                foreach ($request->sellers as $item) {
                    $adminseller = new AdminSeller;
                    $adminseller->seller_id = $item;
                    $adminseller->admin_id  = $admin->id;
                    $adminseller->save();
                }
            }

            if ($request->password) {
                $request->validate(['password' => 'min:8']);
                $admin->password = Hash::make($request->password);
            }

            $admin->update();

            DB::commit();

            Toastr::success('تم تحديث بيانات الأدمن بنجاح');
            return redirect()->route('admin.admin.list');

        } catch (\Exception $e) {
            DB::rollBack();
            Toastr::error('فشل تحديث بيانات الأدمن.');
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /* ----------------------- Delete (Soft Delete) ----------------------- */

    public function delete(Request $request): RedirectResponse
    {
        if ($resp = $this->ensurePermissionOrBack($request, 'admin.destroy')) return $resp;

        $admin = $this->admin->find($request->id);
        if (!$admin) {
            Toastr::error('الأدمن غير موجود.');
            return back();
        }

        $admin->delete(); // Soft delete بافتراض وجود deleted_at

        Toastr::success('تم حذف الأدمن بنجاح');
        return back();
    }

    /* ----------------------- Organizational Structure ----------------------- */

    /**
     * هيكل الموظفين والأقسام حسب الفروع
     * فيو: resources/views/admin-views/admin/structure.blade.php
     */
    public function structure(Request $request)
    {
        // صلاحية استعراض الهيكل - استخدم مفتاح مناسب لديك، أو admin.index كمثال
        if ($resp = $this->ensurePermissionOrBack($request, 'admin.index')) return $resp;

        $branchId     = $request->query('branch_id');     // فلتر فرع
        $departmentId = $request->query('department_id'); // فلتر قسم
        $managerId    = $request->query('manager_id');    // فلتر مدير

        // جلب الفروع مع أقسامها وموظفيها (حسب الفلاتر)
        $branches = Branch::query()
            ->when($branchId, fn($q) => $q->where('id', $branchId))
            ->with(['admins' => function($q) use ($departmentId, $managerId) {
                $q->with(['department:id,name', 'manager:id,f_name,l_name'])
                  ->when($departmentId, fn($qq) => $qq->where('department_id', $departmentId))
                  ->when($managerId, fn($qq) => $qq->where('manager_id', $managerId))
                  ->orderBy('f_name');
            }])
            ->orderBy('name')
            ->get();

        $departments = Department::orderBy('name')->get(['id','name']);
        $managers    = Admin::orderBy('f_name')->get(['id','f_name','l_name']);
        $branchesAll = Branch::orderBy('name')->get(['id','name']);

        return view('admin-views.admin.structure', compact(
            'branches', 'departments', 'managers', 'branchesAll',
            'branchId', 'departmentId', 'managerId'
        ));
    }
}
