{{-- resources/views/admin-views/statuses/show.blade.php --}}
@extends('layouts.admin.app')
@section('title', 'عرض حالة')

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
                <li class="breadcrumb-item"><a href="{{ route('admin.status.index') }}" class="text-primary">الحالات</a></li>
                <li class="breadcrumb-item active">عرض حالة</li>
            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-header"><h5 class="mb-0">تفاصيل الحالة</h5></div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">الاسم</dt>
                <dd class="col-sm-9">{{ $status->name }}</dd>

                <dt class="col-sm-3">الكود</dt>
                <dd class="col-sm-9"><code>{{ $status->code }}</code></dd>

                <dt class="col-sm-3">اللون</dt>
                <dd class="col-sm-9">
                    @if($status->color)
                        <span class="badge" style="background: {{ $status->color }};">&nbsp;&nbsp;</span>
                        <small class="text-muted">{{ $status->color }}</small>
                    @else
                        —
                    @endif
                </dd>

                <dt class="col-sm-3">ترتيب العرض</dt>
                <dd class="col-sm-9">{{ $status->sort_order }}</dd>

                <dt class="col-sm-3">الحالة</dt>
                <dd class="col-sm-9">
                    @if($status->active)
                        <span class="badge bg-success">نشط</span>
                    @else
                        <span class="badge bg-secondary">متوقف</span>
                    @endif
                </dd>
            </dl>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.status.index') }}" class="btn btn-outline-secondary">رجوع</a>
                <a href="{{ route('admin.status.edit', $status->id) }}" class="btn btn-primary">تعديل</a>
            </div>
        </div>
    </div>
</div>
@endsection
