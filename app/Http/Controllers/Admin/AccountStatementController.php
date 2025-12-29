<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Branch;
use App\Models\CostCenter;
use App\Models\JournalEntryDetail;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\CPU\Helpers;
use function App\CPU\translate;
use Illuminate\Support\Facades\Auth;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Carbon\Carbon;

class AccountStatementController extends Controller
{
    public function statement(Request $request)
    {
        // ===== صلاحيات =====
        $adminId = Auth::guard('admin')->id();
        $admin   = DB::table('admins')->where('id', $adminId)->first();

        if (!$admin) {
            Toastr::warning('غير مسموح لك! كلم المدير.');
            return redirect()->back();
        }

        $roleId = $admin->role_id;
        $role   = DB::table('roles')->where('id', $roleId)->first();
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
        if (!in_array("finance.reports.account_statement", $decodedData)) {
            Toastr::warning('غير مسموح لك! كلم المدير.');
            return redirect()->back();
        }

        // ===== الفلاتر =====
        $fromDate    = $request->date('from_date') ?: null;               // Carbon|null
        $toDate      = $request->date('to_date') ?: null;                 // Carbon|null
        $branchId    = $request->integer('branch_id') ?: null;
        $costId      = $request->integer('cost_id') ?: null;
        $writerId    = $request->integer('writer_id') ?: null;
        $descLike    = $request->string('description')->toString() ?: null;

        // من حساب / إلى حساب (اختياري)
        $accountFrom = $request->integer('account_from') ?: null;
        $accountTo   = $request->integer('account_to') ?: null;

        // حساب محدد + خيار يشمل الأبناء
        $accountId    = $request->integer('account_id') ?: null;
        $withChildren = $request->boolean('with_children');

        // مصادر القوائم للفلتر
        $accounts    = Account::orderBy('account')->select('id','account','code','parent_id')->get();
        $branches    = Branch::orderBy('name')->get(['id','name']);
        $costCenters = CostCenter::orderBy('name')->get(['id','name','code']);
        $writers     = Admin::orderBy('f_name')->get(['id','f_name','email']);

        // نحدد مجموعة الحسابات المستهدفة
        $targetAccountIds = [];
        if ($accountId) {
            $targetAccountIds = [$accountId];
            if ($withChildren) {
                $targetAccountIds = array_values(array_unique(array_merge(
                    $targetAccountIds,
                    $this->getDescendantAccountIds($accountId)
                )));
            }
        } elseif ($accountFrom && $accountTo) {
            // (يمكن تغييره للمدى بالكود حسب نظام الشجرة عندك)
            $targetAccountIds = Account::whereBetween('id', [$accountFrom, $accountTo])
                ->pluck('id')->toArray();
        }

        // ===== الاستعلام الأساسي =====
        $q = JournalEntryDetail::query()
            ->withoutGlobalScope(SoftDeletingScope::class) // مهم لو عندك SoftDeletes
            ->from('journal_entries_details as jed')
            ->join('journal_entries as je', 'je.id', '=', 'jed.journal_entry_id')
            ->leftJoin('branches as br', 'br.id', '=', 'je.branch_id')
            ->leftJoin('admins as au', 'au.id',   '=', 'je.created_by')
            ->with([
                'account:id,account,code',
                'costCenter:id,name,code',
            ])
            ->whereNull('jed.deleted_at')
            ->select([
                'jed.*',
                'je.entry_date  as head_date',
                'je.reference   as head_ref',
                'je.description as head_desc',
                'je.created_by  as head_writer',
                'je.branch_id   as head_branch',
                'br.name        as branch_name',
                'au.email       as writer_email',
            ])
            ->orderBy('je.entry_date')
            ->orderBy('jed.id');

        // تطبيق الفلاتر
        if (!empty($targetAccountIds)) {
            $q->whereIn('jed.account_id', $targetAccountIds);
        }
        if ($fromDate) { $q->whereDate('je.entry_date', '>=', $fromDate->toDateString()); }
        if ($toDate)   { $q->whereDate('je.entry_date', '<=', $toDate->toDateString()); }
        if ($branchId) { $q->where('je.branch_id', $branchId); }
        if ($costId)   { $q->where('jed.cost_center_id', $costId); }
        if ($writerId) { $q->where('je.created_by', $writerId); }
        if ($descLike) {
            $q->where(function($qq) use ($descLike){
                $qq->where('jed.description','like',"%{$descLike}%")
                   ->orWhere('je.description','like',"%{$descLike}%")
                   ->orWhere('je.reference','like',"%{$descLike}%");
            });
        }

        $rows = $q->paginate(Helpers::pagination_limit())->appends($request->query());

        // ===== الرصيد الافتتاحي للفترة =====
        $openingBalance = 0.0;
        if ($fromDate && !empty($targetAccountIds)) {
            $openingBalance = $this->computeOpeningBalanceFromTransection(
                fromDate   : $fromDate->toDateString(),
                accountIds : $targetAccountIds,
                branchId   : $branchId,
                costId     : $costId,
                writerId   : $writerId
            );
        }

        // إجماليات الصفحة (المعروضة)
        $pageDebit  = (float) $rows->getCollection()->sum('debit');
        $pageCredit = (float) $rows->getCollection()->sum('credit');

        // بداية الرصيد الجاري (لبناء running balance في الواجهة)
        $runningStart = $openingBalance;
// dd($runningStart);
        return view('admin-views.account.statement', compact(
            'rows','accounts','branches','costCenters','writers',
            'openingBalance','pageDebit','pageCredit','runningStart'
        ));
    }

