<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Transection;
use App\Services\AdminPermissionService;
use App\Services\ReportOptionsService;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncomeStatementController extends Controller
{
    public function __construct(
        private AdminPermissionService $permissionService,
        private ReportOptionsService $reportOptionsService
    ) {}

    public function index(Request $request)
    {
        // =========================
        // Permission Check (Service)
        // =========================
        $adminId = Auth::guard('admin')->id();

        if (! $adminId || ! $this->permissionService->adminHasPermission($adminId, 'kamtdakhl.report')) {
            Toastr::warning('غير مسموح لك! كلم المدير.');
            return redirect()->back();
        }

        // =========================
        // Options (Report + Company Profile + Signatures)
        // =========================
        // لو اسم الدالة عندك resolve خليها resolve
        $reportOptions = method_exists($this->reportOptionsService, 'fromRequest')
            ? $this->reportOptionsService->fromRequest($request)
            : $this->reportOptionsService->resolve($request);

        // =========================
        // Default Dates
        // =========================
        $startDate = $request->input('start_date') ?? Carbon::now()->startOfMonth()->toDateString();
        $endDate   = $request->input('end_date') ?? Carbon::now()->toDateString();

        // مهم: نخلي endDate لآخر اليوم عشان مايفوتش معاملات اليوم
        $endDateTime = Carbon::parse($endDate)->endOfDay();

        // =========================
        // Show filters page first
        // preview=1 => build report
        // =========================
        $preview = $request->boolean('preview');

        if (! $preview) {
            return view('admin-views.reports.income_statement', compact(
                'startDate',
                'endDate',
                'reportOptions'
            ));
        }

        // ============================================================
        // Build report (only when preview = 1)
        // ============================================================

        // =========================
        // Revenues (account_type = revenue)
        // =========================
        $revenueAccounts = Account::where('account_type', 'revenue')->get();

        $revenuesData  = [];
        $totalRevenues = 0;

        foreach ($revenueAccounts as $revenueAccount) {
            $accountIds = $this->getAccountTreeIds($revenueAccount->id);

            $lastBalance = $this->getLastBalanceForGroup($accountIds, $endDateTime);

            $revenuesData[] = [
                'account'     => $revenueAccount,
                'lastBalance' => $lastBalance,
            ];

            $totalRevenues += $lastBalance;
        }

        // =========================
        // COGS (Account #47 + descendants)
        // =========================
        $cogsAccountId = 47;
        $cogsAccount   = Account::find($cogsAccountId);

        $cogsAccountIds  = $this->getAccountTreeIds($cogsAccountId);
        $cogsLastBalance = $this->getLastBalanceForGroup($cogsAccountIds, $endDateTime);

        // =========================
        // Gross Profit
        // =========================
        $grossProfit = $totalRevenues - $cogsLastBalance;

        // =========================
        // OPEX (Account #44 + descendants) EXCLUDING COGS tree
        // =========================
        $opexRootId  = 44;
        $opexAccount = Account::find($opexRootId);

        $opexGroupIds = $this->getAccountTreeIds($opexRootId);
        // استبعاد شجرة COGS بالكامل
        $opexGroupIds = array_values(array_diff($opexGroupIds, $cogsAccountIds));

        // ✅ حساب رصيد المجموعة مرة واحدة (زي COGS/Tax/NonOpEx)
        $totalOpex = $this->getLastBalanceForGroup($opexGroupIds, $endDateTime);

        // =========================
        // Non-OPEX (Account #45 + descendants)
        // =========================
        $nonOpExAccountId = 45;
        $nonOpExAccount   = Account::find($nonOpExAccountId);

        $nonOpExGroupIds = $this->getAccountTreeIds($nonOpExAccountId);
        $totalNonOpEx    = $this->getLastBalanceForGroup($nonOpExGroupIds, $endDateTime);

        // =========================
        // Income before/after Non-OPEX
        // =========================
        $incomeBeforeNonOpEx = $grossProfit - $totalOpex;
        $incomeAfterNonOpEx  = $incomeBeforeNonOpEx - $totalNonOpEx;

        // =========================
        // Taxes (Account #28 + descendants)
        // =========================
        $taxAccountId = 28;
        $taxAccount   = Account::find($taxAccountId);

        $taxGroupIds = $this->getAccountTreeIds($taxAccountId);
        $taxDue      = $this->getLastBalanceForGroup($taxGroupIds, $endDateTime);

        // =========================
        // Net Profit
        // =========================
        $netProfit = $incomeAfterNonOpEx - $taxDue;

        return view('admin-views.reports.income_statement', compact(
            'startDate',
            'endDate',
            'reportOptions',
            'revenuesData',
            'totalRevenues',
            'cogsAccount',
            'cogsLastBalance',
            'grossProfit',
            'opexAccount',
            'totalOpex',
            'nonOpExAccount',
            'totalNonOpEx',
            'incomeBeforeNonOpEx',
            'incomeAfterNonOpEx',
            'taxAccount',
            'taxDue',
            'netProfit',
            'cogsAccountIds'
        ));
    }

    /**
     * Return root + all descendant IDs (children, grandchildren...)
     */
    private function getAccountTreeIds(int $rootId): array
    {
        return array_merge([$rootId], $this->getDescendantIds($rootId));
    }

    /**
     * Get all descendants ids for an account (children + grandchildren...)
     */
    private function getDescendantIds(int $accountId): array
    {
        $descendants = Account::where('parent_id', $accountId)->get(['id']);
        $ids = [];

        foreach ($descendants as $child) {
            $ids[] = $child->id;
            $ids = array_merge($ids, $this->getDescendantIds($child->id));
        }

        return $ids;
    }

    /**
     * Get last balance for a group of account IDs by checking last transaction
     * either in account_id or account_id_to, then return the correct balance field.
     */
    private function getLastBalanceForGroup(array $accountIds, Carbon $endDateTime): float
    {
        if (empty($accountIds)) {
            return 0.0;
        }

        $lastTransaction = Transection::where(function ($query) use ($accountIds) {
                $query->whereIn('account_id', $accountIds)
                      ->orWhereIn('account_id_to', $accountIds);
            })
            ->where('created_at', '<=', $endDateTime)
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->first();

        if (! $lastTransaction) {
            return 0.0;
        }

        if (in_array($lastTransaction->account_id, $accountIds, true)) {
            return (float) $lastTransaction->balance;
        }

        if (in_array($lastTransaction->account_id_to, $accountIds, true)) {
            return (float) $lastTransaction->balance_account;
        }

        return 0.0;
    }
}
