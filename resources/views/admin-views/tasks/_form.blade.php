@php $isEdit = filled($task ?? null); @endphp

@push('css_or_js')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
<style>.label-req:after{content:" *";color:#dc3545}</style>
@endpush

<form action="{{ $action }}" method="POST">
    @csrf
    @if(($method ?? 'POST') !== 'POST') @method($method) @endif

    <div class="row g-3">
        <div class="col-md-8">
            <label class="form-label label-req">العنوان</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $task->title ?? '') }}" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">المشروع</label>
            <select name="project_id" class="form-control js-select2" data-placeholder="— بدون —">
                <option value="">—</option>
                @foreach($projects as $p)
                    <option value="{{ $p->id }}" @selected(old('project_id', $task->project_id ?? null)==$p->id)>{{ $p->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-12">
            <label class="form-label">الوصف</label>
            <textarea name="description" rows="3" class="form-control">{{ old('description', $task->description ?? '') }}</textarea>
        </div>

        <div class="col-md-3">
            <label class="form-label">الحالة</label>
            <select name="status_id" class="form-control js-select2" data-placeholder="— اختر —">
                <option value="">—</option>
                @foreach($statuses as $s)
                    <option value="{{ $s->id }}" @selected(old('status_id', $task->status_id ?? null)==$s->id)>{{ $s->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <label class="form-label label-req">الأولوية</label>
            <select name="priority" class="form-control js-select2">
                @foreach(['low'=>'منخفض','medium'=>'متوسط','high'=>'مرتفع','urgent'=>'عاجل'] as $k=>$v)
                    <option value="{{ $k }}" @selected(old('priority', $task->priority ?? 'medium')==$k)>{{ $v }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <label class="form-label">يبدأ في</label>
            <input type="datetime-local" name="start_at" class="form-control" value="{{ old('start_at', isset($task->start_at)?\Carbon\Carbon::parse($task->start_at)->format('Y-m-d\TH:i'):'') }}">
        </div>
        <div class="col-md-3">
            <label class="form-label">الاستحقاق</label>
            <input type="datetime-local" name="due_at" class="form-control" value="{{ old('due_at', isset($task->due_at)?\Carbon\Carbon::parse($task->due_at)->format('Y-m-d\TH:i'):'') }}">
        </div>

        <div class="col-md-3">
            <label class="form-label">تقدير الدقائق</label>
            <input type="number" min="0" name="estimated_minutes" class="form-control" value="{{ old('estimated_minutes', $task->estimated_minutes ?? '') }}">
        </div>

        <div class="col-md-3">
            <label class="form-label">يتطلب موافقة؟</label>
            <select name="approval_required" class="form-control js-select2">
                <option value="0" @selected(old('approval_required', $task->approval_required ?? 0)==0)>لا</option>
                <option value="1" @selected(old('approval_required', $task->approval_required ?? 0)==1)>نعم</option>
            </select>
        </div>

        @if($isEdit)
        <div class="col-md-3">
            <label class="form-label">حالة الموافقة</label>
            <select name="approval_status" class="form-control js-select2">
                @foreach(['pending'=>'قيد المراجعة','approved'=>'موافق عليه','rejected'=>'مرفوض'] as $k=>$v)
                    <option value="{{ $k }}" @selected(old('approval_status', $task->approval_status ?? 'pending')==$k)>{{ $v }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">سبب الرفض (إن وجد)</label>
            <input type="text" name="rejection_reason" class="form-control" value="{{ old('rejection_reason', $task->rejection_reason ?? '') }}">
        </div>
        <div class="col-md-6">
            <label class="form-label">الخطوة التالية المقترحة</label>
            <input type="text" name="next_step_hint" class="form-control" value="{{ old('next_step_hint', $task->next_step_hint ?? '') }}">
        </div>
        @endif

        <div class="col-md-6">
            <label class="form-label">إسناد إلى</label>
            <select name="assignees[]" class="form-control js-select2" multiple data-placeholder="— اختر المستخدمين —">
                @php
                    $selectedAssignees = $isEdit ? $task->assignees->pluck('admin_id')->all() : (array)old('assignees',[]);
                @endphp
                @foreach($assignees as $u)
                    <option value="{{ $u->id }}" @selected(in_array($u->id, $selectedAssignees))>{{ $u->f_name }} {{ $u->l_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-6">
            <label class="form-label">نشطة؟</label>
            <select name="active" class="form-control js-select2">
                <option value="1" @selected(old('active', $task->active ?? 1)==1)>نعم</option>
                <option value="0" @selected(old('active', $task->active ?? 1)==0)>لا</option>
            </select>
        </div>
    </div>

    <div class="d-flex justify-content-end mt-4 gap-2">
        <a href="{{ route('admin.tasks.index') }}" class="btn btn-outline-secondary px-4">إلغاء</a>
        <button type="submit" class="btn btn-primary px-4">{{ $isEdit ? 'تحديث' : 'حفظ' }}</button>
    </div>
</form>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.full.min.js"></script>
<script>
$(function(){
  $('.js-select2').select2({dir:'rtl',width:'100%',allowClear:true,placeholder:function(){return $(this).data('placeholder')||'';}});
});
</script>
