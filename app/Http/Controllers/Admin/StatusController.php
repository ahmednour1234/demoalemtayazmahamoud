<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;

class StatusController extends Controller
{
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
        if (!is_array($decoded) || !in_array($permissionKey, $decoded, true)) {
            Toastr::warning('غير مسموح لك! كلم المدير.');
            return redirect()->back();
        }
        return null;
    }

    public function index(Request $request)
    {
        if ($resp = $this->ensurePermissionOrBack($request, 'status.index')) return $resp;

        $q      = $request->query('q');
        $active = $request->query('active'); // '1'|'0'|null

        $statuses = Status::query()
            ->when($q, function ($qq) use ($q) {
                $qq->where(function ($w) use ($q) {
                    $w->where('name', 'like', "%{$q}%")
                      ->orWhere('code', 'like', "%{$q}%");
                });
            })
            ->when($active !== null && $active !== '', fn($qq) => $qq->where('active', (bool)$active))
            ->orderBy('sort_order')->orderBy('name')
            ->paginate(20)->withQueryString();

        return view('admin-views.statuses.index', compact('statuses','q','active'));
    }

    public function create(Request $request)
    {
        if ($resp = $this->ensurePermissionOrBack($request, 'status.store')) return $resp;

        return view('admin-views.statuses.create');
    }

    public function store(Request $request)
    {
        if ($resp = $this->ensurePermissionOrBack($request, 'status.store')) return $resp;

        $data = $request->validate([
            'name'       => ['required','string','max:191'],
            'code'       => ['required','string','max:64','unique:statuses,code'],
            'color'      => ['nullable','string','max:32'],
            'sort_order' => ['nullable','integer','between:-999999,999999'],
            'active'     => ['nullable','boolean'],
        ]);

        Status::create($data);
        Toastr::success('تم إنشاء الحالة بنجاح.');
        return redirect()->route('admin.status.index');
    }

    public function edit(Request $request, Status $status)
    {
        if ($resp = $this->ensurePermissionOrBack($request, 'status.update')) return $resp;

        return view('admin-views.statuses.edit', compact('status'));
    }

    public function update(Request $request, Status $status)
    {
        if ($resp = $this->ensurePermissionOrBack($request, 'status.update')) return $resp;

        $data = $request->validate([
            'name'       => ['required','string','max:191'],
            'code'       => ['required','string','max:64',"unique:statuses,code,{$status->id}"],
            'color'      => ['nullable','string','max:32'],
            'sort_order' => ['nullable','integer','between:-999999,999999'],
            'active'     => ['nullable','boolean'],
        ]);

        $status->update($data);
        Toastr::success('تم تحديث الحالة بنجاح.');
        return redirect()->route('admin.status.index');
    }

    public function destroy(Request $request, Status $status)
    {
        if ($resp = $this->ensurePermissionOrBack($request, 'status.destroy')) return $resp;

        $status->delete();
        Toastr::success('تم حذف الحالة.');
        return redirect()->route('admin.status.index');
    }

    public function active(Request $request, Status $status)
    {
        if ($resp = $this->ensurePermissionOrBack($request, 'status.update')) return $resp;

        $status->active = !$status->active;
        $status->save();

        Toastr::success('تم تحديث حالة التفعيل.');
        return back();
    }
}
