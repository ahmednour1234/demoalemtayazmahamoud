{{-- resources/views/admin-views/statuses/_form.blade.php --}}
@php
    $isEdit = isset($status) && $status?->id;
@endphp

<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">الاسم <span class="text-danger">*</span></label>
        <input type="text" name="name" class="form-control" required
               value="{{ old('name', $status->name ?? '') }}" placeholder="مثال: جديد / تحت التنفيذ / منتهي">
    </div>

    <div class="col-md-6">
        <label class="form-label">الكود (فريد) <span class="text-danger">*</span></label>
        <input type="text" name="code" class="form-control" required
               value="{{ old('code', $status->code ?? '') }}" placeholder="مثال: new, in_progress, done">
    </div>

    <div class="col-md-4">
        <label class="form-label">اللون (اختياري)</label>
        <input type="text" name="color" class="form-control"
               value="{{ old('color', $status->color ?? '') }}" placeholder="#22c55e">
    </div>

    <div class="col-md-4">
        <label class="form-label">ترتيب العرض</label>
        <input type="number" name="sort_order" class="form-control"
               value="{{ old('sort_order', $status->sort_order ?? 0) }}">
    </div>

    <div class="col-md-4">
        <label class="form-label d-block">نشط؟</label>
        <select name="active" class="form-select">
            <option value="1" @selected(old('active', $status->active ?? 1)==1)>نشط</option>
            <option value="0" @selected(old('active', $status->active ?? 1)==0)>متوقف</option>
        </select>
    </div>
</div>

<div class="d-flex justify-content-end mt-4 gap-2">
    <a href="{{ route('admin.status.index') }}" class="btn btn-outline-secondary">رجوع</a>
    <button type="submit" class="btn btn-primary">{{ $isEdit ? 'تحديث' : 'حفظ' }}</button>
</div>
