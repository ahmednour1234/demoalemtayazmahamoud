{{-- resources/views/admin/leads/edit.blade.php --}}
@extends('layouts.admin.app')
@section('title','تعديل عميل محتمل')
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
 تعديل: #{{ $lead->id }}                </a>
            </li>
           
        </ol>
    </nav> 
  <form method="post" action="{{ route('admin.leads.update',$lead) }}" class="card p-3">
    @csrf @method('PUT')
    @include('admin-views.leads._form',['lead'=>$lead])
  </form>
</div>
@endsection
