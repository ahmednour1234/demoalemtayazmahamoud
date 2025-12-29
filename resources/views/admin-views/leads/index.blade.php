{{-- resources/views/admin/leads/index.blade.php --}}
@extends('layouts.admin.app')

@section('title','العملاء المحتملون')

@section('content')
@php
  $activeTab = request('archived', ''); // ''=الكل , 0=نشط , 1=مؤرشف
@endphp

<div class="content container-fluid">

  {{-- Header / Actions --}}
  <div class="crm-header d-flex justify-content-between align-items-center flex-wrap mb-3 gap-3">
    <div>
      <h3 class="crm-title mb-1">{{ \App\CPU\translate('العملاء المحتملون') }}</h3>
      <div class="crm-subtitle text-muted small">
        إدارة سريعة ومحكمة لقاعدة العملاء المحتملين مع فلاتر دقيقة وطباعة للجدول فقط.
      </div>
    </div>

    <div class="crm-actions btn-toolbar flex-wrap" role="toolbar" aria-label="Toolbar">
      {{-- مجموعة 1: قالب/تصدير/استيراد --}}
      <div class="btn-group crm-btn-group" role="group" aria-label="Export/Import">
        <a href="{{ route('admin.leads.template') }}" class="btn btn-success btn-soft btn-eq" data-bs-toggle="tooltip" title="تنزيل قالب الاستيراد">
          <i class="tio-download-to me-1"></i> قالب
        </a>
        <a href="{{ route('admin.leads.export', request()->query()) }}" class="btn btn-outline-secondary btn-eq" data-bs-toggle="tooltip" title="تصدير النتائج الحالية">
          <i class="tio-file-outlined me-1"></i> تصدير
        </a>
        <a href="{{ route('admin.leads.import.view') }}" class="btn btn-outline-info btn-eq" data-bs-toggle="tooltip" title="استيراد من ملف">
          <i class="tio-upload-to-cloud me-1"></i> استيراد
        </a>
      </div>

      <span class="toolbar-divider" aria-hidden="true"></span>

      {{-- مجموعة 2: جديد/طباعة --}}
      <div class="btn-group crm-btn-group" role="group" aria-label="Create/Print">
        <a href="{{ route('admin.leads.create') }}" class="btn btn-primary btn-eq" data-bs-toggle="tooltip" title="إضافة Lead جديد">
          <i class="tio-add me-1"></i> جديد
        </a>
        <button type="button" class="btn btn-outline-dark btn-eq" onclick="printTableOnly()" data-bs-toggle="tooltip" title="طباعة الجدول فقط">
          <i class="tio-print me-1"></i> طباعة
        </button>
      </div>
    </div>
  </div>

  {{-- Filters + Tabs --}}
  <div class="card crm-card mb-3">
    <div class="card-header py-2 d-flex justify-content-between align-items-center flex-wrap gap-2">
      <div class="d-flex align-items-center gap-2">
        <i class="tio-filter-list"></i>
        <strong>فلترة النتائج</strong>
      </div>

      <ul class="nav nav-pills nav-pills-sm crm-tabs">
        <li class="nav-item">
          <a class="nav-link {{ $activeTab === '' ? 'active' : '' }}"
             href="{{ route('admin.leads.index', array_merge(request()->except('page'), ['archived' => ''])) }}">
            الكل
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ $activeTab === '0' ? 'active' : '' }}"
             href="{{ route('admin.leads.index', array_merge(request()->except('page'), ['archived' => '0'])) }}">
            نشط
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ $activeTab === '1' ? 'active' : '' }}"
             href="{{ route('admin.leads.index', array_merge(request()->except('page'), ['archived' => '1'])) }}">
            مؤرشف
          </a>
        </li>
      </ul>
    </div>

    <form method="GET">
      <div class="card-body pb-2">
        <div class="row g-3 align-items-end">
          {{-- بحث --}}
          <div class="col-12 col-lg-4">
            <label class="form-label">بحث</label>
            <div class="position-relative">
              <span class="search-icon tio-search"></span>
              <input name="search"
                     value="{{ $filters['search'] ?? '' }}"
                     class="form-control ps-5"
                     placeholder="ابحث بالاسم / البريد / الهاتف">
            </div>
          </div>

          {{-- الحالة --}}
          <div class="col-12 col-sm-6 col-lg-2">
            <label class="form-label">الحالة</label>
            <select name="status_id" class="form-select js-select2" data-placeholder="كل الحالات">
              <option value=""></option>
              @foreach($statuses as $st)
                <option value="{{ $st->id }}" @selected(($filters['status_id'] ?? '')==$st->id)>{{ $st->name }}</option>
              @endforeach
            </select>
          </div>

          {{-- المصدر --}}
          <div class="col-12 col-sm-6 col-lg-2">
            <label class="form-label">المصدر</label>
            <select name="source_id" class="form-select js-select2" data-placeholder="كل المصادر">
              <option value=""></option>
              @foreach($sources as $so)
                <option value="{{ $so->id }}" @selected(($filters['source_id'] ?? '')==$so->id)>{{ $so->name }}</option>
              @endforeach
            </select>
          </div>

          {{-- المسؤول --}}
          <div class="col-12 col-sm-6 col-lg-2">
            <label class="form-label">المسؤول</label>
            <select name="owner_id" class="form-select js-select2" data-placeholder="كل المسؤولين">
              <option value=""></option>
              @foreach($admins as $ad)
                <option value="{{ $ad->id }}" @selected(($filters['owner_id'] ?? '')==$ad->id)>{{ $ad->email }}</option>
              @endforeach
            </select>
          </div>

          {{-- الأرشفة --}}
          <div class="col-12 col-sm-6 col-lg-2">
            <label class="form-label">الأرشفة</label>
            <select name="archived" class="form-select js-select2" data-placeholder="الكل">
              <option value=""></option>
              <option value="0" @selected(($filters['archived'] ?? '')==='0')>نشط</option>
              <option value="1" @selected(($filters['archived'] ?? '')==='1')>مؤرشف</option>
            </select>
          </div>
        </div>
      </div>

      <div class="card-footer d-flex justify-content-end flex-wrap gap-2">
        <button class="btn btn-secondary btn-sm px-3 btn-eq">
          <i class="tio-filter-list me-1"></i> فلترة
        </button>
        <a href="{{ route('admin.leads.index') }}" class="btn btn-light btn-sm px-3 btn-eq">
          <i class="tio-clear-formatting me-1"></i> إعادة تعيين
        </a>
      </div>
    </form>
  </div>

  {{-- Table --}}
  <div class="card crm-card" id="js-print-area">
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2 py-2">
      <div class="d-flex align-items-center gap-2">
        <i class="tio-table"></i>
        <strong>قائمة العملاء</strong>
      </div>
      <span class="text-muted small">
        إجمالي: <strong>{{ number_format($leads->total()) }}</strong>
      </span>
    </div>

    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0 crm-table" id="leads-table">
        <thead class="table-light position-sticky top-0">
          <tr class="text-nowrap">
            <th class="text-muted fw-semibold">#</th>
            <th>الشركة</th>
            <th>الاسم</th>
            <th>الهاتف</th>
            <th>الحالة</th>
            <th>المصدر</th>
            <th>المسؤول</th>
            <th>التالي</th>
            <th class="text-center">إجراءات</th>
          </tr>
        </thead>
        <tbody>
        @forelse($leads as $l)
          @php
            /** إصلاح مشكلة Optional: استخدم القيمة مباشرة */
            $next = $l->next_action_at; // \Carbon\Carbon|null
            $nextClass = '';
            $nextLabel = $next ? $next->format('Y-m-d H:i') : null;
            if ($next) {
              if (now()->gt($next)) { $nextClass='badge-overdue'; }
              elseif ($next->isToday()) { $nextClass='badge-today'; }
              else { $nextClass='badge-upcoming'; }
            }
          @endphp
          <tr>
            <td class="text-muted small">{{ $l->id }}</td>

            <td class="text-truncate" style="max-width:200px" data-bs-toggle="tooltip" title="{{ $l->company_name }}">
              {{ $l->company_name }}
            </td>

            <td class="text-truncate" style="max-width:180px" data-bs-toggle="tooltip" title="{{ $l->contact_name }}">
              {{ $l->contact_name }}
            </td>

            <td dir="ltr">
              @php
                $cc = trim($l->country_code ?? '');
                $ph = trim($l->phone ?? '');
              @endphp
              @if($ph)
                <a class="link-underline link-underline-opacity-0" href="tel:{{ $cc.$ph }}">
                  {{ $cc }} {{ $ph }}
                </a>
              @else
                <span class="text-muted">—</span>
              @endif
            </td>

            <td>
              @if($l->status)
                <span class="badge badge-soft-info">{{ $l->status->name }}</span>
              @else
                <span class="text-muted">—</span>
              @endif
            </td>

            <td class="text-truncate" style="max-width:160px" title="{{ optional($l->source)->name }}">
              {{ optional($l->source)->name }}
            </td>

            <td class="text-truncate" style="max-width:200px" title="{{ optional($l->owner)->email }}">
              {{ optional($l->owner)->email }}
            </td>

            <td>
              @if($next)
                <span class="badge {{ $nextClass }}">{{ $nextLabel }}</span>
              @else
                <span class="text-muted">—</span>
              @endif
            </td>

            <td class="text-center">
              <div class="btn-actions d-inline-flex align-items-start gap-2">
                <a href="{{ route('admin.leads.show',$l) }}"
                   class="btn btn-outline-secondary btn-sm btn-eq" data-bs-toggle="tooltip" title="عرض">
                  <i class="tio-visible-outlined"></i>
                </a>

                <a href="{{ route('admin.leads.edit',$l) }}"
                   class="btn btn-outline-primary btn-sm btn-eq" data-bs-toggle="tooltip" title="تعديل">
                  <i class="tio-edit"></i>
                </a>

                <form method="post" action="{{ route('admin.leads.archive',$l) }}" class="d-inline">
                  @csrf @method('PATCH')
                  <input type="hidden" name="archived" value="{{ $l->is_archived ? 0 : 1 }}">
                  <button type="submit"
                          class="btn btn-sm btn-eq {{ $l->is_archived ? 'btn-success' : 'btn-outline-secondary' }}"
                          data-bs-toggle="tooltip"
                          title="{{ $l->is_archived ? 'إلغاء أرشفة' : 'أرشفة' }}">
                    <i class="tio-archive"></i>
                  </button>
                </form>

                <!--<form method="post" action="{{ route('admin.leads.destroy',$l) }}"-->
                <!--      onsubmit="return confirm('هل أنت متأكد من حذف العميل؟');" class="d-inline">-->
                <!--  @csrf @method('DELETE')-->
                <!--  <button class="btn btn-outline-danger btn-sm btn-eq" data-bs-toggle="tooltip" title="حذف">-->
                <!--    <i class="tio-delete-outlined"></i>-->
                <!--  </button>-->
                <!--</form>-->
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="9" class="text-center py-5">
              <div class="empty-state">
                <i class="tio-info-outined d-block mb-2 fs-2 opacity-75"></i>
                <div class="fw-semibold mb-1">لا توجد بيانات</div>
                <div class="text-muted small">جرّب تعديل الفلاتر أو إضافة Lead جديد.</div>
              </div>
            </td>
          </tr>
        @endforelse
        </tbody>
      </table>
    </div>

    <div class="card-footer d-flex justify-content-between align-items-center flex-wrap gap-2">
      <div class="text-muted small">
        @if($leads->count())
          يعرض {{ $leads->firstItem() }}–{{ $leads->lastItem() }} من {{ number_format($leads->total()) }}
        @else
          لا توجد نتائج لعرضها
        @endif
      </div>
      <div>{{ $leads->appends(request()->query())->links() }}</div>
    </div>
  </div>

  {{-- Auto-Assign --}}
  <div class="card crm-card mt-3">
    <div class="card-header py-2">
      <strong><i class="tio-user-switch"></i> توزيع غير المعيّنين بالتساوي</strong>
    </div>
    <div class="card-body">
      <form method="post" action="{{ route('admin.leads.auto_assign') }}" class="row g-3 align-items-center">
        @csrf
        <div class="col-md-8">
          <label class="form-label">اختر المسؤولين للتوزيع (اختياري)</label>
          <select name="admin_ids[]" class="form-select js-select2" multiple data-placeholder="اختر مسؤولين">
            @foreach($admins as $ad)
              <option value="{{ $ad->id }}">{{ $ad->email }}</option>
            @endforeach
          </select>
          <small class="text-muted">لو تركتها فارغة سيتم استخدام جميع المسؤولين النشطين.</small>
        </div>
        <div class="col-md-4">
          <button class="btn btn-outline-primary btn-sm w-100 btn-eq">
            <i class="tio-user-switch me-1"></i> نفّذ التوزيع الآن
          </button>
        </div>
      </form>
    </div>
  </div>

