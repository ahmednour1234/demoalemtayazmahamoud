{{-- resources/views/admin/leads/import.blade.php --}}
@extends('layouts.admin.app')
@section('title','استيراد عملاء محتملين')

@section('content')
<div class="content container-fluid">

  {{-- Breadcrumb --}}
  <div class="mb-3">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb bg-white px-3 py-2 rounded shadow-sm">
        <li class="breadcrumb-item">
          <a href="{{ route('admin.dashboard') }}" class="text-secondary">
            <i class="tio-home-outlined"></i> {{ \App\CPU\translate('الرئيسية') }}
          </a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
          {{ \App\CPU\translate('استيراد عملاء محتملين') }}
        </li>
      </ol>
    </nav>
  </div>

  {{-- Header --}}
  <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <h3 class="mb-0">استيراد Leads</h3>
    <a href="{{ route('admin.leads.template') }}" class="btn btn-light btn-eq">
      <i class="tio-download-to me-1"></i> تنزيل القالب
    </a>
  </div>

  {{-- تعليمات سريعة --}}
  <div class="card crm-card mb-3">
    <div class="card-body">
      <div class="d-flex align-items-start gap-2 mb-2">
        <i class="tio-info-outined fs-4 opacity-75"></i>
        <strong>طريقة الاستخدام</strong>
      </div>
      <ul class="mb-2 small text-muted pe-3">
        <li>حمّل <strong>قالب الاستيراد</strong> وعدّل عليه دون تغيير أسماء الأعمدة.</li>
        <li>الصيغ المدعومة: <code>.xlsx</code> أو <code>.csv</code> (UTF-8). في CSV استخدم فاصل <code>,</code> وصفّ العناوين في الصف الأول.</li>
        <li>أعمدة يفضل عدم تركها: <em>الشركة، الاسم، كود الدولة، الهاتف</em>. مثال للسعودية: كود <strong>+966</strong>، والعملة <strong>SAR</strong>.</li>
        <li>التاريخ/الوقت: <code>YYYY-MM-DD HH:mm</code> (مثال: <code>2025-08-23 14:30</code>).</li>
        <li><strong>المالك الافتراضي</strong> يُستخدم للصفوف بدون مالك. أما <strong>التوزيع التلقائي</strong> فيوزّع الصفوف غير المعيّنة بالتساوي على المسؤولين النشطين (ولا يحتاج اختيار مسؤولين).</li>
      </ul>
    </div>
  </div>

  {{-- Form --}}
  <form method="post" action="{{ route('admin.leads.import') }}" enctype="multipart/form-data" class="card crm-card p-3" id="import-form">
    @csrf

    <div class="row g-3">
      {{-- ملف --}}
      <div class="col-md-6">
        <label class="form-label required">ملف Excel (xlsx/csv)</label>
        <input type="file" name="file" class="form-control" accept=".xlsx,.csv" required>
        <small class="text-muted">اختر الملف من القالب أو CSV بترميز UTF-8.</small>
      </div>

      {{-- مالك افتراضي --}}
      <div class="col-md-3">
        <label class="form-label">مالك افتراضي (اختياري)</label>
        <select name="default_owner" class="form-select js-select2" data-placeholder="اختر مالكًا (اختياري)" id="default_owner">
          <option value=""></option>
          @foreach($admins as $ad)
            <option value="{{ $ad->id }}">{{ $ad->email }}</option>
          @endforeach
        </select>
        <small class="text-muted d-block">يُستخدم لو الصف مفيهوش مالك.</small>
      </div>

      <div class="col-12"><hr></div>

      {{-- توزيع تلقائي --}}
      <div class="col-md-3 d-flex align-items-end">
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" name="distribute" value="1" id="distribute">
          <label class="form-check-label" for="distribute">توزيع تلقائي (Round-Robin)</label>
        </div>
      </div>

      {{-- مسؤولو التوزيع (يختفي تمامًا عند تفعيل التوزيع التلقائي) --}}
      <div class="col-md-6" id="admin_ids_wrapper">
        <label class="form-label">اختر المسؤولين للتوزيع (اختياري)</label>
        <select name="admin_ids[]" class="form-select js-select2" multiple data-placeholder="اختر مسؤولين" id="admin_ids">
          @foreach($admins as $ad)
            <option value="{{ $ad->id }}">{{ $ad->name }}</option>
          @endforeach
        </select>
        <small class="text-muted d-block">لو فاضي، هيستخدم كل الإداريين النشطين.</small>
      </div>
    </div>

    <div class="mt-4 d-flex justify-content-end align-items-center flex-wrap gap-2">
      <a href="{{ route('admin.leads.index') }}" class="btn btn-light btn-eq">رجوع</a>
      <button class="btn btn-primary btn-eq">
        <i class="tio-upload-to-cloud me-1"></i> رفع واستيراد
      </button>
    </div>
  </form>
