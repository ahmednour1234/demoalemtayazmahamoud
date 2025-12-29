@extends('layouts.admin.app')
@section('title','تعديل سجل مكالمة')
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
    تعديل سجل مكالمة                </a>
            </li>
           
        </ol>
    </nav>
</div>
  <div class="card">
    <form method="post" action="{{ route('admin.call-logs.update',$log) }}">
      @csrf @method('PUT')
      <div class="card-body">
        @include('admin-views.call_logs._form', ['log'=>$log])
      </div>
    </form>
  </div>
</div>
@endsection
