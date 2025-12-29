@extends('layouts.admin.app')
@section('title','تعديل حالة')

@section('content')
  <div class="mb-3">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb bg-white px-3 py-2 rounded shadow-sm">
        <li class="breadcrumb-item">
          <a href="{{ route('admin.dashboard') }}" class="text-secondary">
            <i class="tio-home-outlined"></i> {{ \App\CPU\translate('الرئيسية') }}
          </a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
 تعديل حالة: {{ $status->name }}
        </li>
      </ol>
    </nav>
  </div>    <h3 class="mb-3">تعديل حالة: {{ $status->name }}</h3>

  <form method="post" action="{{ route('admin.lead-statuses.update',$status) }}" class="card p-3">
    @csrf @method('PUT')
    @include('admin-views.lead_statuses._form', ['status' => $status])
  </form>
</div>
@endsection
