{{-- resources/views/admin/custom-fields/index.blade.php --}}
@extends('layouts.admin.app')
@section('title','الحقول المخصّصة')

@section('content')
@php use Illuminate\Support\Str; @endphp
<div class="content container-fluid" dir="rtl">

  {{-- Header --}}
  <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <div class="d-flex align-items-center gap-2">
      <div class="page-icon bg-primary-subtle text-primary">
        <i class="tio-settings-outlined"></i>
      </div>
      <div>
        <h3 class="mb-0 fw-bold">الحقول المخصّصة</h3>
        <div class="text-muted small">عرّف حقول إضافية لأي موديل وقم بإدارتها بسهولة.</div>
      </div>
    </div>
    <a href="{{ route('admin.custom-fields.create') }}" class="btn btn-primary">
      <i class="tio-add"></i> جديد
    </a>
  </div>

  {{-- Filters --}}
  <div class="card mb-3">
    <form method="get" id="filters-form">
      <div class="card-body">
        <div class="row g-3 align-items-end">
          <div class="col-12 col-md-4">
            <label class="form-label">بحث</label>
            <div class="input-group">
              <span class="input-group-text"><i class="tio-search"></i></span>
              <input class="form-control" name="search" placeholder="اسم / مفتاح / موديل" value="{{ request('search') }}">
            </div>
          </div>

          <div class="col-6 col-md-3">
            <label class="form-label">النوع</label>
            <select class="form-select js-select2" name="type" data-placeholder="الكل">
              <option value="">الكل</option>
              @foreach($types as $t)
                <option value="{{ $t }}" @selected(request('type')===$t)>{{ $t }}</option>
              @endforeach
            </select>
          </div>

          <div class="col-6 col-md-3">
            <label class="form-label">الحالة</label>
            <select class="form-select js-select2" name="active" data-placeholder="الكل">
              <option value="">الكل</option>
              <option value="1" @selected(request('active')==='1')>مفعّل</option>
              <option value="0" @selected(request('active')==='0')>معطّل</option>
            </select>
          </div>

          <div class="col-12 col-md-2 d-grid">
            <button class="btn btn-secondary"><i class="tio-filter-list"></i> فلترة</button>
          </div>
        </div>
      </div>
    </form>
  </div>

  {{-- Table --}}
  <div class="card">
    <div class="table-responsive">
      <table class="table table-hover table-nowrap align-middle mb-0">
        <thead class="table-light position-sticky top-0" style="z-index:1;">
          <tr>
            <th style="width:72px">#</th>
            <th>الاسم</th>
            <th>المفتاح</th>
            <th>النوع</th>
            <th>المجموعة</th>
            <th>يتبع</th>
            <th>إلزامي</th>
            <th>ترتيب</th>
            <th>الحالة</th>
            <th class="text-center" style="width:160px">إجراءات</th>
          </tr>
        </thead>
        <tbody>
          @forelse($fields as $f)
            <tr>
              <td class="text-muted">{{ $f->id }}</td>
              <td class="fw-semibold">{{ $f->name }}</td>

              <td dir="ltr">
                <div class="d-flex align-items-center gap-2">
                  <code class="user-select-all">{{ $f->key }}</code>
                  <button class="icon-btn btn-ico copy-btn" type="button" data-copy="{{ $f->key }}" data-bs-toggle="tooltip" title="نسخ المفتاح">
                    <i class="tio-copy"></i>
                  </button>
                </div>
              </td>

              <td>{{ $f->type }}</td>
              <td>{{ $f->group ?: '—' }}</td>
              <td><code>{{ Str::afterLast($f->applies_to,'\\') }}</code></td>
              <td>
                {!! $f->is_required
                  ? '<span class="badge bg-warning-subtle text-warning">نعم</span>'
                  : '<span class="badge bg-secondary-subtle text-secondary">لا</span>' !!}
              </td>
              <td>{{ $f->sort_order }}</td>

              <td>
                <form method="post" class="m-0 p-0 d-inline" action="{{ route('admin.custom-fields.active',$f) }}">
                  @csrf @method('PATCH')
                  <input type="hidden" name="active" value="{{ $f->is_active ? 1 : 0 }}">
                  <div class="form-check form-switch d-inline-flex align-items-center gap-2" dir="ltr">
                    <span class="small {{ $f->is_active ? 'text-muted' : 'text-primary' }}">معطّل</span>
                    <input class="form-check-input act-switch" type="checkbox" role="switch" {{ $f->is_active ? 'checked' : '' }}>
                    <span class="small {{ $f->is_active ? 'text-primary' : 'text-muted' }}">مفعّل</span>
                  </div>
                </form>
              </td>

              <td class="text-center">
                <div class="d-inline-flex align-items-center gap-1">
                  <a href="{{ route('admin.custom-fields.edit',$f) }}"
                     class="icon-btn text-primary" data-bs-toggle="tooltip" title="تعديل">
                    <i class="tio-edit"></i>
                  </a>
                  <form method="post" action="{{ route('admin.custom-fields.destroy',$f) }}"
                        class="d-inline" onsubmit="return confirm('حذف الحقل؟');">
                    @csrf @method('DELETE')
                    <button class="icon-btn text-danger" type="submit" data-bs-toggle="tooltip" title="حذف">
                      <i class="tio-delete-outlined"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr><td colspan="10" class="text-center text-muted py-4">لا توجد بيانات</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="card-footer d-flex justify-content-between align-items-center flex-wrap gap-2">
      <div class="small text-muted">عرض {{ $fields->firstItem() }}–{{ $fields->lastItem() }} من {{ $fields->total() }}</div>
      <div>{{ $fields->links() }}</div>
    </div>
  </div>
