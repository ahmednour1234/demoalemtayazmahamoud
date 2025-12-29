@extends('layouts.admin.app')
@section('title','تعديل مشروع')

@section('content')
<div class="content container-fluid">
    <div class="mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white px-3 py-2 rounded shadow-sm">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-secondary"><i class="tio-home-outlined"></i> الرئيسية</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.projects.index') }}" class="text-primary">المشروعات</a></li>
                <li class="breadcrumb-item active" aria-current="page">تعديل مشروع</li>
            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h5 class="mb-0">تعديل مشروع</h5>
        </div>
        <div class="card-body">
            @include('admin-views.projects._form', [
                'action' => route('admin.projects.update',$project->id),
                'method' => 'PUT',
                'project' => $project,
                'statuses' => $statuses,
                'owners' => $owners
            ])
        </div>
    </div>
</div>
@endsection
