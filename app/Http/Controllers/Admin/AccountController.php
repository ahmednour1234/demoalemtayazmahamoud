<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\CPU\Helpers;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\Account;
use App\Models\Transection;
use App\Models\Storage;
use function App\CPU\translate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function __construct(
        private Account $account,
        private Storage $storage
    ){}

    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function list(Request $request)
    {
            $adminId = Auth::guard('admin')->id();
    $admin = DB::table('admins')->where('id', $adminId)->first();

    if (!$admin) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }

    $roleId = $admin->role_id;
    $role = DB::table('roles')->where('id', $roleId)->first();

    if (!$role) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }

    $decodedData = json_decode($role->data, true);
    if (is_string($decodedData)) {
        $decodedData = json_decode($decodedData, true);
    }

    if (!is_array($decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }

    if (!in_array("account.index", $decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }   
        $query_param = [];
        $search = $request['search'];
        if ($request->has('search')) {
            $key = explode(' ', $request['search']);
            $query = $this->account->where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->where('account', 'like', "%{$value}%")->orWhere('code',"%{$value}%");
                }
            });
            $query_param = ['search' => $request['search']];
        } else {
            $query = $this->account;
        }
        $storages= $this->storage;

        $accounts = $query->wherenull('parent_id')->orderBy('id','desc')->paginate(Helpers::pagination_limit());
        return view('admin-views.account.list', compact('accounts','search','storages'));
    }
        public function listall(Request $request)
    {
        
            $adminId = Auth::guard('admin')->id();
    $admin = DB::table('admins')->where('id', $adminId)->first();

    if (!$admin) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }

    $roleId = $admin->role_id;
    $role = DB::table('roles')->where('id', $roleId)->first();

    if (!$role) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }

    $decodedData = json_decode($role->data, true);
    if (is_string($decodedData)) {
        $decodedData = json_decode($decodedData, true);
    }

    if (!is_array($decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }

    if (!in_array("account.index", $decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }   
        $query_param = [];
        $search = $request['search'];
        if ($request->has('search')) {
            $key = explode(' ', $request['search']);
            $query = $this->account->where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->where('account', 'like', "%{$value}%");
                }
            });
            $query_param = ['search' => $request['search']];
        } else {
            $query = $this->account;
        }
        $storages= $this->storage;

        $accounts = $query->orderBy('id','desc')->wherenot('account_type','other')->paginate(Helpers::pagination_limit());
        return view('admin-views.account.list', compact('accounts','search','storages'));
    }
  public function listone(Request $request, $id)
{
     $adminId = Auth::guard('admin')->id();
    $admin = DB::table('admins')->where('id', $adminId)->first();

    if (!$admin) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }

    $roleId = $admin->role_id;
    $role = DB::table('roles')->where('id', $roleId)->first();

    if (!$role) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }

    $decodedData = json_decode($role->data, true);
    if (is_string($decodedData)) {
        $decodedData = json_decode($decodedData, true);
    }

    if (!is_array($decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }

    if (!in_array("account.index", $decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }   
    // Initialize query parameters
    $query_param = [];
    $search = $request->input('search');

    // Account Query
    $query = $this->account->where('parent_id', $id);

    // Apply Search Filter
    if ($search) {
        $keywords = explode(' ', $search);
        $query->where(function ($q) use ($keywords) {
            foreach ($keywords as $word) {
                $q->orWhere('account', 'like', "%{$word}%")
                  ->orWhere('name', 'like', "%{$word}%"); // Add name field if applicable
            }
        });
        $query_param['search'] = $search;
    }

    // Fetch paginated results
    $accounts = $query->with('children')->latest()
        ->paginate(Helpers::pagination_limit())
        ->appends($query_param);
$account=Account::where('id',$id)->first();
    // Fetch storages if needed
    $storages = $this->storage;

    // Return view with compacted data
    return view('admin-views.account.listone', compact('accounts', 'search', 'storages','id','account'));
}

    

    /**
     * @return Application|Factory|View
     */
public function add()
{
        $adminId = Auth::guard('admin')->id();
    $admin = DB::table('admins')->where('id', $adminId)->first();

    if (!$admin) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }

    $roleId = $admin->role_id;
    $role = DB::table('roles')->where('id', $roleId)->first();

    if (!$role) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }

    $decodedData = json_decode($role->data, true);
    if (is_string($decodedData)) {
        $decodedData = json_decode($decodedData, true);
    }

    if (!is_array($decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }

    if (!in_array("account.store", $decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }   
    // Get all storages from the database
    $storages = Storage::all(); // or Storage::paginate(10) if you want pagination

    return view('admin-views.account.add', compact('storages'));
}
public function addone($id)
{
     $adminId = Auth::guard('admin')->id();
    $admin = DB::table('admins')->where('id', $adminId)->first();

    if (!$admin) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }

    $roleId = $admin->role_id;
    $role = DB::table('roles')->where('id', $roleId)->first();

    if (!$role) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }

    $decodedData = json_decode($role->data, true);
    if (is_string($decodedData)) {
        $decodedData = json_decode($decodedData, true);
    }

    if (!is_array($decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }

    if (!in_array("account.store", $decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }   
    // Get all storages from the database
    $storages = Storage::all(); // or Storage::paginate(10) if you want pagination
$account=Account::where('id',$id)->first();
    return view('admin-views.account.addone', compact('storages','id','account'));
}


    /**
     * @param Request $request
     * @return RedirectResponse
     */
public function store(Request $request)
    {
        // هل الطلب يتوقع JSON؟
        $wantsJson = $request->expectsJson() || $request->ajax() ||
                     str_contains(strtolower($request->header('accept', '')), 'application/json');

        // ====== التحقق من المستخدم والدور ======
        $adminId = Auth::guard('admin')->id();
        $admin   = DB::table('admins')->where('id', $adminId)->first();

        if (!$admin) {
            $msg = 'غير مسموح لك! كلم المدير.';
            return $wantsJson
                ? response()->json(['status' => false, 'message' => $msg], 403)
                : tap(Toastr::warning($msg), fn() => redirect()->back());
        }

        $role = DB::table('roles')->where('id', $admin->role_id)->first();
        if (!$role) {
            $msg = 'غير مسموح لك! كلم المدير.';
            return $wantsJson
                ? response()->json(['status' => false, 'message' => $msg], 403)
                : tap(Toastr::warning($msg), fn() => redirect()->back());
        }

        // بعض الأنظمة بتخزن الـdata كـ JSON داخل JSON
        $decodedData = $role->data;
        if (is_string($decodedData)) {
            $decodedData = json_decode($decodedData, true);
            if (is_string($decodedData)) {
                $decodedData = json_decode($decodedData, true);
            }
        }
        if (!is_array($decodedData) || !in_array('account.store', $decodedData, true)) {
            $msg = 'غير مسموح لك! كلم المدير.';
            return $wantsJson
                ? response()->json(['status' => false, 'message' => $msg], 403)
                : tap(Toastr::warning($msg), fn() => redirect()->back());
        }

        // ====== فاليديشن يدوي علشان نرجّع 422 JSON بشكل واضح ======
        $validator = Validator::make($request->all(), [
            'account'                  => 'required|string|max:255',
            'description'              => 'nullable|string|max:500',
            'balance'                  => 'nullable|numeric',
            'parent_id'                => 'nullable|exists:accounts,id',
            'account_type'             => 'required|in:asset,liability,equity,revenue,expense,other',
            'account_number'           => 'nullable|string|max:255',
            'type'                     => 'nullable|in:0,1',                // يظهر/لا يظهر للمندوب
            'cost_center'              => 'nullable|in:0,1',
            'default_cost_center_id'   => 'nullable|exists:cost_centers,id',
            'storage_id'               => 'nullable|integer',
        ], [
            'account.required'     => 'عنوان الحساب مطلوب',
            'account_type.in'      => 'نوع الحساب غير صحيح',
            'parent_id.exists'     => 'الحساب الأب غير موجود',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                'status'  => false,
                'message' => 'خطأ في التحقق من البيانات',
                'errors'  => $errors,
            ], 422);
        }

        $payload = $validator->validated();

        // توليد كود الحساب
        $accountCode = Account::generateAccountCode(
            $payload['account_type'],
            $payload['parent_id'] ?? null
        );

        try {
            $account = DB::transaction(function () use ($payload, $accountCode) {
                $acc = new Account();

                $acc->account                  = $payload['account'];
                $acc->code                     = $accountCode;
                $acc->description              = $payload['description'] ?? null;

                $balance                       = (float) ($payload['balance'] ?? 0);
                $acc->balance                  = $balance;
                $acc->total_in                 = $balance;
                $acc->total_out                = 0;

                $acc->parent_id                = $payload['parent_id'] ?? null;
                $acc->default_cost_center_id   = $payload['default_cost_center_id'] ?? null;
                $acc->storage_id               = $payload['storage_id'] ?? null;

                $acc->type                     = isset($payload['type']) ? (int) $payload['type'] : 0;
                // لو عندك رقم حساب مُدخل استخدمه، وإلا خليه نفس الـcode
                $acc->account_number           = $payload['account_number'] ?? $accountCode;

                $acc->cost_center              = isset($payload['cost_center']) ? (int) $payload['cost_center'] : 0;
                $acc->account_type             = $payload['account_type'];

                $acc->save();

                return $acc;
            });
        } catch (\Throwable $e) {
            report($e);

            $msg = 'تعذر إنشاء الحساب. حاول لاحقًا.';
            return response()->json([
                'status'  => false,
                'message' => $msg,
                'error'   => app()->hasDebugMode() ? $e->getMessage() : null,
            ], 500);
        }

        // نجاح
        $response = [
            'status'  => true,
            'message' => 'تم إضافة دليل محاسبي بنجاح',
            'data'    => [
                'id'              => $account->id,
                'account'         => $account->account,
                'code'            => $account->code,
                'account_number'  => $account->account_number,
                'account_type'    => $account->account_type,
                'parent_id'       => $account->parent_id,
                'balance'         => (float) $account->balance,
                'cost_center'     => (int) $account->cost_center,
                'type'            => (int) $account->type,
                'default_cost_center_id' => $account->default_cost_center_id,
                'storage_id'      => $account->storage_id,
                'description'     => $account->description,
            ],
        ];

        // لو الطلب مش AJAX/JSON هنحافظ على السلوك القديم
        if (!$wantsJson) {
            Toastr::success(__('تم إضافة دليل محاسبي بنجاح'));
            return redirect(url()->previous());
        }

        return response()->json($response, 201);
    }
