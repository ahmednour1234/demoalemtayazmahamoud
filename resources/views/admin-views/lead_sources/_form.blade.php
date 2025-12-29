{{-- resources/views/admin/lead_sources/_form.blade.php --}}
@php
  use Illuminate\Support\Facades\Schema;
  /** @var \App\Models\LeadSource|null $source */
  $isEdit = isset($source) && $source?->id;
@endphp

<div class="row g-3">
  <div class="col-md-6">
    <label for="lsrc_name" class="form-label">الاسم <span class="text-danger">*</span></label>
    <input id="lsrc_name" name="name" type="text" class="form-control" required
           value="{{ old('name', $source->name ?? '') }}" autocomplete="off">
    @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
  </div>

  <div class="col-md-6">
    <label for="lsrc_code" class="form-label">الكود (Unique) <span class="text-danger">*</span></label>
    <input id="lsrc_code" name="code" type="text" class="form-control" required dir="ltr"
           value="{{ old('code', $source->code ?? '') }}" placeholder="website / ads / referral" autocomplete="off">
    @error('code') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
  </div>

  @if (Schema::hasColumn('lead_sources','sort_order'))
    <div class="col-md-4">
      <label for="lsrc_sort" class="form-label">الترتيب</label>
      <input id="lsrc_sort" name="sort_order" type="number" class="form-control"
             value="{{ old('sort_order', $source->sort_order ?? 100) }}">
      @error('sort_order') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
    </div>
  @endif

  @if (Schema::hasColumn('lead_sources','is_active'))
    <div class="col-md-4 d-flex align-items-end">
      <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" role="switch" id="is_active"
               name="is_active" value="1"
               @checked(old('is_active', ($source->is_active ?? true)))>
        <label class="form-check-label" for="is_active">نشط</label>
      </div>
    </div>
  @endif
</div>
<div class="mt-4 d-flex justify-content-end align-items-center flex-wrap" style="gap:.75rem;">
  <button type="submit" class="btn btn-primary" style="margin-inline-end:.75rem;">
    {{ $isEdit ? 'تحديث' : 'حفظ' }}
  </button>

  <a href="{{ route('admin.lead-sources.index') }}" class="btn btn-light">
    رجوع
  </a>
</div>

