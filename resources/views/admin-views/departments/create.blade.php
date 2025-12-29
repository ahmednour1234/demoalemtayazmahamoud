@extends('layouts.admin.app')

@section('title', 'إضافة قسم')

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <style>
        /* أزرار الإجراءات في آخر الفورم: يسار + مسافة + نفس المقاس + عرض أكبر من ارتفاع */
        .form-actions {
            display: flex;
            gap: 12px;
            justify-content: flex-start; /* RTL: الشمال */
        }
        .form-actions .erp-btn {
            height: 40px;
            min-width: 120px; /* عرض أكبر */
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
        }
        /* تحسين RTL داخل Select2 */
        [dir="rtl"] .select2-container .select2-selection--single .select2-selection__rendered { text-align: right; }
    </style>


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
                <li class="breadcrumb-item active" aria-current="page">إضافة قسم</li>
            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-header"><h5 class="mb-0">إضافة قسم</h5></div>
        <div class="card-body">
            @include('admin-views.departments._form', [
                'action' => route('admin.departments.store'),
                'method' => 'POST',
                'department' => null,
                'parents' => $parents
            ])
        </div>
    </div>
</div>
@endsection

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.full.min.js"></script>
    <script>
        $(function () {
            $('.js-select2').select2({
                dir: 'rtl',
                width: '100%',
                allowClear: true,
                placeholder: '— بدون —',
                minimumResultsForSearch: 0 // دايمًا فيه بحث
            });
        });
    </script>