public function destroy(Request $request, int $id): RedirectResponse
{
    // ===== صلاحيات =====
    $adminId = Auth::guard('admin')->id();
    $admin = DB::table('admins')->where('id', $adminId)->first();
    if (!$admin) { Toastr::warning('غير مسموح لك! كلم المدير.'); return back(); }

    $role = DB::table('roles')->where('id', $admin->role_id)->first();
    if (!$role) { Toastr::warning('غير مسموح لك! كلم المدير.'); return back(); }

    $decodedData = json_decode($role->data, true);
    if (is_string($decodedData)) $decodedData = json_decode($decodedData, true);
    if (!is_array($decodedData) || !in_array("account.destroy", $decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return back();
    }

    // ===== الحساب (مع المحذوفين) =====
    /** @var \App\Models\Account|null $account */
    $account = Account::withTrashed()->find($id);
    if (!$account) { Toastr::warning('الحساب غير موجود'); return back(); }

    if ($account->trashed()) {
        Toastr::info('هذا الحساب محذوف لطيفًا بالفعل.');
        return back();
    }

    // ممنوع حذف حساب أب لديه أبناء غير محذوفين لطيفًا
    $hasActiveChildren = $account->children()
        ->whereNull('deleted_at')
        ->exists();

    if ($hasActiveChildren) {
        Toastr::warning('لا يمكن حذف هذا الحساب لأنه يحتوي على حسابات فرعية.');
        return back();
    }

    // ممنوع لو عليه قيود يومية
    $inJED = DB::table('journal_entries_details')->where('account_id', $id)->exists();
    if ($inJED) {
        Toastr::warning('لا يمكن حذف هذا الحساب لارتباطه بقيود يومية.');
        return back();
    }

    // ممنوع لو عليه حركات مالية في أي طرف
    $inTx = DB::table('transections') // اترك الاسم كما هو إذا كان جدولك فعلاً بهذا الاسم
        ->where(function ($q) use ($id) {
            $q->where('account_id', $id)->orWhere('account_id_to', $id);
        })->exists();

    if ($inTx) {
        Toastr::warning('لا يمكن حذف هذا الحساب لارتباطه بحركات مالية.');
        return back();
    }

    // رصيد غير صفري
    $balance = (float) ($account->balance ?? 0);
    if (round($balance, 2) != 0.0) {
        Toastr::warning('لا يمكن حذف حساب غير صفري الرصيد.');
        return back();
    }

    // ===== الحذف اللطيف =====
    try {
        DB::transaction(function () use ($account) {
            // سيجري SoftDelete على هذا الحساب فقط (لن يطال الأبناء لأننا منعنا وجود أبناء نشطين)
            $account->delete();
        });

        Toastr::success('تم أرشفة (حذف لطيف) الحساب بنجاح.');
    } catch (\Throwable $e) {
        \Log::error('Account soft delete failed', [
            'account_id' => $account->id,
            'error'      => $e->getMessage(),
        ]);
        Toastr::error('فشل الحذف! حاول لاحقًا.');
    }

    return back();
}
    /**
     * @param $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
            $adminId = Auth::guard('admin')->id();
    $admin = DB::table('admins')->where('id', $adminId)->first();

    if (!$admin) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }

    $roleId = $admin->role_id;
    $role = DB::table('roles')->where('id', $roleId)->first();

    if (!$role) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }

    $decodedData = json_decode($role->data, true);
    if (is_string($decodedData)) {
        $decodedData = json_decode($decodedData, true);
    }

    if (!is_array($decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }

    if (!in_array("account.update", $decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }   
        $account = $this->account->find($id);
        return view('admin-views.account.edit', compact('account'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
 public function update(Request $request, $id)
    {
        // هل الطلب يتوقع JSON؟
        $wantsJson = $request->expectsJson() || $request->ajax() ||
                     str_contains(strtolower($request->header('accept', '')), 'application/json');

        // ====== التحقق من المستخدم والدور ======
        $adminId = Auth::guard('admin')->id();
        $admin   = DB::table('admins')->where('id', $adminId)->first();

        if (!$admin) {
            $msg = 'غير مسموح لك! كلم المدير.';
            return $wantsJson
                ? response()->json(['status' => false, 'message' => $msg], 403)
                : tap(Toastr::warning($msg), fn() => redirect()->back());
        }

        $role = DB::table('roles')->where('id', $admin->role_id)->first();
        if (!$role) {
            $msg = 'غير مسموح لك! كلم المدير.';
            return $wantsJson
                ? response()->json(['status' => false, 'message' => $msg], 403)
                : tap(Toastr::warning($msg), fn() => redirect()->back());
        }

        $decodedData = $role->data;
        if (is_string($decodedData)) {
            $decodedData = json_decode($decodedData, true);
            if (is_string($decodedData)) {
                $decodedData = json_decode($decodedData, true);
            }
        }
        if (!is_array($decodedData) || !in_array('account.update', $decodedData, true)) {
            $msg = 'غير مسموح لك! كلم المدير.';
            return $wantsJson
                ? response()->json(['status' => false, 'message' => $msg], 403)
                : tap(Toastr::warning($msg), fn() => redirect()->back());
        }

        // ====== فاليديشن ======
        $validator = Validator::make($request->all(), [
            'account'                => 'required|string|max:255',
            'account_number'         => 'nullable|string|max:255',
            'description'            => 'nullable|string|max:500',
            'default_cost_center_id' => 'nullable|exists:cost_centers,id',
            'cost_center'            => 'nullable|in:0,1',
        ], [
            'account.required' => 'عنوان الحساب مطلوب',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'خطأ في التحقق من البيانات',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $payload = $validator->validated();

        // ====== التحديث + إعادة ترقيم الأكواد (كما في منطقك الحالي) ======
        try {
            $updated = DB::transaction(function () use ($id, $payload) {
                /** @var \App\Models\Account $account */
                $account = $this->account->findOrFail($id);

                $account->account                = $payload['account'];
                $account->account_number         = $payload['account_number'] ?? $account->account_number;
                $account->description            = $payload['description'] ?? null;
                $account->default_cost_center_id = $payload['default_cost_center_id'] ?? null;
                $account->cost_center            = isset($payload['cost_center']) ? (int) $payload['cost_center'] : 0;
                $account->save();

                // نفس منطقك لإعادة الترقيم
                $typePrefixes = [
                    'asset'     => 1,
                    'liability' => 2,
                    'equity'    => 3,
                    'revenue'   => 4,
                    'expense'   => 5,
                ];

                foreach ($typePrefixes as $type => $prefix) {
                    $mainAccounts = $this->account
                        ->where('account_type', $type)
                        ->whereNull('parent_id')
                        ->orderBy('id', 'asc')
                        ->get();

                    $counter = 1;
                    foreach ($mainAccounts as $main) {
                        // مستوى أول = بادئة النوع + رقم متسلسل (نُبقي نفس طريقتك)
                        $main->code = $prefix . str_pad($counter, 1, '', STR_PAD_LEFT);
                        $main->save();

                        // تحديث الأكواد للأبناء والأحفاد (تفترض وجود الدالة لديك)
                        $this->updateChildCodes($main, $main->code);
                        $counter++;
                    }
                }

                return $account->fresh();
            });
        } catch (\Throwable $e) {
            report($e);
            $msg = 'تعذر تحديث الحساب. حاول لاحقًا.';
            return response()->json([
                'status'  => false,
                'message' => $msg,
                'error'   => app()->hasDebugMode() ? $e->getMessage() : null,
            ], 500);
        }

        $response = [
            'status'  => true,
            'message' => 'تم تحديث بيانات دليل محاسبي بنجاح',
            'data'    => [
                'id'                      => $updated->id,
                'account'                 => $updated->account,
                'account_number'          => $updated->account_number,
                'code'                    => $updated->code,
                'description'             => $updated->description,
                'default_cost_center_id'  => $updated->default_cost_center_id,
                'cost_center'             => (int) $updated->cost_center,
            ],
        ];

        if (!$wantsJson) {
            Toastr::success(__('تم تحديث بيانات دليل محاسبي بنجاح'));
            return redirect()->back();
        }

        return response()->json($response, 200);
    }
