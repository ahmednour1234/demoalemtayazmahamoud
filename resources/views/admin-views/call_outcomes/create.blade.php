@extends('layouts.admin.app')
@section('title','نتيجة جديدة')
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
    إضافة نتيجة مكالمة
                </a>
            </li>
           
        </ol>
    </nav>  
  <div class="card">
    <form method="post" action="{{ route('admin.call-outcomes.store') }}">
      @csrf
      <div class="card-body">
        @include('admin-views.call_outcomes._form')
      </div>
    </form>
  </div>
</div>
@endsection