</div>
@endsection

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
  /* --------- CRM Polishing --------- */
  .crm-title{ font-weight:700; letter-spacing:.1px; }
  .crm-subtitle{ line-height:1.4; }
  .crm-card{ border:0; border-radius:1rem; box-shadow:0 6px 18px rgba(0,0,0,.06); }

  /* Actions spacing */
  .crm-actions{ display:flex; gap:1rem; }
  .crm-btn-group{ display:flex; gap:.5rem; }
  .crm-btn-group .btn{ border-radius:.6rem; }
  .toolbar-divider{ width:1px; background:#e9ecef; align-self:stretch; }
  @media (max-width: 576px){
    .toolbar-divider{ display:none; }
    .crm-actions{ gap:.75rem; }
  }

  .crm-tabs .nav-link{ padding:.25rem .75rem; border-radius:2rem; }
  .btn-soft{ color:#0f5132; background:#e8f4ee; border-color:#d4efe1; }
  .btn-soft:hover{ background:#dff0e7; }

  /* Equal-sized buttons */
  .btn-eq{
    --btn-h: 34px;
    min-height: var(--btn-h);
    height: var(--btn-h);
    line-height: calc(var(--btn-h) - 2px);
    padding: 0 .7rem;
    display:inline-flex; align-items:center; justify-content:center;
    gap:.35rem; border-radius:.55rem; font-size:.9rem;
  }

  /* Search icon */
  .search-icon{ position:absolute; left:.75rem; top:50%; transform:translateY(-50%); opacity:.65; }

  /* Table */
  .crm-table thead th{ white-space:nowrap; font-size:.825rem; }
  .crm-table tbody td{ vertical-align:middle; }
  .crm-table tbody tr:hover{ background:#fcfcfd; }
  .table-responsive{ max-height: 68vh; }

  /* Status badge */
  .badge-soft-info{ background:#e8f4ff; color:#0d6efd; }

  /* Next action state */
  .badge-overdue{ background:#fdecec; color:#c1121f; }
  .badge-today{ background:#fff6e5; color:#b35c00; }
  .badge-upcoming{ background:#e9f7ef; color:#0f5132; }

  /* Select2 compact */
  .select2-container{ width:100%!important; }
  .select2-container--default .select2-selection--single,
  .select2-container--default .select2-selection--multiple{
    min-height: 36px; border-color:#e6e8eb; border-radius:.5rem;
  }
  .select2-selection__rendered{ line-height:34px!important; }
  .select2-selection__arrow{ height:36px!important; }
  .select2-compact.select2-container--default .select2-selection--single{
    min-height: 34px;
  }
  .select2-compact .select2-results__options{ max-height: 240px; font-size:.92rem; }
  .select2-compact .select2-results__option{ padding:6px 10px; }

  /* Empty state */
  .empty-state .fs-2{ font-size:2rem!important; }

  /* Print */
  @media print{
    body{ -webkit-print-color-adjust:exact; print-color-adjust:exact; }
    .crm-card{ box-shadow:none!important; }
  }
</style>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.full.min.js"></script>
<script>
  // Init tooltips + Select2
  document.addEventListener('DOMContentLoaded', function () {
    if (window.bootstrap && bootstrap.Tooltip) {
      [...document.querySelectorAll('[data-bs-toggle="tooltip"]')].forEach(el => new bootstrap.Tooltip(el));
    }
    if (window.jQuery && jQuery().select2) {
      $('.js-select2').each(function () {
        const $el = $(this);
        $el.select2({
          dir:'rtl', width:'100%', allowClear:true,
          placeholder:$el.data('placeholder') || '',
          minimumResultsForSearch: 7,
          dropdownCssClass: 'select2-compact',
          selectionCssClass: 'select2-compact'
        });
      });
    }
  });

  // Print only the leads table (clean print)
  function printTableOnly() {
    const table = document.getElementById('leads-table');
    if (!table) return;

    const html = `
<!doctype html>
<html dir="rtl" lang="ar">
<head>
<meta charset="utf-8">
<title>طباعة الجدول</title>
<style>
  :root{ --b:#e5e7eb; --bg:#ffffff; --hbg:#f8f9fa; --txt:#111827; }
  body{ font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Arial,sans-serif; margin:20px; color:var(--txt); }
  h4{ margin:0 0 12px; }
  table{ width:100%; border-collapse:collapse; background:var(--bg); }
  thead th{ background:var(--hbg); }
  th,td{ border:1px solid var(--b); padding:8px 10px; text-align:right; font-size:12px; }
</style>
</head>
<body>
  <h4>قائمة العملاء المحتملين</h4>
  ${table.outerHTML}
  <script>setTimeout(function(){ window.focus(); window.print(); }, 50);<\/script>
</body>
</html>`;

    const iframe = document.createElement('iframe');
    iframe.style.position = 'fixed';
    iframe.style.right = 0;
    iframe.style.bottom = 0;
    iframe.style.width = 0;
    iframe.style.height = 0;
    iframe.style.border = 0;
    document.body.appendChild(iframe);

    const doc = iframe.contentDocument || iframe.contentWindow.document;
    doc.open(); doc.write(html); doc.close();

    setTimeout(() => { try{ document.body.removeChild(iframe); }catch(e){} }, 1500);
  }
</script>
