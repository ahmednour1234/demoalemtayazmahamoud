{{-- resources/views/admin/leads/create.blade.php --}}
@extends('layouts.admin.app')
@section('title','إضافة عميل محتمل')
@section('content')
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
                    {{ \App\CPU\translate('إضافة عميل محتمل ') }}
                </a>
            </li>
           
        </ol>
    </nav>
  <form method="post" action="{{ route('admin.leads.store') }}" class="card p-3">
    @csrf
    @include('admin-views.leads._form')
  </form>
</div>
@endsection
