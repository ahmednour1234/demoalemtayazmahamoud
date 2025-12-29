{{-- resources/views/admin/custom-fields/edit.blade.php --}}
@extends('layouts.admin.app')
@section('title','تعديل حقل مخصّص')

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
          <span class="text-primary">تعديل حقل مخصّص</span>
        </li>
      </ol>
    </nav>
  </div>

  {{-- ملخّص أخطاء إن وجد --}}
  @if ($errors->any())
    <div class="alert alert-danger border-0 shadow-sm rounded-3 mb-3">
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

  <form method="post" action="{{ route('admin.custom-fields.update',$field) }}" id="cf_edit_form" class="mt-3">
    @csrf
    @method('PUT')

    {{-- ملاحظة: الجزئي _form يحتوي على الكارت + البيلدر + الـJS
         ولتفادي تكرار الـbreadcrumb الداخلي للجزئي، هنخفيه هنا فقط عبر CSS أدناه --}}
    <div class="cf-no-inner-breadcrumb">
      @include('admin-views.custom-fields._form', [
        'types'            => $types,
        'field'            => $field,
        'modelChoices'     => $modelChoices ?? [
          \App\Models\Lead::class        => 'Lead (العملاء المحتملين)',
          \App\Models\CallLog::class     => 'CallLog (سجلات المكالمات)',
          \App\Models\CallOutcome::class => 'CallOutcome (نتائج المكالمات)',
          \App\Models\Admin::class       => 'Admin (المسؤولون)',
                    \App\Models\Customer::class       => 'Customers (العملاء)',

        ],
        'breadcrumbTitle'  => 'تعديل حقل مخصّص'
      ])
    </div>

    {{-- شريط إجراءات لاصق --}}
    <div class="sticky-actions d-flex justify-content-end align-items-center gap-2 mt-3">
      <a href="{{ route('admin.custom-fields.index') }}" class="btn btn-light btn-lg px-4">
        <i class="tio-undo"></i> رجوع
      </a>
      <button type="submit" class="btn btn-primary btn-lg px-4">
        <i class="tio-checkmark-circle-outlined"></i> تحديث
      </button>
    </div>
  </form>
</div>

{{-- تنسيقات خفيفة --}}
<style>
  .sticky-actions{
    position: sticky; bottom: 0; padding: 12px 0;
    background: linear-gradient(180deg, rgba(255,255,255,0), #fff 45%);
    z-index: 9; border-top: 1px solid rgba(0,0,0,.075);
  }
  /* إخفاء أي breadcrumb داخلي داخل الجزئي _form لتجنّب التكرار */
  .cf-no-inner-breadcrumb nav[aria-label="breadcrumb"]{ display:none!important; }
</style>

{{-- تفعيل Tooltips لو Bootstrap متاح --}}
<script>
  if (window.bootstrap) {
    const triggers = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    triggers.forEach(el => new bootstrap.Tooltip(el));
  }
</script>
@endsection
