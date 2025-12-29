@php
    $isEdit = filled($project ?? null);
@endphp

@push('css_or_js')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
<style>
    .label-req:after{content:" *";color:#dc3545}
</style>
@endpush

<form action="{{ $action }}" method="POST">
    @csrf
    @if(($method ?? 'POST') !== 'POST') @method($method) @endif

    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label label-req">الاسم</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $project->name ?? '') }}" required>
        </div>
        <div class="col-md-6">
            <label class="form-label label-req">الكود</label>
            <input type="text" name="code" class="form-control" value="{{ old('code', $project->code ?? '') }}" required>
        </div>

        <div class="col-md-12">
            <label class="form-label">الوصف</label>
            <textarea name="description" rows="3" class="form-control">{{ old('description', $project->description ?? '') }}</textarea>
        </div>

        <div class="col-md-4">
            <label class="form-label">الحالة</label>
            <select name="status_id" class="form-control js-select2" data-placeholder="— اختر —">
                <option value="">—</option>
                @foreach($statuses as $s)
                    <option value="{{ $s->id }}" @selected(old('status_id', $project->status_id ?? null)==$s->id)>{{ $s->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4">
            <label class="form-label label-req">المالك</label>
            <select name="owner_id" class="form-control js-select2" data-placeholder="— اختر —" required>
                <option value="">—</option>
                @foreach($owners as $o)
                    <option value="{{ $o->id }}" @selected(old('owner_id', $project->owner_id ?? null)==$o->id)>{{ $o->f_name }} {{ $o->l_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4">
            <label class="form-label">الأولوية</label>
            <select name="priority" class="form-control js-select2">
                @foreach(['low'=>'منخفض','medium'=>'متوسط','high'=>'مرتفع','urgent'=>'عاجل'] as $k=>$v)
                    <option value="{{ $k }}" @selected(old('priority', $project->priority ?? 'medium')==$k)>{{ $v }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-6">
            <label class="form-label">تاريخ البدء</label>
            <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $project->start_date ?? '') }}">
        </div>
        <div class="col-md-6">
            <label class="form-label">تاريخ الاستحقاق</label>
            <input type="date" name="due_date" class="form-control" value="{{ old('due_date', $project->due_date ?? '') }}">
        </div>

        <div class="col-md-6">
            <label class="form-label">نشط؟</label>
            <select name="active" class="form-control js-select2">
                <option value="1" @selected(old('active', ($project->active ?? 1))==1)>نعم</option>
                <option value="0" @selected(old('active', ($project->active ?? 1))==0)>لا</option>
            </select>
        </div>
    </div>

    <div class="d-flex justify-content-end mt-4 gap-2">
        <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-secondary px-4">إلغاء</a>
        <button type="submit" class="btn btn-primary px-4">{{ $isEdit ? 'تحديث' : 'حفظ' }}</button>
    </div>
</form>

@push('script_2')
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.full.min.js"></script>
<script>
$(function(){
  $('.js-select2').select2({dir:'rtl',width:'100%',allowClear:true,placeholder:function(){return $(this).data('placeholder')||'';}});
});
</script>
@endpush
