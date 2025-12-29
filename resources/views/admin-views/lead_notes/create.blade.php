@extends('layouts.admin.app')
@section('title','إضافة ملاحظة للـLead')
@section('content')
<div class="content container-fluid">
  <div class="mb-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-white px-3 py-2 rounded shadow-sm">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}" class="text-secondary">
                    <i class="tio-home-outlined"></i> {{ \App\CPU\translate('الرئيسية') }}
                </a>
            </li>
            <li class="breadcrumb-item">
                <a href="#" class="text-primary">
                    {{ \App\CPU\translate('إضافة ملاحظة') }}
                </a>
            </li>
           
        </ol>
    </nav>
</div>

  <form method="post" action="{{ route('admin.lead-notes.store') }}">
    @csrf
    @include('admin-views.lead_notes._form')
    <div class="sticky-actions d-flex justify-content-end gap-2">
      <a href="{{ route('admin.lead-notes.index') }}" class="btn btn-light btn-lg px-4">رجوع</a>
      <button class="btn btn-primary btn-lg px-4">حفظ</button>
    </div>
  </form>
</div>
@endsection
