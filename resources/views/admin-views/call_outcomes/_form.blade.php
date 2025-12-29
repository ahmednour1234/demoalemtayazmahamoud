@php $isEdit = isset($outcome) && $outcome?->id; @endphp
<div class="row g-3">
  <div class="col-md-6">
    <label class="form-label">الاسم <span class="text-danger">*</span></label>
    <input name="name" class="form-control" required value="{{ old('name', $outcome->name ?? '') }}">
    @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
  </div>

  <div class="col-md-6">
    <label class="form-label">الكود <span class="text-danger">*</span></label>
    <input name="code" class="form-control" required value="{{ old('code', $outcome->code ?? '') }}" placeholder="answered / no_answer / busy">
    @error('code') <div class="text-danger small">{{ $message }}</div> @enderror
  </div>

  <div class="col-md-4">
    <label class="form-label">الترتيب</label>
    <input name="sort_order" type="number" class="form-control" value="{{ old('sort_order', $outcome->sort_order ?? 100) }}">
    @error('sort_order') <div class="text-danger small">{{ $message }}</div> @enderror
  </div>

  <div class="col-md-4 d-flex align-items-end">
    <div class="form-check form-switch">
      <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" @checked(old('is_active', $outcome->is_active ?? true))>
      <label class="form-check-label" for="is_active">نشط</label>
    </div>
  </div>
</div>

<div class="mt-4 d-flex justify-content-end align-items-center" style="gap:.5rem;">
  <button class="btn btn-primary">{{ $isEdit ? 'تحديث' : 'حفظ' }}</button>
  <a href="{{ route('admin.call-outcomes.index') }}" class="btn btn-light">رجوع</a>
</div>
