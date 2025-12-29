<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\JournalEntry;
use App\Models\Transection;
use App\CPU\Helpers;
use Brian2694\Toastr\Facades\Toastr;
use function App\CPU\translate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;


class PayableController extends Controller
{
    public function __construct(
        private Transection $transection,
        private Account $account,
    ){}

    /**
     * @param Request $request
     * @return Application|Factory|View
     */
public function add(Request $request)
{
    $adminId = Auth::guard('admin')->id();
    $admin = DB::table('admins')->where('id', $adminId)->first();

    // تحقق من وجود المسؤول وصلاحياته
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

    if (!in_array("start.store", $decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }

    // استرجاع الحسابات التي ليست parent ولا تحتوي على children
    $accounts = $this->account
        ->whereNotNull('parent_id')
        ->doesntHave('children')
        ->orderBy('id')
        ->get();

    // استرجاع معايير البحث من الطلب
    $search = $request['search'];
    $from = $request->from;
    $to = $request->to;

    // بناء الاستعلام بناءً على وجود بحث
    if ($request->has('search')) {
        $key = explode(' ', $request['search']);
        // استخدام Eloquent بدلاً من Query Builder
        $query = JournalEntry::where('type', 1) // 1 = رصيد افتتاحي
            ->where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('description', 'like', "%{$value}%");
                }
            });
        $query_param = ['search' => $request['search']];
    } else {
        $query = JournalEntry::where('type', 1) // رصيد افتتاحي
            ->when($from != null, function ($q) use ($request) {
                return $q->whereBetween('date', [$request['from'], $request['to']]);
            });
    }

    // استرجاع القيود اليومية مع التفاصيل المتعلقة بالحسابات و الكاتب، مع التصفح (pagination)
    $journalEntries = $query->with('details.account', 'seller') // تضمين التفاصيل المتعلقة بالحسابات والكاتب
        ->latest() // ترتيب القيود حسب التاريخ
        ->paginate(Helpers::pagination_limit()); // تحديد عدد النتائج في الصفحة باستخدام دالة pagination_limit

    // إرجاع العرض مع البيانات المطلوبة
    return view('admin-views.account-payable.add', compact('accounts', 'journalEntries', 'search', 'from', 'to'));
}



    /**
     * @param Request $request
     * @return RedirectResponse
     */

