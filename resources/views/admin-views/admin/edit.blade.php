@extends('layouts.admin.app')

@section('title', \App\CPU\translate('update_admin'))

@push('css_or_js')
    <link rel="stylesheet" href="{{ asset('public/assets/admin/css/custom.css') }}"/>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <style>
        .form-group label { font-weight: bold; }
        .card { border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,.1); }
        .btn-primary { background-color: #007bff; border-radius: 8px; }
        /* أزرار الإجراء: يسار + مسافة + نفس المقاس + عرض أكبر من ارتفاع */
        .form-actions { display: flex; gap: 12px; justify-content: flex-start; }
        .form-actions .erp-btn { height: 42px; min-width: 140px; display: inline-flex; align-items: center; justify-content: center; border-radius: 8px; }
        /* Select2 RTL height alignment */
        [dir="rtl"] .select2-container .select2-selection--single .select2-selection__rendered{ text-align: right; }
        .select2-container--default .select2-selection--single{ height: 38px; }
        .select2-container--default .select2-selection--single .select2-selection__rendered{ line-height: 38px; }
        .select2-container--default .select2-selection--single .select2-selection__arrow{ height: 38px; }
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
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.admin.list') }}" class="text-primary">
                        {{ \App\CPU\translate('قائمة الأدمن') }}
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ \App\CPU\translate('تحديث ادمن') }}
                </li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card p-4">
                <div class="card-body">
                    <form action="{{ route('admin.admin.update', [$admin->id]) }}" method="post" enctype="multipart/form-data">
                        @csrf

                        {{-- الاسم الأول / الأخير --}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ \App\CPU\translate('الاسم الاول') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="f_name" class="form-control" value="{{ old('f_name', $admin->f_name) }}" placeholder="{{ \App\CPU\translate('first_name') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ \App\CPU\translate('الاسم الاخير') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="l_name" class="form-control" value="{{ old('l_name', $admin->l_name) }}" placeholder="{{ \App\CPU\translate('last_name') }}" required>
                                </div>
                            </div>
                        </div>

                        {{-- البريد / كلمة المرور --}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ \App\CPU\translate('البريد الالكتروني') }} <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email', $admin->email) }}" placeholder="{{ \App\CPU\translate('Ex_:_ex@example.com') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ \App\CPU\translate('كلمة المرور') }}</label>
                                    <input type="password" name="password" class="form-control" placeholder="{{ \App\CPU\translate('password') }}">
                                    <small class="text-muted">{{ \App\CPU\translate('اتركه فارغًا إذا لا تريد تغييره') }}</small>
                                </div>
                            </div>
                        </div>

                        {{-- الدور / الفرع / الوردية --}}
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{ \App\CPU\translate('الدور') }} <span class="text-danger">*</span></label>
                                    <select name="role_id" class="form-control js-select2" required data-placeholder="-- اختار الدور --">
                                        <option value="" hidden>-- اختار الدور --</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}" @selected(old('role_id', $admin->role_id) == $role->id)>{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{ \App\CPU\translate('الفرع') }} <span class="text-danger">*</span></label>
                                    <select name="branch_id" id="branch_id" class="form-control js-select2" required data-placeholder="-- اختار الفرع --">
                                        <option value="" hidden>-- اختار الفرع --</option>
                                        @foreach($branches as $branch)
                                            <option value="{{ $branch->id }}" @selected(old('branch_id', $admin->branch_id) == $branch->id)>{{ $branch->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{ \App\CPU\translate('الوردية') }}</label>
                                    <select name="shift_id" class="form-control js-select2" data-placeholder="-- اختار وردية --">
                                        <option value="">{{ \App\CPU\translate('بدون') }}</option>
                                        @foreach($shifts as $sh)
                                            <option value="{{ $sh->id }}" @selected(old('shift_id', $admin->shift_id) == $sh->id)>{{ $sh->name ?? ('Shift #'.$sh->id) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- الموقع (اختياري) --}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ \App\CPU\translate('خط العرض (اختياري)') }}</label>
                                    <input type="text" name="latitude" class="form-control" value="{{ old('latitude', $admin->latitude) }}" placeholder="Eg. 30.0444">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ \App\CPU\translate('خط الطول (اختياري)') }}</label>
                                    <input type="text" name="longitude" class="form-control" value="{{ old('longitude', $admin->longitude) }}" placeholder="Eg. 31.2357">
                                </div>
                            </div>
                        </div>

                        {{-- القسم / المدير المباشر --}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ \App\CPU\translate('القسم') }}</label>
                                    <select name="department_id" id="department_id" class="form-control js-select2" data-placeholder="-- اختار قسم --">
                                        <option value="">{{ \App\CPU\translate('بدون') }}</option>
                                        @foreach($departments as $dep)
                                            <option value="{{ $dep->id }}" @selected(old('department_id', $admin->department_id) == $dep->id)>{{ $dep->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ \App\CPU\translate('المدير المباشر') }}</label>
                                    <select name="manager_id" id="manager_id" class="form-control js-select2" data-placeholder="-- اختار مدير --" data-allow-clear="true">
                                        <option value="">{{ \App\CPU\translate('بدون') }}</option>
                                        @foreach($managers as $mgr)
                                            <option
                                                value="{{ $mgr->id }}"
                                                data-branch="{{ $mgr->branch_id ?? '' }}"
                                                data-department="{{ $mgr->department_id ?? '' }}"
                                                @selected(old('manager_id', $admin->manager_id) == $mgr->id)
                                            >
                                                {{ $mgr->f_name }} {{ $mgr->l_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">{{ \App\CPU\translate('سيتم تصفية المديرين تلقائيًا حسب الفرع/القسم لو متاح') }}</small>
                                </div>
                            </div>
                        </div>

                        {{-- أزرار الإجراء --}}
                        <div class="form-actions mt-4">
                            <button type="submit" class="btn btn-primary erp-btn">{{ \App\CPU\translate('تحديث') }}</button>
                            <a href="{{ route('admin.admin.list') }}" class="btn btn-outline-secondary erp-btn">{{ \App\CPU\translate('إلغاء') }}</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('script_2')
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.full.min.js"></script>
    <script>
        $(function () {
            // تفعيل Select2
            $('.js-select2').each(function () {
                $(this).select2({
                    dir: 'rtl',
                    width: '100%',
                    allowClear: $(this).data('allow-clear') === true || $(this).data('allow-clear') === 'true',
                    placeholder: $(this).data('placeholder') || '',
                    minimumResultsForSearch: 0
                });
            });

            // فلترة المديرين حسب الفرع/القسم
            const $manager    = $('#manager_id');
            const $branch     = $('#branch_id');
            const $department = $('#department_id');

            function filterManagers() {
                const branchId = $branch.val();
                const depId    = $department.val();

                $manager.find('option').show();

                if (branchId || depId) {
                    $manager.find('option').each(function () {
                        const val = $(this).val();
                        if (!val) return; // خيار "بدون"

                        const b = ($(this).data('branch') || '').toString();
                        const d = ($(this).data('department') || '').toString();

                        const okBranch = branchId ? (b === branchId) : true;
                        const okDept   = depId    ? (d === depId)    : true;

                        if (!(okBranch && okDept)) {
                            $(this).hide();
                            // لو الخيار المتخفي هو المختار، الغِه
                            if ($(this).is(':selected')) {
                                $manager.val(null).trigger('change.select2');
                            }
                        }
                    });
                }

                $manager.trigger('change.select2');
            }

            $branch.on('change', filterManagers);
            $department.on('change', filterManagers);

            // تشغيل أولي بالحالة الحالية
            filterManagers();
        });
    </script>
@endpush
