@extends('layouts.admin.app')
@section('title','إضافة حالة')

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
          {{ \App\CPU\translate('إضافة حالة') }}
        </li>
      </ol>
    </nav>
  </div>  

  <form method="post" action="{{ route('admin.lead-statuses.store') }}" class="card p-3">
    @csrf
    @include('admin-views.lead_statuses._form')
  </form>
</div>
@endsection
