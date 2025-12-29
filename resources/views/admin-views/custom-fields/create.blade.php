{{-- resources/views/admin/custom-fields/create.blade.php --}}
@extends('layouts.admin.app')
@section('title','إضافة حقل مخصّص')

@section('content')
<div class="content container-fluid" dir="rtl">

  {{-- Breadcrumb --}}
  <div class="mb-3">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb bg-white px-3 py-2 rounded shadow-sm">
        <li class="breadcrumb-item">
          <a href="{{ route('admin.dashboard') }}" class="text-secondary">
            <i class="tio-home-outlined"></i> {{ \App\CPU\translate('الرئيسية') }}
          </a>
        </li>
        <li class="breadcrumb-item">
          <span class="text-primary">إضافة حقل مخصّص</span>
        </li>
      </ol>
    </nav>
  </div>


  {{-- Errors summary --}}
  @if ($errors->any())
    <div class="alert alert-danger border-0 shadow-sm rounded-3">
      <div class="d-flex align-items-center gap-2 mb-2">
        <i class="tio-warning-outlined"></i>
        <strong>الرجاء مراجعة الحقول التالية:</strong>
      </div>
      <ul class="mb-0 ps-4">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form method="post" action="{{ route('admin.custom-fields.store') }}" id="cf_create_form">
    @csrf

    <div class="row g-3">
      {{-- Main form --}}
      <div class="col-12 col-lg-8">
        <div class="card border-0 shadow-sm rounded-4">
   
          <div class="card-body">
            {{-- NOTE: غيّر المسار حسب مشروعك (انت كاتب admin-views) --}}
            @include('admin-views.custom-fields._form', ['types' => $types, 'breadcrumbTitle' => 'إضافة حقل مخصّص'])
          </div>
        </div>
      </div>

      {{-- Side tips --}}
      <div class="col-12 col-lg-4">
        <div class="card border-0 shadow-sm rounded-4">
          <div class="card-header bg-secondary text-white rounded-top-4">
            <div class="d-flex align-items-center gap-2">
              <i class="tio-info-outined"></i>
              <strong>نصائح سريعة</strong>
            </div>
          </div>
          <div class="card-body small">
            <ul class="list-unstyled d-grid gap-2 mb-0">
              <li class="d-flex gap-2">
                <span class="text-secondary">•</span>
                <span><b>الموديل التابع</b>: اختر الجهة (موديل) التي ينتمي إليها الحقل من القائمة المنسدلة.</span>
              </li>
              <li class="d-flex gap-2">
                <span class="text-secondary">•</span>
                <span><b>المفتاح (key)</b> يجب أن يكون <code>snake_case</code> وفريدًا. يُقترح تلقائيًا من الاسم.</span>
              </li>
              <li class="d-flex gap-2">
                <span class="text-secondary">•</span>
                <span>لأنواع <b>select/multiselect</b>، استخدم البنّاء (Builder) لإضافة <code>options.choices</code> بسهولة.</span>
              </li>
              <li class="d-flex gap-2">
                <span class="text-secondary">•</span>
                <span>يمكنك وضع <b>القيمة الافتراضية</b> كـ JSON؛ سيتم التحقق منها لحظيًا.</span>
              </li>
            </ul>
          </div>
        </div>


      </div>
    </div>

    {{-- Sticky action bar --}}
    <div class="sticky-actions d-flex justify-content-end align-items-center gap-2 mt-3">
      <a href="{{ route('admin.custom-fields.index') }}" class="btn btn-light btn-lg px-4">
        <i class="tio-undo"></i> رجوع
      </a>
      <button type="submit" class="btn btn-primary btn-lg px-4">
        <i class="tio-checkmark-circle-outlined"></i> حفظ
      </button>
    </div>
  </form>
</div>

{{-- Inline styles (خفيفة) --}}
<style>
  .page-icon{ width:48px; height:48px; display:grid; place-items:center; border-radius:12px; }
  .sticky-actions{
    position: sticky; bottom: 0; padding: 12px 0;
    background: linear-gradient(180deg, rgba(255,255,255,0), #fff 45%);
    z-index: 9; border-top: 1px solid rgba(0,0,0,.075);
  }
  .breadcrumb{ margin-bottom: 0; }
</style>

{{-- تفعيل Tooltips لو Bootstrap موجود --}}
<script>
  if (window.bootstrap) {
    const triggers = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    triggers.forEach(el => new bootstrap.Tooltip(el));
  }
</script>
@endsection