    /**
     * الرصيد الافتتاحي = آخر قيد افتتاحي (tran_type = 1) من جدول transection
     * لكل حساب مستهدف (حتى fromDate) + حركة الحساب من بعد تاريخ هذا القيد
     * وحتى قبل fromDate (من قيود اليوميات).
     *
     * ملاحظات:
     * - يدعم اختلاف اسم عمود الحساب في transection بين account_id و account_Id.
     * - لو لا يوجد قيد افتتاحي: الأساس = 0، ونضيف (اختياريًا) حركة ما قبل fromDate.
     */
    private function computeOpeningBalanceFromTransection(
        string $fromDate,
        array $accountIds,
        ?int $branchId = null,
        ?int $costId   = null,
        ?int $writerId = null
    ): float {
        $totalOpening = 0.0;

        foreach ($accountIds as $accId) {
            // 1) آخر قيد افتتاحي قبل/عند fromDate من جدول transection (tran_type = 1)
            $open = DB::table('transections')
                ->where('tran_type', 1)
                ->where(function ($q) use ($accId) {
                    // دعم account_id أو account_Id
                    $q->where('account_id', $accId)
                      ->orWhere('account_id_to', $accId);
                })
                ->orderByDesc('created_at')
                ->orderByDesc('id')
                ->limit(1)
                ->first();

            $base            = 0.0; // Debit - Credit للقيد الافتتاحي
            $openCreatedDate = null;

            if ($open) {
                $openDebit  = (float) ($open->debit  ?? 0);
                $openCredit = (float) ($open->credit ?? 0);
                $base            = $openDebit - $openCredit; // (+) مدين / (-) دائن
                $openCreatedDate = Carbon::parse($open->created_at)->toDateString();
            }

            // 2) حركة الحساب من بعد (أو بدءًا من) تاريخ القيد الافتتاحي وحتى قبل fromDate
            $movQ = JournalEntryDetail::query()
                ->from('journal_entries_details as jed')
                ->join('journal_entries as je', 'je.id', '=', 'jed.journal_entry_id')
                ->where('jed.account_id', $accId)
                ->whereDate('je.entry_date', '<', $fromDate);

            if ($openCreatedDate) {
                // نبدأ من تاريخ الافتتاحي نفسه (لأن الافتتاحي في جدول مستقل، فلن يتكرر هنا)
                $movQ->whereDate('je.entry_date', '>=', $openCreatedDate);
            }

            // تطبيق نفس الفلاتر (اختياري على الحركة)
            if ($branchId) { $movQ->where('je.branch_id', $branchId); }
            if ($costId)   { $movQ->where('jed.cost_center_id', $costId); }
            if ($writerId) { $movQ->where('je.created_by', $writerId); }

            $sumMovDebit  = (float) $movQ->clone()->sum('jed.debit');
            $sumMovCredit = (float) $movQ->clone()->sum('jed.credit');
            $movement     = $sumMovDebit - $sumMovCredit;

            $accOpening   = $base + $movement;
            $totalOpening += $accOpening;
        }

        return (float) $totalOpening;
    }

    /**
     * رجّع IDs لكل أحفاد الحساب (Loop بسيط).
     * لو عندك Nested Set أو Closure Table استبدلها بما يناسب.
     */
    private function getDescendantAccountIds(int $parentId): array
    {
        $all   = Account::select('id','parent_id')->get()->groupBy('parent_id');
        $stack = [$parentId];
        $desc  = [];

        while ($stack) {
            $pid = array_pop($stack);
            foreach (($all[$pid] ?? []) as $child) {
                $desc[]  = $child->id;
                $stack[] = $child->id;
            }
        }
        return $desc;
    }
}