/**
 * تحديث أكواد الأبناء بشكل متسلسل
 */
protected function updateChildCodes($parentAccount, $prefixCode = null)
{
    $prefixCode = $prefixCode ?? $parentAccount->code;

    $children = $this->account
        ->where('parent_id', $parentAccount->id)
        ->orderBy('id', 'asc')
        ->get();

    $counter = 1;
    foreach ($children as $child) {
        $level = $this->getAccountLevel($parentAccount);

        if ($level == 1) {
            // المستوى 2 → ثلاثة أرقام
            $child->code = $prefixCode . $counter;
        } elseif ($level == 2) {
            // المستوى 3 → أربعة أرقام
            $child->code = $prefixCode . $counter;
        } elseif ($level >= 3) {
            // المستوى الرابع وما بعده → 0001, 0002 ...
            $child->code = $prefixCode . str_pad($counter, 4, '0', STR_PAD_LEFT);
        }

        $child->save();
        $this->updateChildCodes($child, $child->code);
        $counter++;
    }
}

/**
 * تحديد مستوى الحساب من الكود
 */
protected function getAccountLevel($account)
{
    $len = strlen($account->code);

    if ($len <= 2) return 1; // مثال: 11
    if ($len == 3) return 2; // مثال: 111
    if ($len == 4) return 3; // مثال: 1111
    return 4;                // مثال: 11110001 أو أكثر
}


    /**
     * @param $id
     * @return RedirectResponse
     */
    public function delete($id): RedirectResponse
    {
            $adminId = Auth::guard('admin')->id();
    $admin = DB::table('admins')->where('id', $adminId)->first();

    if (!$admin) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }

    $roleId = $admin->role_id;
    $role = DB::table('roles')->where('id', $roleId)->first();

    if (!$role) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }

    $decodedData = json_decode($role->data, true);
    if (is_string($decodedData)) {
        $decodedData = json_decode($decodedData, true);
    }

    if (!is_array($decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }

    if (!in_array("account.destroy", $decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }   
        $account = $this->account->find($id);
        $account->delete();

        Toastr::success(translate('تم حذف دليل محاسبي بنجاح'));
        return back();
    }

public function download()
{
    // Ensure the user is authenticated as a seller
    $seller = Auth::guard('admin')->user();

    if (!$seller) {
        abort(403, 'Unauthorized');
    }

    // Fetch account data
    $accounts = Account::all();
    $search = request('search', '');

    // Render Blade view and include seller's email
    $html = view('admin-views.account.pdf', compact('accounts', 'search', 'seller'))->render();

    // Save HTML to a temporary file
    $filePath = storage_path('app/public/account_report.html');
    file_put_contents($filePath, $html);

    // Download the file and delete after sending
    return response()->download($filePath, 'account_report.html')->deleteFileAfterSend(true);
}
public function getAccounts($storage_id)
{
    $accounts = Account::where('storage_id', $storage_id)->get();
    return response()->json(['accounts' => $accounts]);
}

public function getSubAccounts($account_id)
{
    $accounts = Account::where('parent_id', $account_id)->get();
    return response()->json(['accounts' => $accounts]);
}
public function getSubItems($type, $id)
{
    if ($type === 'storage') {
        $storages = Storage::where('parent_id', $id)->get();
        $accounts = Account::where('storage_id', $id)->whereNull('parent_id')->get();
    } else {
        $storages = [];
        $accounts = Account::where('parent_id', $id)->get();
    }

    return response()->json([
        'storages' => $storages,
        'accounts' => $accounts
    ]);
}
public function getAccountsByTypeOrParent(Request $request)
{
    $type = $request->query('type');
    $parentId = $request->query('parent_id');

    if ($type) {
        $accounts = Account::where('account_type', $type)->whereNull('parent_id')->get();
    } elseif ($parentId) {
        $accounts = Account::where('parent_id', $parentId)->get();
    } else {
        $accounts = [];
    }

    return response()->json($accounts);
}
public function search(Request $request)
{
    $accounts = \App\Models\Account::where('account', 'LIKE', '%' . $request->name . '%')
        ->select('id', 'account', 'account_number','description','account_type','code')
        ->limit(20)
        ->get();

    return response()->json($accounts);
}
 public function totals(Request $request)
    {
        $id   = $request->query('id');
        $code = $request->query('code');

        $account = Account::query()
            ->when($id, fn($q) => $q->where('id', $id))
            ->when(!$id && $code, fn($q) => $q->where(function($qq) use ($code) {
                $qq->where('code', $code)->orWhere('account_number', $code);
            }))
            ->first();

        if (!$account) {
            return response()->json([
                'success'   => false,
                'message'   => 'الحساب غير موجود',
                'total_in'  => 0,
                'total_out' => 0,
            ], 404);
        }

        // عدّل أسماء الأعمدة لو مختلفة عندك
        $totalIn  = (float) ($account->total_in  ?? 0);
        $totalOut = (float) ($account->total_out ?? 0);

        return response()->json([
            'success'   => true,
            'account'   => [
                'id'   => $account->id,
                'name' => $account->account ?? $account->name ?? '',
            ],
            'total_in'  => round($totalIn, 2),
            'total_out' => round($totalOut, 2),
        ]);
    }

}
