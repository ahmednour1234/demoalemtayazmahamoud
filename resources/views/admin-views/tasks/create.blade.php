@extends('layouts.admin.app')
@section('title','إضافة مهمة')

@section('content')
<div class="content container-fluid">
    <div class="mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white px-3 py-2 rounded shadow-sm">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-secondary"><i class="tio-home-outlined"></i> الرئيسية</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.tasks.index') }}" class="text-primary">المهام</a></li>
                <li class="breadcrumb-item active" aria-current="page">إضافة مهمة</li>
            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-header"><h5 class="mb-0">إضافة مهمة</h5></div>
        <div class="card-body">
            @include('admin-views.tasks._form', [
                'action' => route('admin.tasks.store'),
                'method' => 'POST',
                'task' => null,
                'projects' => $projects,
                'statuses' => $statuses,
                'assignees' => $assignees
            ])
        </div>
    </div>
</div>
@endsection
