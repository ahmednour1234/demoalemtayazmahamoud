@extends('layouts.admin.app')
@section('title','تعديل نتيجة')
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
    تعديل نتيجة مكالمة
                </a>
            </li>
           
        </ol>
    </nav> 
  <div class="card">
    <form method="post" action="{{ route('admin.call-outcomes.update',$outcome) }}">
      @csrf @method('PUT')
      <div class="card-body">
        @include('admin-views.call_outcomes._form', ['outcome'=>$outcome])
      </div>
    </form>
  </div>
</div>
@endsection