// use App\Models\BusinessSetting; // لو عندك موديل، وإلا هنستخدم جدول الإعدادات مباشرة
public function store(Request $request): RedirectResponse
{
    // ===== 0) صلاحيات =====
    $adminId = Auth::guard('admin')->id();
    $admin   = DB::table('admins')->where('id', $adminId)->first();

    if (!$admin) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }

    $role = DB::table('roles')->where('id', $admin->role_id)->first();
    if (!$role) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }

    $decodedData = json_decode($role->data, true);
    if (is_string($decodedData)) $decodedData = json_decode($decodedData, true);
    if (!is_array($decodedData) || !in_array("start.store", $decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }

    // ===== 1) التحقق من المدخلات =====
    $request->validate([
        'account_id' => 'required|exists:accounts,id',
        'debit'      => 'nullable|numeric|min:0',
        'credit'     => 'nullable|numeric|min:0',
        'entry_date' => 'required|date',
    ]);

    $in_debit  = (float) ($request->input('debit')  ?? 0);
    $in_credit = (float) ($request->input('credit') ?? 0);
    $entryDate = $request->input('entry_date');

   

    DB::beginTransaction();
    try {
        /** @var \App\Models\Account $account */
        $account = $this->account->where('id', $request->account_id)->lockForUpdate()->first();
        if (!$account) {
            Toastr::warning('الحساب غير موجود!');
            DB::rollBack();
            return back();
        }

        // ===== 2) تأكيد أنه "أول مرة" للحساب الهدف =====
        $tranModel = new $this->transection();
        $tranTable = $tranModel->getTable();

        $hasMoves = DB::table($tranTable)->where('account_id', $account->id)->exists();
        $hasTotals = ((float)$account->total_in !== 0.0) ||
                     ((float)$account->total_out !== 0.0) ||
                     ((float)$account->balance !== 0.0);

        // if ($hasMoves || $hasTotals) {
        //     DB::rollBack();
        //     return back()->withErrors(['account' => 'هذا الحساب عليه حركات/أرصدة سابقة. هذه الشاشة مخصصة للتسجيل لأول مرة فقط.'])->withInput();
        // }

        // ===== 3) تجهيز/جلب حساب الرصيد الافتتاحي =====
        $openingAccountId = DB::table('business_settings')
            ->where('key', 'opening_balance_account_id')
            ->lockForUpdate()
            ->value('value');

        $openingAccount = $openingAccountId
            ? $this->account->where('id', $openingAccountId)->lockForUpdate()->first()
            : null;

        if (!$openingAccount) {
            $openingAccount = $this->account
                ->where(function($q){
                    $q->where('account', 'رصيد افتتاحي')
                      ->orWhere('account', 'Opening Balance');
                })
                ->lockForUpdate()
                ->first();
        }

        if (!$openingAccount) {
            $openingAccountId = DB::table('accounts')->insertGetId([
                'account'      => 'رصيد افتتاحي',
                'code'         => 'OB-' . \Carbon\Carbon::now()->format('Y'),
                'account_type' => 'equity',
                'parent_id'    => null,
                'description'  => 'حساب مقابل قيود الأرصدة الافتتاحية',
                'total_in'     => 0,
                'total_out'    => 0,
                'balance'      => 0,
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);

            DB::table('business_settings')->updateOrInsert(
                ['key' => 'opening_balance_account_id'],
                ['value' => $openingAccountId, 'updated_at' => now(), 'created_at' => now()]
            );

            $openingAccount = $this->account->where('id', $openingAccountId)->lockForUpdate()->first();
        }

        // ===== 4) إعداد القيود (أول مرة فقط) =====
        $description = 'قيد رصيد افتتاحي (تسجيل أول مرة)';
        $amount      = $in_debit > 0 ? $in_debit : $in_credit;
        $acc_debit   = $in_debit > 0 ? $amount : 0.0;
        $acc_credit  = $in_credit > 0 ? $amount : 0.0;

        // عكسها على حساب الرصيد الافتتاحي
        $op_debit    = $acc_credit;
        $op_credit   = $acc_debit;

        // أرصدة "قبل" (المفترض صفر للحساب الهدف وفق الشرط أعلاه)
        $acc_before_balance = (float) ($account->balance ?? 0);
        $op_before_balance  = (float) ($openingAccount->balance ?? 0);

        // ===== 5) إنشاء قيد الحساب الأساسي =====
        $t1 = new $this->transection();
        $t1->tran_type       = 1; // Opening Balance
        $t1->seller_id       = $adminId;
        $t1->account_id      = $account->id;
        $t1->amount          = $amount;
        $t1->description     = $description;
        $t1->date            = $entryDate;
        $t1->debit           = $acc_debit;
        $t1->credit          = $acc_credit;
        $t1->debit_account   = $acc_debit;
        $t1->credit_account  = $acc_credit;
        $t1->balance_account = $acc_before_balance;
        $t1->balance         = $acc_before_balance + ($acc_debit - $acc_credit);
        $t1->save();

        // ===== 6) إنشاء قيد حساب الرصيد الافتتاحي =====
        $t2 = new $this->transection();
        $t2->tran_type       = 1;
        $t2->seller_id       = $adminId;
        $t2->account_id      = $openingAccount->id;
        $t2->amount          = $amount;
        $t2->description     = $description . " (مقابل " . ($account->account ?? ('#'.$account->id)) . ")";
        $t2->date            = $entryDate;
        $t2->debit           = $op_debit;
        $t2->credit          = $op_credit;
        $t2->debit_account   = $op_debit;
        $t2->credit_account  = $op_credit;
        $t2->balance_account = $op_before_balance;
        $t2->balance         = $op_before_balance + ($op_debit - $op_credit);
        $t2->save();

        // ===== 7) تحديث مباشر لجدول الحسابات (بدون أي SUM) =====
        // الحساب الهدف
        $account->total_in  = $acc_debit;
        $account->total_out =  $acc_credit;
        $account->balance   = ($acc_debit - $acc_credit);
        $account->save();

        // حساب الرصيد الافتتاحي (العكس)
        $openingAccount->total_in  = (float) ($openingAccount->total_in  ?? 0) + $op_debit;
        $openingAccount->total_out = (float) ($openingAccount->total_out ?? 0) + $op_credit;
        $openingAccount->balance   = (float) ($openingAccount->balance   ?? 0) + ($op_debit - $op_credit);
        $openingAccount->save();

        DB::commit();
        Toastr::success(translate('تم تسجيل الرصيد الافتتاحي لأول مرة بنجاح.'));
        return back();

    } catch (\Throwable $e) {
        DB::rollBack();
        return back()->withErrors(['error' => $e->getMessage()]);
    }
}



    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function transfer(Request $request): RedirectResponse
    {
        $payment_account = $this->account->find($request->payment_account_id);
        $remain_balance = $payment_account->balance - $request->amount;
        if($remain_balance < 0)
        {
            Toastr::warning(translate('Your payment account has not sufficent balance for this transaction'));
            return back();
        }
        $payable_account = $this->account->find($request->account_id);
        $payable_transection = $this->transection->find($request->transection_id);
        $balance = $payable_transection->amount - $request->amount;
        if($balance < 0){
            Toastr::warning(translate('You have not sufficient balance for this transaction'));
            return back();
        }
        $payable_transection->amount = $balance;
        $payable_transection->balance = $payable_transection->balance - $request->amount;
        $payable_transection->save();

        $payable_account->total_out = $payable_account->total_out + $request->amount;
        $payable_account->balance = $payable_account->balance - $request->amount;
        $payable_account->save();

        $transection = $this->transection;
        $transection->tran_type = 'Expense';
        $transection->account_id = $request->payment_account_id;
        $transection->amount = $request->amount;
        $transection->description = $request->description;
        $transection->debit = 1;
        $transection->credit = 0;
        $transection->balance =  $payment_account->balance - $request->amount;
        $transection->date = $request->date;
        $transection->save();

        $payment_account->total_out = $payment_account->total_out + $request->amount;
        $payment_account->balance = $payment_account->balance - $request->amount;
        $payment_account->save();

        Toastr::success(translate('Payable Balance pay successfully'));
        return back();
    }
   public function download(Request $request)
{
    // Ensure the user is authenticated as a seller
    $seller = Auth::guard('admin')->user();

    if (!$seller) {
        abort(403, 'Unauthorized');
    }

    // Fetch accounts and apply filters
    $payables = $this->transection->where('tran_type', 1)->orderBy('id')->get();

    $search = $request->input('search', '');
    $from = $request->input('from');
    $to = $request->input('to');

    $query = $this->transection->where('tran_type', 1);

    if ($search) {
        $key = explode(' ', $search);
        $query->where(function ($q) use ($key) {
            foreach ($key as $value) {
                $q->orWhere('description', 'like', "%{$value}%");
            }
        });
    }

    if ($from && $to) {
        $query->whereBetween('date', [$from, $to]);
    }

    $transactions = $query->get();

    // Render Blade view to generate HTML
    $html = view('admin-views.account-payable.pdf', compact('payables', 'search', 'seller', 'transactions'))->render();

    // Save the HTML content to a temporary file
    $fileName = 'account_report_' . now()->format('Y_m_d_H_i_s') . '.html';
    $filePath = storage_path('app/public/' . $fileName);
    file_put_contents($filePath, $html);

    // Return the file as a response for download
    return response()->download($filePath, $fileName)->deleteFileAfterSend(true);
}


}
