@extends('layouts.admin.app')

@section('title', \App\CPU\translate('هيكل الموظفين والأقسام'))

@push('css_or_js')
    <link rel="stylesheet" href="{{ asset('public/assets/admin/css/custom.css') }}"/>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>

    <style>
        /* فلاتر */
        .filter-col { min-width: 220px; }

        /* شجرة تنظيمية */
        .org-wrap { padding: 12px; background: #fff; border-radius: 12px; box-shadow: 0 6px 16px rgba(0,0,0,.06); }
        .org-branch { margin-bottom: 18px; border: 1px solid #eef1f5; border-radius: 12px; overflow: hidden; }
        .org-branch .org-branch-header {
            background: linear-gradient(135deg, #f6f9ff, #ffffff);
            padding: 12px 16px; display: flex; align-items: center; justify-content: space-between;
            border-bottom: 1px solid #eef1f5;
        }
        .org-branch .org-branch-title { font-weight: 700; color: #334; font-size: 16px; }
        .org-tree { padding: 16px; }
        .org-tree ul { padding-inline-start: 24px; position: relative; margin: 0; }
        .org-tree ul li { list-style: none; position: relative; padding: 10px 10px 10px 14px; border-left: 2px dashed #dfe6ef; }
        .org-tree ul li::before {
            content: ''; position: absolute; top: 22px; left: -2px; width: 14px; height: 2px; background: #dfe6ef;
        }
        .org-node {
            background: #f9fbff; border: 1px solid #e9eef7; border-radius: 10px; padding: 10px 12px;
            display: flex; align-items: center; gap: 10px; transition: box-shadow .2s ease, transform .15s ease;
        }
        .org-node:hover { box-shadow: 0 8px 18px rgba(61,97,191,.08); transform: translateY(-1px); }
        .org-node .avatar {
            width: 34px; height: 34px; border-radius: 50%; background: #e7efff; display: inline-flex;
            align-items: center; justify-content: center; font-weight: 700; color: #446; flex: 0 0 auto;
        }
        .org-node .meta { display: flex; flex-direction: column; line-height: 1.2; }
        .org-node .name { font-weight: 700; color: #223; }
        .org-node .sub { color: #678; font-size: 12px; }
        .org-badge {
            font-size: 11px; padding: 2px 8px; border-radius: 999px; background: #eef4ff; color: #2b59c3; border: 1px solid #dbe6ff;
        }
        .org-toggle {
            cursor: pointer; user-select: none; border: 0; background: transparent; color: #445; padding: 6px 10px;
        }
        .org-toggle i { transition: transform .2s ease; }
        .collapsed > .org-tree { display: none; }
        .collapsed > .org-branch-header .org-toggle i { transform: rotate(-90deg); }

        /* وسم القسم */
        .dep-title {
            display: inline-flex; align-items: center; gap: 8px; margin: 10px 0 6px; font-weight: 700; color: #394; background: #f4fff6;
            padding: 6px 10px; border-radius: 999px; border: 1px solid #dff0e1;
        }
        .dep-title .dot { width: 8px; height: 8px; border-radius: 50%; background: #3b995d; }

        /* أيقونات الإجراءات */
        .node-actions { margin-inline-start: auto; display: inline-flex; gap: 6px; }
        .icon-btn {
            width: 34px; height: 34px; display: inline-flex; align-items: center; justify-content: center;
            border-radius: 8px; border: 1px solid #e6ebf3; background: #fff; color: #345;
        }
        .icon-btn:hover { background: #f6f8fc; }

        /* توافق RTL Select2 */
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
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.admin.list') }}" class="text-primary">
                        {{ \App\CPU\translate('قائمة الأدمن') }}
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ \App\CPU\translate('هيكل الموظفين والأقسام') }}
                </li>
            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h5 class="mb-0">{{ \App\CPU\translate('هيكل الموظفين والأقسام') }}</h5>
            <div class="text-start">
                <a href="{{ route('admin.admin.structure') }}" class="btn btn-outline-secondary">{{ \App\CPU\translate('إعادة تحميل') }}</a>
            </div>
        </div>

        <div class="card-body">

            {{-- فلاتر --}}
            <form method="GET" action="{{ route('admin.admin.structure') }}" class="row g-2 align-items-end mb-3">
                <div class="col-md-4 filter-col">
                    <label class="form-label mb-1">{{ \App\CPU\translate('الفرع') }}</label>
                    <select name="branch_id" class="form-control js-select2" data-placeholder="-- {{ \App\CPU\translate('الكل') }} --">
                        <option value="">{{ \App\CPU\translate('الكل') }}</option>
                        @foreach($branchesAll as $b)
                            <option value="{{ $b->id }}" @selected($branchId==$b->id)>{{ $b->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 filter-col">
                    <label class="form-label mb-1">{{ \App\CPU\translate('القسم') }}</label>
                    <select name="department_id" class="form-control js-select2" data-placeholder="-- {{ \App\CPU\translate('الكل') }} --">
                        <option value="">{{ \App\CPU\translate('الكل') }}</option>
                        @foreach($departments as $d)
                            <option value="{{ $d->id }}" @selected($departmentId==$d->id)>{{ $d->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 filter-col">
                    <label class="form-label mb-1">{{ \App\CPU\translate('المدير') }}</label>
                    <select name="manager_id" class="form-control js-select2" data-placeholder="-- {{ \App\CPU\translate('الكل') }} --">
                        <option value="">{{ \App\CPU\translate('الكل') }}</option>
                        @foreach($managers as $m)
                            <option value="{{ $m->id }}" @selected($managerId==$m->id)>{{ $m->f_name }} {{ $m->l_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 d-flex gap-2">
                    <button class="btn btn-primary">{{ \App\CPU\translate('تصفية') }}</button>
                    <a href="{{ route('admin.admin.structure') }}" class="btn btn-outline-secondary">{{ \App\CPU\translate('إعادة الضبط') }}</a>
                </div>
            </form>

            {{-- محتوى الشجرة --}}
            <div class="org-wrap">

                @php
                    // دالة مساعدة لعمل شجرة (مدير -> مرؤوسين) داخل القسم
                    $renderTree = function($roots, $childrenMap) use (&$renderTree) {
                        echo '<ul>';
                        foreach ($roots as $node) {
                            $name = trim(($node->f_name ?? '').' '.($node->l_name ?? ''));
                            $dept = optional($node->department)->name ?: \App\CPU\translate('بدون قسم');
                            $mgr  = optional($node->manager);
                            $initials = strtoupper(mb_substr($node->f_name,0,1)).strtoupper(mb_substr($node->l_name,0,1));
                            echo '<li>';
                            echo '<div class="org-node">';
                            echo    '<span class="avatar" title="'.e($name).'">'.e($initials).'</span>';
                            echo    '<span class="meta">';
                            echo        '<span class="name">'.e($name).'</span>';
                            echo        '<span class="sub">'.e($node->email).' • '.e($dept).'</span>';
                            echo    '</span>';
                            echo    '<span class="node-actions">';
                            echo        '<a class="icon-btn" href="'.route('admin.admin.edit', $node->id).'" title="'.\App\CPU\translate('تعديل').'"><i class="fas fa-pen"></i></a>';
                            echo        '<form action="'.route('admin.admin.delete', $node->id).'" method="POST" onsubmit="return confirm(\''.\App\CPU\translate('هل تريد حذف هذا الأدمن؟').'\')" style="display:inline-block">';
                            echo            csrf_field().method_field('delete');
                            echo            '<button type="submit" class="icon-btn" title="'.\App\CPU\translate('حذف').'"><i class="fas fa-trash"></i></button>';
                            echo        '</form>';
                            echo    '</span>';
                            echo '</div>';

                            // لو له أولاد، اطبعهم
                            if (!empty($childrenMap[$node->id] ?? [])) {
                                $renderTree($childrenMap[$node->id], $childrenMap);
                            }
                            echo '</li>';
                        }
                        echo '</ul>';
                    };
                @endphp

                @forelse($branches as $branch)
                    @php
                        // تصفية إداريي الفرع حسب الفلاتر الموجودة بالفعل بالكونترولر
                        $adminsInBranch = $branch->admins ?? collect();

                        // بناء خريطة (manager_id => مرؤوسين)
                        $childrenMap = [];
                        foreach ($adminsInBranch as $adm) {
                            $childrenMap[$adm->manager_id ?? 0][] = $adm;
                        }

                        // الجذور = بدون مدير (manager_id null) أو غير موجود في نفس الفرع
                        $roots = $childrenMap[0] ?? [];
                    @endphp

                    <div class="org-branch" data-branch="{{ $branch->id }}">
                        <div class="org-branch-header">
                            <span class="org-branch-title">
                                {{ \App\CPU\translate('الفرع') }}: {{ $branch->name }}
                                <span class="org-badge">{{ \App\CPU\translate('عدد الموظفين') }}: {{ $adminsInBranch->count() }}</span>
                            </span>
                            <button class="org-toggle" type="button" onclick="this.closest('.org-branch').classList.toggle('collapsed')">
                                <i class="tio-chevron-down"></i>
                            </button>
                        </div>

                        <div class="org-tree">
                            {{-- تجميع حسب الأقسام لوسم القسم فقط (العرض يظل هرمي بالمدير/المرؤوس) --}}
                            @php
                                $depsInBranch = $adminsInBranch->map(function($a){ return optional($a->department)->name ?: \App\CPU\translate('بدون قسم'); })->unique()->values();
                            @endphp

                            @foreach($depsInBranch as $depName)
                                <div class="dep-title">
                                    <span class="dot"></span>
                                    <span>{{ \App\CPU\translate('القسم') }}: {{ $depName }}</span>
                                </div>

                                {{-- نطبع الشجرة نفسها (الجذور -> مرؤوسين) لكن هنفلتر العرض بحيث يظهر فقط من ينتمي لهذا القسم --}}
                                @php
                                    // نحتاج جذور هذا القسم فقط
                                    $rootsForDep = array_values(array_filter($roots, function($r) use ($depName) {
                                        return (optional($r->department)->name ?: \App\CPU\translate('بدون قسم')) === $depName;
                                    }));

                                    // childrenMap نفسه، لكن الدالة سترسم فروع من الجذور المحددة
                                @endphp
                                @if(count($rootsForDep))
                                    @php $renderTree($rootsForDep, $childrenMap); @endphp
                                @else
                                    <ul><li><div class="org-node"><span class="meta"><span class="sub">{{ \App\CPU\translate('لا يوجد عناصر جذرية في هذا القسم') }}</span></span></div></li></ul>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @empty
                    <div class="text-center p-4">
                        <img class="mb-3 w-one-cl" src="{{ asset('public/assets/admin/svg/illustrations/sorry.svg') }}" alt="">
                        <p class="mb-0">{{ \App\CPU\translate('لاتوجد بيانات لعرضها') }}</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</div>
@endsection

@push('script_2')
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.full.min.js"></script>
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
@endpush
