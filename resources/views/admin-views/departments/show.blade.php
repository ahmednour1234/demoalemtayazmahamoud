@extends('layouts.admin.app')

@section('title', 'تفاصيل القسم')

@section('content')
<div class="content container-fluid">

    <!-- Breadcrumb -->
    <div class="mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white px-3 py-2 rounded shadow-sm">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}" class="text-secondary">
                        <i class="tio-home-outlined"></i> الرئيسية
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.departments.index') }}" class="text-primary">الأقسام</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">تفاصيل القسم</li>
            </ol>
        </nav>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h5 class="mb-0">{{ $department->name }} <small class="text-muted">(#{{ $department->id }})</small></h5>
            <div class="text-start">
                <a href="{{ route('admin.departments.edit', $department->id) }}" class="btn btn-primary action-btn">تعديل</a>
                <a href="{{ route('admin.departments.index') }}" class="btn btn-outline-secondary action-btn">رجوع</a>
            </div>
        </div>
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3">الاسم</dt>
                <dd class="col-sm-9">{{ $department->name }}</dd>

                <dt class="col-sm-3">الكود</dt>
                <dd class="col-sm-9"><code>{{ $department->code }}</code></dd>

                <dt class="col-sm-3">القسم الأب</dt>
                <dd class="col-sm-9">{{ $department->parent?->name ?? '—' }}</dd>

                <dt class="col-sm-3">المستوى</dt>
                <dd class="col-sm-9">{{ $department->level }}</dd>

                <dt class="col-sm-3">الحالة</dt>
                <dd class="col-sm-9">
                    @if($department->active)
                        <span class="badge bg-success">نشط</span>
                    @else
                        <span class="badge bg-secondary">متوقف</span>
                    @endif
                </dd>

                <dt class="col-sm-3">المسار</dt>
                <dd class="col-sm-9">{{ $department->path ?: '—' }}</dd>

                <dt class="col-sm-3">تاريخ الإنشاء</dt>
                <dd class="col-sm-9">{{ $department->created_at?->format('Y-m-d H:i') }}</dd>
            </dl>
        </div>
    </div>

    <div class="card">
        <div class="card-header"><h6 class="mb-0">الأقسام الفرعية</h6></div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>الاسم</th>
                            <th>الكود</th>
                            <th>الحالة</th>
                            <th class="text-start">إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($department->children as $child)
                            <tr>
                                <td>{{ $child->id }}</td>
                                <td>{{ $child->name }}</td>
                                <td><code>{{ $child->code }}</code></td>
                                <td>
                                    @if($child->active)
                                        <span class="badge bg-success">نشط</span>
                                    @else
                                        <span class="badge bg-secondary">متوقف</span>
                                    @endif
                                </td>
                                <td class="text-start">
                                    <div class="btn-group" role="group">
                                        <a class="btn btn-sm btn-info action-btn" href="{{ route('admin.departments.show', $child->id) }}">عرض</a>
                                        <a class="btn btn-sm btn-primary action-btn" href="{{ route('admin.departments.edit', $child->id) }}">تعديل</a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-muted">لا توجد أقسام فرعية.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