</div>

{{-- Styles --}}
<style>
  .page-icon{ width:48px;height:48px; border-radius:12px; display:grid; place-items:center; font-size:1.25rem; }
  .icon-btn{ width:36px; height:36px; display:inline-grid; place-items:center; border:0; background:transparent; border-radius:.6rem; color:#495057; }
  .icon-btn:hover{ background:#f1f3f5; color:#0d6efd; }
  .icon-btn:focus{ outline:0; box-shadow:0 0 0 .2rem rgba(13,110,253,.15); }
  .table-hover tbody tr:hover{ background:#fcfcfd; }
  .select2-container{ width:100%!important; }
  .select2-container--bootstrap-5 .select2-selection{ min-height:44px; display:flex; align-items:center; }
</style>

{{-- Select2 CSS (with Bootstrap 5 theme) --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet">

{{-- jQuery fallback (لو مش موجود في الـ layout) --}}
<script>
  window.jQuery || document.write('<script src="https://code.jquery.com/jquery-3.7.1.min.js"><\/script>');
</script>

{{-- Select2 JS --}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.full.min.js"></script>

<script>
(function(){
  // Select2 on all selects in the page (per your request)
  const $ = window.jQuery;
  if ($ && $.fn.select2) {
    $('select').each(function(){
      const $el = $(this);
      $el.addClass('js-select2'); // توحيدًا
      $el.select2({
        dir: 'rtl',
        width: '100%',
        theme: 'bootstrap-5',
        allowClear: true,
        placeholder: $el.data('placeholder') || ''
      });
    });
  }

  // Toggle Active switch (submit form)
  document.addEventListener('change', function(e){
    if(e.target && e.target.classList.contains('act-switch')){
      const form = e.target.closest('form');
      form.querySelector('input[name="active"]').value = e.target.checked ? 1 : 0;
      form.submit();
    }
  });

  // Copy key button
  document.addEventListener('click', function(e){
    const btn = e.target.closest('.copy-btn');
    if(!btn) return;
    const val = btn.getAttribute('data-copy') || '';
    if(navigator.clipboard){
      navigator.clipboard.writeText(val).then(()=>{
        btn.setAttribute('data-bs-original-title','تم النسخ!');
        if(window.bootstrap){ new bootstrap.Tooltip(btn).show(); }
        setTimeout(()=>{ if(window.bootstrap){ new bootstrap.Tooltip(btn).hide(); } }, 600);
      });
    }
  });

  // Enable Bootstrap tooltips if available
  if(window.bootstrap){
    const triggers = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    triggers.forEach(el => new bootstrap.Tooltip(el));
  }
})();
</script>
@endsection
