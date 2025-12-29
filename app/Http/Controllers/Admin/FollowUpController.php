<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\WithAdminGate;
use App\Models\FollowUp;
use App\Models\Admin;
use App\Models\Task;
use App\Models\Project;
use App\Models\Lead;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Services\NotificationService;

class FollowUpController extends Controller
{
    use WithAdminGate;

    public function index(Request $request)
    {
        if ($resp = $this->ensurePermissionOrBack($request, 'task.followup')) return $resp;

        $status   = $request->query('status');
        $assignee = $request->query('assigned_to');

        $query = FollowUp::with(['task:id,title','project:id,name','lead:id,name','creator:id,f_name,l_name','owner:id,f_name,l_name'])
            ->when($status, fn($q) => $q->where('status', $status))
            ->when($assignee, fn($q) => $q->where('assigned_to', $assignee))
            ->orderBy('next_follow_up_at');

        $followups = $query->paginate(20)->withQueryString();
        $admins = Admin::select('id','f_name','l_name')->orderBy('f_name')->get();

        return view('admin-views.followups.index', compact('followups', 'admins', 'status', 'assignee'));
    }

    public function create(Request $request)
    {
        if ($resp = $this->ensurePermissionOrBack($request, 'task.followup')) return $resp;

        return view('admin-views.followups.create', [
            'tasks'    => Task::select('id','title')->orderBy('id','desc')->get(),
            'projects' => Project::select('id','name')->orderBy('name')->get(),
            'leads'    => Lead::select('id','name')->orderBy('name')->get(),
            'admins'   => Admin::select('id','f_name','l_name')->orderBy('f_name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        if ($resp = $this->ensurePermissionOrBack($request, 'task.followup')) return $resp;

        $data = $request->validate([
            'task_id'    => ['nullable','exists:tasks,id'],
            'project_id' => ['nullable','exists:projects,id'],
            'lead_id'    => ['nullable','exists:leads,id'],
            'assigned_to'=> ['nullable','exists:admins,id'],
            'next_follow_up_at' => ['required','date'],
            'comment'    => ['nullable','string'],
        ]);

        $data['created_by'] = Auth::guard('admin')->id();
        $data['status'] = FollowUp::STATUS_SCHEDULED;

        $fu = FollowUp::create($data);

        // إشعار للمسؤول عن المتابعة (لو محدد)
        if (!empty($fu->assigned_to)) {
            NotificationService::push(
                $fu->assigned_to,
                'followup.assigned',
                'تم تعيين متابعة جديدة',
                $fu->comment,
                ['followup_id' => $fu->id, 'task_id' => $fu->task_id, 'project_id' => $fu->project_id, 'lead_id'=>$fu->lead_id]
            );
        }

        $this->log('followup.store','follow_ups',$fu->id, ['assigned_to'=>$fu->assigned_to], $request);
        Toastr::success('تم إنشاء متابعة بنجاح');
        return redirect()->back();
    }

    public function edit(Request $request, FollowUp $followup)
    {
        if ($resp = $this->ensurePermissionOrBack($request, 'task.followup')) return $resp;

        return view('admin-views.followups.edit', [
            'followup' => $followup,
            'tasks'    => Task::select('id','title')->orderBy('id','desc')->get(),
            'projects' => Project::select('id','name')->orderBy('name')->get(),
            'leads'    => Lead::select('id','name')->orderBy('name')->get(),
            'admins'   => Admin::select('id','f_name','l_name')->orderBy('f_name')->get(),
        ]);
    }

    public function update(Request $request, FollowUp $followup)
    {
        if ($resp = $this->ensurePermissionOrBack($request, 'task.followup')) return $resp;

        $data = $request->validate([
            'task_id'    => ['nullable','exists:tasks,id'],
            'project_id' => ['nullable','exists:projects,id'],
            'lead_id'    => ['nullable','exists:leads,id'],
            'assigned_to'=> ['nullable','exists:admins,id'],
            'next_follow_up_at' => ['required','date'],
            'status'     => ['required','in:scheduled,done,skipped,lost'],
            'comment'    => ['nullable','string'],
            'lost_reason'=> ['nullable','string','max:255'],
        ]);

        if ($data['status'] === FollowUp::STATUS_LOST && empty($data['lost_reason'])) {
            return back()->withErrors(['lost_reason' => 'برجاء إدخال سبب الضياع'])->withInput();
        }

        if ($data['status'] === FollowUp::STATUS_LOST) {
            $data['lost_at'] = now();
        } else {
            $data['lost_at'] = null;
            $data['lost_reason'] = null;
        }

        $followup->update($data);

        // إشعار عند التحويل لـ lost
        if ($followup->status === FollowUp::STATUS_LOST) {
            // إشعار لليدر/السوبر أدمن؟ (لو عندك IDs لهم — هنا بنرسل لصاحب التعيين وصاحب الإنشاء كأبسط حل)
            foreach (array_filter([$followup->assigned_to, $followup->created_by]) as $uid) {
                NotificationService::push(
                    $uid,
                    'followup.lost',
                    'متابعة ضاعت',
                    $followup->lost_reason,
                    ['followup_id'=>$followup->id]
                );
            }
        }

        $this->log('followup.update','follow_ups',$followup->id, ['status'=>$followup->status], $request);
        Toastr::success('تم تحديث المتابعة');
        return redirect()->back();
    }

    public function destroy(Request $request, FollowUp $followup)
    {
        if ($resp = $this->ensurePermissionOrBack($request, 'task.followup')) return $resp;

        $followup->delete();
        $this->log('followup.destroy','follow_ups',$followup->id, [], $request);
        Toastr::success('تم حذف المتابعة');
        return back();
    }
}
