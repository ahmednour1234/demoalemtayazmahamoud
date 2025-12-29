{{-- resources/views/admin-views/statuses/edit.blade.php --}}
@extends('layouts.admin.app')

@section('title', 'تعديل حالة')

@section('content')
<div class="content container-fluid">
    <div class="mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white px-3 py-2 rounded shadow-sm">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}" class="text-secondary">
                        <i class="tio-home-outlined"></i> الرئيسية
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.status.index') }}" class="text-primary">الحالات</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">تعديل حالة</li>
            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-header"><h5 class="mb-0">تعديل حالة</h5></div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.status.update', $status->id) }}">
                @csrf
                @method('PUT')
                @include('admin-views.statuses._form', ['status' => $status])
            </form>
        </div>
    </div>
</div>
@endsection
