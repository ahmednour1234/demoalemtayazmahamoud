@php
  /** @var \App\Models\LeadNote|null $note */
  $isEdit = isset($note) && $note?->id;
@endphp

<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-3">
  <div class="card-body p-4">
    <div class="row g-3">
      <div class="col-lg-6">
        <label class="form-label">العميل المحتمل <span class="text-danger">*</span></label>
        <select name="lead_id" class="form-select js-select2" data-placeholder="اختر Lead" required>
          <option value=""></option>
          @foreach($leads as $ld)
            <option value="{{ $ld->id }}" @selected(old('lead_id', $note->lead_id ?? request('lead_id'))==$ld->id)>
              {{ $ld->contact_name ?: $ld->company_name }} — {{ $ld->country_code }} {{ $ld->phone }}
            </option>
          @endforeach
        </select>
        @error('lead_id') <div class="text-danger small">{{ $message }}</div> @enderror
      </div>

      <div class="col-lg-6">
        <label class="form-label">المسؤول</label>
        <select name="admin_id" class="form-select js-select2" data-placeholder="اختر المسؤول">
          <option value=""></option>
          @foreach($admins as $ad)
            <option value="{{ $ad->id }}" @selected(old('admin_id', $note->admin_id ?? ($defaultAdminId ?? ''))==$ad->id)>{{ $ad->email }}</option>
          @endforeach
        </select>
        @error('admin_id') <div class="text-danger small">{{ $message }}</div> @enderror
      </div>

      <div class="col-lg-12">
        <label class="form-label">الملاحظة <span class="text-danger">*</span></label>
        <textarea name="note" rows="4" class="form-control @error('note') is-invalid @enderror" placeholder="اكتب الملاحظة هنا...">{{ old('note', $note->note ?? '') }}</textarea>
        @error('note') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      <div class="col-md-4">
        <label class="form-label">إظهار الملاحظة</label>
        <select name="visibility" class="form-select js-select2" data-placeholder="اختر">
          @foreach($visibilities as $k=>$lbl)
            <option value="{{ $k }}" @selected(old('visibility', $note->visibility ?? 'private')===$k)>{{ $lbl }}</option>
          @endforeach
        </select>
        @error('visibility') <div class="text-danger small">{{ $message }}</div> @enderror
      </div>
    </div>
  </div>
</div>

{{-- حقول مخصّصة (يعتمد على الكمبوننت اللي عندك) --}}
@include('admin-views.components.custom-fields', [
  'model'      => $note ?? null,
  'appliesTo'  => \App\Models\LeadNote::class,
  'namePrefix' => 'custom_fields',
])

{{-- أشرطة أصول وانتربرايز --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
<style>
  .select2-container{ width:100%!important }
  .form-label.required::after{ content:" *"; color:#d6336c; font-weight:600; }
  .sticky-actions{ position:sticky; bottom:0; padding:12px 0; background:linear-gradient(180deg, rgba(255,255,255,0), #fff 45%); z-index:9; border-top:1px solid rgba(0,0,0,.075); }
</style>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.full.min.js"></script>
<script>
  (function(){
    const $ = window.jQuery;
    if ($ && $.fn.select2) {
      $('.js-select2').each(function(){
        const $el = $(this);
        $el.select2({
          dir:'rtl', width:'100%', theme:'bootstrap-5', allowClear:true,
          placeholder:$el.data('placeholder')||'', language:{ noResults:()=> 'لا توجد نتائج' }
        });
      });
    }
  })();
</script>
