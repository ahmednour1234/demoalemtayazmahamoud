@extends('layouts.admin.app')

@section('title', \App\CPU\translate('admin_list'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('public/assets/admin/css/custom.css') }}"/>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <style>
        /* فلاتر متناسقة */
        .filter-col { min-width: 220px; }

        /* أزرار أعلى الكارد: نفس المقاس تماماً */
        .btn-eq {
            min-width: 120px;     /* ثبات العرض */
            height: 42px;         /* نفس الارتفاع */
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            white-space: nowrap;
        }

        /* أزرار الإجراءات: نفس المقاس تمامًا (مربعة) */
        .icon-actions { display: inline-flex; gap: 8px; }
        .icon-btn {
            width: 40px; height: 40px;            /* ثبات المقاس */
            display: inline-flex; align-items: center; justify-content: center;
            border-radius: 8px; padding: 0 !important;
        }
        .icon-btn i { font-size: 16px; line-height: 1; }

        /* توافق RTL مع Select2 */
        [dir="rtl"] .select2-container .select2-selection--single .select2-selection__rendered { text-align: right; }
        .select2-container--default .select2-selection--single { height: 38px; }
        .select2-container--default .select2-selection--single .select2-selection__rendered { line-height: 38px; }
        .select2-container--default .select2-selection--single .select2-selection__arrow { height: 38px; }
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
                        <i class="tio-home-outlined"></i> {{ \App\CPU\translate('الرئيسية') }}
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ \App\CPU\translate('قائمة الأدمن') }}
                </li>
            </ol>
        </nav>
    </div>

    <div class="row gx-2 gx-lg-3">
        <div class="col-12 mb-3">

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h5 class="mb-0">{{ \App\CPU\translate('قائمة الأدمن') }}</h5>
                    <div class="text-start d-flex flex-wrap gap-2">
   
                        <a href="{{ route('admin.admin.add') }}" class="btn btn-success btn-eq">
                            {{ \App\CPU\translate('إضافة ادمن جديد') }}
                        </a>
                        <a href="{{ route('admin.admin.structure') }}" class="btn btn-info btn-eq">
                            {{ \App\CPU\translate('هيكل الموظفين والأقسام') }}
                        </a>
                    </div>
                </div>

                <div class="card-body">

                    {{-- فلاتر --}}
                    <form method="GET" action="{{ route('admin.admin.list') }}" class="row g-2 align-items-end mb-3">
                        <div class="col-md-3 filter-col">
                            <label class="form-label mb-1">{{ \App\CPU\translate('بحث') }}</label>
                            <input type="text" name="q" class="form-control" value="{{ $q ?? '' }}" placeholder="{{ \App\CPU\translate('الاسم أو البريد...') }}">
                        </div>

                        <div class="col-md-3 filter-col">
                            <label class="form-label mb-1">{{ \App\CPU\translate('القسم') }}</label>
                            <select name="department_id" class="form-control js-select2" data-placeholder="-- {{ \App\CPU\translate('الكل') }} --">
                                <option value="">{{ \App\CPU\translate('الكل') }}</option>
                                @foreach($departments as $d)
                                    <option value="{{ $d->id }}" @selected(($departmentId ?? null)==$d->id)>{{ $d->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3 filter-col">
                            <label class="form-label mb-1">{{ \App\CPU\translate('المدير') }}</label>
                            <select name="manager_id" class="form-control js-select2" data-placeholder="-- {{ \App\CPU\translate('الكل') }} --">
                                <option value="">{{ \App\CPU\translate('الكل') }}</option>
                                @foreach($managers as $m)
                                    <option value="{{ $m->id }}" @selected(($managerId ?? null)==$m->id)>{{ $m->f_name }} {{ $m->l_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 d-flex gap-2">
                            <button class="btn btn-primary btn-eq">{{ \App\CPU\translate('تصفية') }}</button>
                            <a href="{{ route('admin.admin.list') }}" class="btn btn-outline-secondary btn-eq">{{ \App\CPU\translate('إعادة الضبط') }}</a>
                        </div>
                    </form>

                    {{-- جدول --}}
                    <div class="table-responsive datatable-custom">
                        <table class="table table-nowrap table-align-middle card-table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ \App\CPU\translate('الاسم') }}</th>
                                <th>{{ \App\CPU\translate('البريد الألكتروني') }}</th>
                                <th>{{ \App\CPU\translate('الفرع') }}</th>
                                <th>{{ \App\CPU\translate('القسم') }}</th>
                                <th>{{ \App\CPU\translate('المدير') }}</th>
                                <th>{{ \App\CPU\translate('الدور') }}</th>
                                <th class="text-start">{{ \App\CPU\translate('إجراءات') }}</th>
                            </tr>
                            </thead>

                            <tbody id="set-rows">
                            @forelse($admins as $idx => $admin)
                                <tr>
                                    <td>{{ $admins->firstItem() + $idx }}</td>
                                    <td>{{ $admin->f_name }} {{ $admin->l_name }}</td>
                                    <td>{{ $admin->email }}</td>
                                    <td>{{ $admin->branch->name ?? '' }}</td>
                                    <td>{{ $admin->department->name ?? '' }}</td>
                                    <td>{{ optional($admin->manager)->f_name }} {{ optional($admin->manager)->l_name }}</td>
                                    <td>{{ $admin->roles->name ?? $admin->role->name ?? '' }}</td>

                                    <td class="text-start">
                                        <div class="icon-actions" role="group" aria-label="actions">
                                            <a href="{{ route('admin.admin.edit', [$admin->id]) }}"
                                               class="btn btn-sm btn-outline-primary icon-btn"
                                               title="{{ \App\CPU\translate('تعديل') }}">
                                                <i class="fas fa-pen"></i>
                                            </a>

                                            <form action="{{ route('admin.admin.delete', [$admin->id]) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('{{ \App\CPU\translate('هل تريد حذف هذا الأدمن؟') }}')"
                                                  style="display:inline-block">
                                                @csrf @method('delete')
                                                <button class="btn btn-sm btn-outline-danger icon-btn"
                                                        title="{{ \App\CPU\translate('حذف') }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center p-4">
                                        <img class="mb-3 w-one-cl" src="{{ asset('public/assets/admin/svg/illustrations/sorry.svg') }}" alt="">
                                        <p class="mb-0">{{ \App\CPU\translate('لاتوجد بيانات لعرضها') }}</p>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>

                        <div class="page-area">
                            {!! $admins->links() !!}
                        </div>
                    </div>
                    <!-- End Table -->
                </div>
            </div>

        </div>
    </div>

</div>
@endsection

    <script src="{{ asset('public/assets/admin/js/global.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js"></script>
    <script>
        $(function(){
            $('.js-select2').select2({
                dir: 'rtl',
                width: '100%',
                minimumResultsForSearch: 0,
                placeholder: function(){ return $(this).data('placeholder') || ''; }
            });
        });
    </script>
