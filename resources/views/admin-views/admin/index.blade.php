@extends('layouts.admin.app')

@section('title', \App\CPU\translate('add_new_admin'))

@push('css_or_js')
    <link rel="stylesheet" href="{{ asset('public/assets/admin/css/custom.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <style>
        .tag-input { background-color:#f1f1f1; border-radius:5px; padding:6px 12px; margin:3px; display:inline-block; }
        /* أزرار الحفظ والإلغاء: على الشمال، نفس المقاس، عرض أكبر من ارتفاع */
        .form-actions { display:flex; gap:12px; justify-content:flex-start; }
        .form-actions .erp-btn { height:42px; min-width:140px; display:inline-flex; align-items:center; justify-content:center; border-radius:8px; }
        /* تحسين RTL داخل Select2 */
        [dir="rtl"] .select2-container .select2-selection--single .select2-selection__rendered{ text-align:right; }
        .select2-container--default .select2-selection--single{ height:38px; }
        .select2-container--default .select2-selection--single .select2-selection__rendered{ line-height:38px; }
        .select2-container--default .select2-selection--single .select2-selection__arrow{ height:38px; }
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
                    <a href="{{route('admin.admin.list')}}" class="text-primary">
                        {{ \App\CPU\translate('قائمة الأدمن') }}
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ \App\CPU\translate('إضافة ادمن جديد') }}
                </li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('admin.admin.store') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        {{-- الأسماء --}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="input-label">{{ \App\CPU\translate('الاسم الاول') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="f_name" class="form-control" value="{{ old('f_name') }}" placeholder="{{ \App\CPU\translate('first_name') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="input-label">{{ \App\CPU\translate('الاسم الاخير') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="l_name" class="form-control" value="{{ old('l_name') }}" placeholder="{{ \App\CPU\translate('last_name') }}" required>
                                </div>
                            </div>
                        </div>

                        {{-- البريد وكلمة المرور --}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="input-label">{{ \App\CPU\translate('البريد الألكتروني') }} <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="{{ \App\CPU\translate('Ex_:_ex@example.com') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="input-label">{{ \App\CPU\translate('كلمة المرور') }} <span class="text-danger">*</span></label>
                                    <input type="password" name="password" class="form-control" placeholder="{{ \App\CPU\translate('password') }}" required>
                                </div>
                            </div>
                        </div>

                        {{-- الموقع (اختياري) --}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="input-label">{{ \App\CPU\translate('خط العرض (اختياري)') }}</label>
                                    <input type="text" name="latitude" class="form-control" value="{{ old('latitude') }}" placeholder="Eg. 30.0444">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="input-label">{{ \App\CPU\translate('خط الطول (اختياري)') }}</label>
                                    <input type="text" name="longitude" class="form-control" value="{{ old('longitude') }}" placeholder="Eg. 31.2357">
                                </div>
                            </div>
                        </div>

                        {{-- الدور والفرع والورديات --}}
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="input-label">{{ \App\CPU\translate('الدور') }} <span class="text-danger">*</span></label>
                                    <select name="role_id" class="form-control js-select2" required data-placeholder="-- اختار دور --">
                                        <option value="" hidden>-- اختار دور --</option>
                                        @foreach($roles as $cat)
                                            <option value="{{ $cat->id }}" {{ old('role_id') == $cat->id ? 'selected' : '' }}>
                                                {{ $cat->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="input-label">{{ \App\CPU\translate('الفرع') }} <span class="text-danger">*</span></label>
                                    <select name="branch_id" id="branch_id" class="form-control js-select2" required data-placeholder="-- اختار فرع --">
                                        <option value="" hidden>-- اختار فرع --</option>
                                        @foreach($branches as $cat)
                                            <option value="{{ $cat->id }}" {{ old('branch_id') == $cat->id ? 'selected' : '' }}>
                                                {{ $cat->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="input-label">{{ \App\CPU\translate('الوردية') }}</label>
                                    <select name="shift_id" class="form-control js-select2" data-placeholder="-- اختار وردية --">
                                        <option value="" {{ old('shift_id') ? '' : 'selected' }}>-- اختار وردية --</option>
                                        @foreach($shifts as $sh)
                                            <option value="{{ $sh->id }}" {{ old('shift_id') == $sh->id ? 'selected' : '' }}>
                                                {{ $sh->name ?? ('Shift #'.$sh->id) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- القسم والمدير --}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="input-label">{{ \App\CPU\translate('القسم') }}</label>
                                    <select name="department_id" id="department_id" class="form-control js-select2" data-placeholder="-- اختار قسم --">
                                        <option value="" {{ old('department_id') ? '' : 'selected' }}>-- اختار قسم --</option>
                                        @foreach($departments as $dep)
                                            <option value="{{ $dep->id }}" {{ old('department_id') == $dep->id ? 'selected' : '' }}>
                                                {{ $dep->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="input-label">{{ \App\CPU\translate('المدير المباشر') }}</label>
                                    <select name="manager_id" id="manager_id" class="form-control js-select2" data-placeholder="-- اختار مدير --" data-allow-clear="true">
                                        <option value="" {{ old('manager_id') ? '' : 'selected' }}>-- اختار مدير --</option>
                                        @foreach($managers as $mgr)
                                            <option
                                                value="{{ $mgr->id }}"
                                                data-branch="{{ $mgr->branch_id ?? '' }}"
                                                data-department="{{ $mgr->department_id ?? '' }}"
                                                {{ old('manager_id') == $mgr->id ? 'selected' : '' }}>
                                                {{ $mgr->f_name }} {{ $mgr->l_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">{{ \App\CPU\translate('سيتم تصفية قائمة المديرين تلقائيًا حسب الفرع والقسم إن أمكن') }}</small>
                                </div>
                            </div>
                        </div>

                        {{-- المناديب (متعدد) --}}
                    

                        {{-- أزرار الإجراء --}}
                        <div class="form-actions mt-4">
                            <button type="submit" class="btn btn-primary erp-btn">
                                {{ \App\CPU\translate('حفظ') }}
                            </button>
                            <a href="{{ route('admin.admin.list') }}" class="btn btn-outline-secondary erp-btn">
                                {{ \App\CPU\translate('إلغاء') }}
                            </a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.full.min.js"></script>
    <script>
        $(function () {
            // تفعيل Select2 لكل القوائم
            $('.js-select2').each(function () {
                $(this).select2({
                    dir: 'rtl',
                    width: '100%',
                    allowClear: $(this).data('allow-clear') === true || $(this).data('allow-clear') === 'true',
                    placeholder: $(this).data('placeholder') || '',
                    minimumResultsForSearch: 0
                });
            });

            // فلترة قائمة المديرين حسب الفرع والقسم (اختياري)
            const $manager   = $('#manager_id');
            const $branch    = $('#branch_id');
            const $department= $('#department_id');

            function filterManagers() {
                const branchId = $branch.val();
                const depId    = $department.val();

                // ارجع كل الخيارات أولًا
                $manager.find('option').show();

                if (branchId || depId) {
                    $manager.find('option').each(function () {
                        const b = $(this).data('branch')?.toString() || '';
                        const d = $(this).data('department')?.toString() || '';

                        // حافظ على الخيار الفارغ
                        if (!$(this).val()) return;

                        // قاعدة: لو الفرع محدد، لازم يطابق. ولو القسم محدد، يطابق هو كمان.
                        const okBranch = branchId ? (b === branchId) : true;
                        const okDept   = depId    ? (d === depId)    : true;

                        if (!(okBranch && okDept)) {
                            $(this).hide();
                            if ($(this).is(':selected')) {
                                // لو الخيار الحالي اتخفى وكان مختار، الغِ اختياره
                                $manager.val(null).trigger('change.select2');
                            }
                        }
                    });
                }

                // تحديث واجهة Select2
                $manager.trigger('change.select2');
            }

            $branch.on('change', filterManagers);
            $department.on('change', filterManagers);

            // تشغيل أولي
            filterManagers();
        });
    </script>
    <script src="{{ asset('public/assets/admin/js/global.js') }}"></script>
