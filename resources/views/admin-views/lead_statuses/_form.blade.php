@php
  /** @var \App\Models\LeadStatus|null $status */
  $isEdit = isset($status) && $status?->id;
@endphp

<div class="row g-3">
  {{-- الاسم --}}
  <div class="col-md-6">
    <label for="ls_name" class="form-label">الاسم <span class="text-danger">*</span></label>
    <input id="ls_name"
           name="name"
           type="text"
           class="form-control"
           required
           autocomplete="off"
           value="{{ old('name', $status->name ?? '') }}"
           placeholder="مثال: جديد / تم التواصل / مؤهل">
    @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
  </div>

  {{-- الكود --}}
  <div class="col-md-6">
    <label for="ls_code" class="form-label">الكود (Unique) <span class="text-danger">*</span></label>
    <input id="ls_code"
           name="code"
           type="text"
           class="form-control"
           required
           autocomplete="off"
           dir="ltr"
           value="{{ old('code', $status->code ?? '') }}"
           placeholder="new / contacted / qualified">
    @error('code') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
  </div>

  {{-- الترتيب --}}
  <div class="col-md-4">
    <label for="ls_sort" class="form-label">الترتيب</label>
    <input id="ls_sort"
           name="sort_order"
           type="number"
           class="form-control"
           inputmode="numeric"
           step="1"
           min="0"
           value="{{ old('sort_order', $status->sort_order ?? 100) }}"
           placeholder="مثال: 100">
    @error('sort_order') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
  </div>

  {{-- نشط (سويتش) --}}
  <div class="col-md-4 d-flex align-items-end">
    <div class="form-check form-switch">
      <input class="form-check-input"
             type="checkbox"
             role="switch"
             id="is_active"
             name="is_active"
             value="1"
             @checked(old('is_active', ($status->is_active ?? true)))>
      <label class="form-check-label" for="is_active">نشط</label>
    </div>
  </div>
</div>

{{-- أزرار الإجراءات — يمين وبمسافة بينهما --}}
<div class="mt-4 d-flex justify-content-end align-items-center flex-wrap" style="gap:.75rem;">
  <button type="submit" class="btn btn-primary" style="margin-inline-end:.75rem;">
    {{ $isEdit ? 'تحديث' : 'حفظ' }}
  </button>

  <a href="{{ route('admin.lead-statuses.index') }}" class="btn btn-light">
    رجوع
  </a>
</div>

