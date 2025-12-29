<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\WithAdminGate;
use App\Models\Approval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Brian2694\Toastr\Facades\Toastr;
use App\Services\NotificationService;

class ApprovalController extends Controller
{
    use WithAdminGate;

    public function index(Request $request)
    {
        if ($resp = $this->ensurePermissionOrBack($request, 'task.approve')) return $resp;

        $status = $request->query('status');
        $approvals = Approval::with(['requester:id,f_name,l_name','approver:id,f_name,l_name'])
            ->when($status, fn($q) => $q->where('status', $status))
            ->orderByDesc('id')
            ->paginate(20)->withQueryString();

        return view('admin-views.approvals.index', compact('approvals','status'));
    }

    /** طلب اعتماد */
    public function store(Request $request)
    {
        if ($resp = $this->ensurePermissionOrBack($request, 'task.approve')) return $resp;

        $data = $request->validate([
            'approvable_type' => ['required','in:task,project,lead'],
            'approvable_id'   => ['required','integer'],
            'approver_id'     => ['required','exists:admins,id'],
            'reason'          => ['nullable','string','max:255'],
            'next_step_hint'  => ['nullable','string','max:255'],
        ]);

        $approval = Approval::create([
            'approvable_type' => $data['approvable_type'],
            'approvable_id'   => $data['approvable_id'],
            'requested_by'    => Auth::guard('admin')->id(),
            'approver_id'     => $data['approver_id'],
            'status'          => Approval::STATUS_PENDING,
            'reason'          => $data['reason'] ?? null,
            'next_step_hint'  => $data['next_step_hint'] ?? null,
        ]);

        // إشعار للموافق
        NotificationService::push(
            $approval->approver_id,
            'approval.request',
            'طلب اعتماد جديد',
            $approval->reason,
            ['approval_id'=>$approval->id] + $data
        );

        $this->log('approval.store','approvals',$approval->id, $data, $request);
        Toastr::success('تم إرسال طلب الاعتماد');
        return back();
    }

    /** قرار (اعتماد/رفض) */
    public function decide(Request $request, Approval $approval)
    {
        if ($resp = $this->ensurePermissionOrBack($request, 'task.approve')) return $resp;

        $data = $request->validate([
            'decision' => ['required','in:approved,rejected'],
            'reason'   => ['nullable','string','max:255'],
            'next_step_hint' => ['nullable','string','max:255'],
        ]);

        $approval->status = $data['decision'] === 'approved'
            ? Approval::STATUS_APPROVED
            : Approval::STATUS_REJECTED;

        $approval->reason = $data['reason'] ?? $approval->reason;
        $approval->next_step_hint = $data['next_step_hint'] ?? $approval->next_step_hint;
        $approval->decided_at = now();
        $approval->save();

        // إشعار لطالب الاعتماد
        NotificationService::push(
            $approval->requested_by,
            'approval.decision',
            $approval->status === Approval::STATUS_APPROVED ? 'تمت الموافقة' : 'تم الرفض',
            $approval->reason,
            ['approval_id'=>$approval->id,'status'=>$approval->status,'next_step_hint'=>$approval->next_step_hint]
        );

        $this->log('approval.decide','approvals',$approval->id, ['status'=>$approval->status], $request);
        Toastr::success('تم تسجيل القرار');
        return back();
    }

    public function destroy(Request $request, Approval $approval)
    {
        if ($resp = $this->ensurePermissionOrBack($request, 'task.approve')) return $resp;

        $approval->delete();
        $this->log('approval.destroy','approvals',$approval->id, [], $request);
        Toastr::success('تم حذف طلب الاعتماد');
        return back();
    }
}
