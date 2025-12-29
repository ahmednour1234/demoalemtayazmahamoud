@extends('layouts.admin.app')

@section('title', 'تعديل قسم')

@push('css_or_js')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <style>
        .form-actions {
            display: flex;
            gap: 12px;
            justify-content: flex-start; /* على الشمال */
        }
        .form-actions .erp-btn {
            height: 40px;
            min-width: 120px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
        }
        [dir="rtl"] .select2-container .select2-selection--single .select2-selection__rendered { text-align: right; }
    </style>
@endpush

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
                <li class="breadcrumb-item active" aria-current="page">تعديل قسم</li>
            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-header"><h5 class="mb-0">تعديل قسم</h5></div>
        <div class="card-body">
            @include('admin-views.departments._form', [
                'action' => route('admin.departments.update', $department->id),
                'method' => 'PUT',
                'department' => $department,
                'parents' => $parents
            ])
        </div>
    </div>
</div>
@endsection

@push('script_2')
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.full.min.js"></script>
    <script>
        $(function () {
            $('.js-select2').select2({
                dir: 'rtl',
                width: '100%',
                allowClear: true,
                placeholder: '— بدون —',
                minimumResultsForSearch: 0
            });
        });
    </script>
@endpush