</div>
@endsection

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
  .crm-card{ border:0; border-radius:1rem; box-shadow:0 6px 18px rgba(0,0,0,.06); }

  /* Equal buttons */
  .btn-eq{
    --btn-h: 36px;
    min-height: var(--btn-h);
    height: var(--btn-h);
    line-height: calc(var(--btn-h) - 2px);
    padding: 0 .8rem;
    display:inline-flex; align-items:center; justify-content:center; gap:.35rem;
    border-radius:.55rem; font-size:.92rem;
  }

  .form-label.required::after{ content:" *"; color:#d6336c; font-weight:600; }

  /* Select2 (مدمج) */
  .select2-container{ width:100%!important; }
  .select2-compact.select2-container--default .select2-selection--single,
  .select2-compact.select2-container--default .select2-selection--multiple{
    min-height: 36px; border-color:#e6e8eb; border-radius:.6rem;
  }
  .select2-compact .select2-selection__rendered{ line-height:34px!important; font-size:.925rem; }
  .select2-compact .select2-selection__arrow{ height:36px!important; }
  .select2-compact .select2-results__options{ max-height: 260px; font-size:.925rem; }
  .select2-compact .select2-results__option{ padding:6px 10px; }
</style>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.full.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function(){
    // Select2
    if (window.jQuery && jQuery().select2) {
      $('.js-select2').each(function(){
        const $el = $(this);
        $el.select2({
          dir: 'rtl',
          width: '100%',
          placeholder: $el.data('placeholder') || '',
          allowClear: true,
          minimumResultsForSearch: 7,
          dropdownCssClass: 'select2-compact',
          selectionCssClass: 'select2-compact'
        });
      });
    }

    const distributeSwitch = document.getElementById('distribute');
    const adminWrapper     = document.getElementById('admin_ids_wrapper');
    const adminSelect      = document.getElementById('admin_ids');
    const defaultOwnerSel  = document.getElementById('default_owner');

    function setDisabledSelect2(selectEl, disabled) {
      if (!selectEl) return;
      const $el = $(selectEl);
      $el.prop('disabled', disabled);
      $el.trigger('change.select2'); // يعيد رسم Select2 بعد التعطيل
    }

    function clearSelect2(selectEl) {
      if (!selectEl) return;
      const $el = $(selectEl);
      $el.val(null).trigger('change');
    }

    function updateDistributionUI() {
      const isDistributed = distributeSwitch && distributeSwitch.checked;

      // إخفاء + تعطيل اختيار المسؤولين عند التوزيع التلقائي
      if (adminWrapper) adminWrapper.style.display = isDistributed ? 'none' : '';
      setDisabledSelect2(adminSelect, isDistributed);
      if (isDistributed) clearSelect2(adminSelect);

      // تعطيل المالك الافتراضي عند التوزيع التلقائي لتجنّب التعارض
      setDisabledSelect2(defaultOwnerSel, isDistributed);
      if (isDistributed) clearSelect2(defaultOwnerSel);
    }

    // ربط الأحداث
    if (distributeSwitch) {
      distributeSwitch.addEventListener('change', updateDistributionUI);
    }

    // مبدئيًا عند تحميل الصفحة
    updateDistributionUI();

    // تحقق قبل الإرسال
    document.getElementById('import-form').addEventListener('submit', function(e){
      const fileInput = this.querySelector('input[name="file"]');
      if (!fileInput || !fileInput.files.length) return;

      const name = (fileInput.files[0].name || '').toLowerCase();
      const ok = name.endsWith('.xlsx') || name.endsWith('.csv');
      if (!ok) {
        e.preventDefault();
        alert('صيغة الملف غير مدعومة. يُسمح فقط بملفات .xlsx أو .csv');
        return;
      }
    });
  });
</script>
