@extends('layouts.admin.app')
@section('title','المهام')

@push('css_or_js')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
<style>
    .filter-col{min-width:220px}
    .icon-actions{display:inline-flex;gap:8px}
    .icon-btn{width:36px;height:36px;display:inline-flex;align-items:center;justify-content:center;border-radius:8px;padding:0!important}
    .icon-btn i{font-size:14px;line-height:1}
</style>
@endpush

@section('content')
<div class="content container-fluid">

    {{-- Breadcrumb --}}
    <div class="mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white px-3 py-2 rounded shadow-sm">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-secondary"><i class="tio-home-outlined"></i> الرئيسية</a></li>
                <li class="breadcrumb-item active" aria-current="page">المهام</li>
            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h5 class="mb-0">المهام</h5>
            <div class="text-start d-flex gap-2">
                <a href="{{ route('admin.tasks.index') }}" class="btn btn-outline-secondary">إعادة تحميل</a>
                <a href="{{ route('admin.tasks.create') }}" class="btn btn-success">إضافة مهمة</a>
            </div>
        </div>

        <div class="card-body">
            {{-- Filters --}}
            <form method="GET" action="{{ route('admin.tasks.index') }}" class="row g-2 align-items-end mb-3">
                @php($f=$filters ?? [])
                <div class="col-md-3 filter-col">
                    <label class="form-label mb-1">بحث</label>
                    <input type="text" name="q" class="form-control" value="{{ $f['q'] ?? '' }}" placeholder="العنوان أو الوصف...">
                </div>
                <div class="col-md-3 filter-col">
                    <label class="form-label mb-1">الحالة</label>
                    <select name="status_id" class="form-control js-select2" data-placeholder="الكل">
                        <option value="">الكل</option>
                        @foreach($statuses as $s)
                            <option value="{{ $s->id }}" @selected(($f['statusId'] ?? null)==$s->id)>{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 filter-col">
                    <label class="form-label mb-1">الأولوية</label>
                    <select name="priority" class="form-control js-select2" data-placeholder="الكل">
                        <option value="">الكل</option>
                        @foreach(['low'=>'منخفض','medium'=>'متوسط','high'=>'مرتفع','urgent'=>'عاجل'] as $k=>$v)
                            <option value="{{ $k }}" @selected(($f['priority'] ?? null)==$k)>{{ $v }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 filter-col">
                    <label class="form-label mb-1">المشروع</label>
                    <select name="project_id" class="form-control js-select2" data-placeholder="الكل">
                        <option value="">الكل</option>
                        @foreach($projects as $p)
                            <option value="{{ $p->id }}" @selected(($f['projectId'] ?? null)==$p->id)>{{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 filter-col">
                    <label class="form-label mb-1">المُسنَد إليه</label>
                    <select name="assignee_id" class="form-control js-select2" data-placeholder="الكل">
                        <option value="">الكل</option>
                        @foreach($assignees as $a)
                            <option value="{{ $a->id }}" @selected(($f['assignee'] ?? null)==$a->id)>{{ $a->f_name }} {{ $a->l_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 filter-col">
                    <label class="form-label mb-1">نشطة؟</label>
                    <select name="active" class="form-control js-select2" data-placeholder="الكل">
                        <option value="">الكل</option>
                        <option value="1" @selected(($f['active'] ?? '')==='1')>نعم</option>
                        <option value="0" @selected(($f['active'] ?? '')==='0')>لا</option>
                    </select>
                </div>
                <div class="col-12 d-flex gap-2">
                    <button class="btn btn-primary">تصفية</button>
                    <a href="{{ route('admin.tasks.index') }}" class="btn btn-outline-secondary">إعادة الضبط</a>
                </div>
            </form>

            {{-- Table --}}
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>العنوان</th>
                            <th>المشروع</th>
                            <th>الحالة</th>
                            <th>الأولوية</th>
                            <th>المنشئ</th>
                            <th>الاستحقاق</th>
                            <th>موافقة</th>
                            <th class="text-start">إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tasks as $idx => $t)
                            <tr>
                                <td>{{ $tasks->firstItem() + $idx }}</td>
                                <td>{{ $t->title }}</td>
                                <td>{{ $t->project?->name }}</td>
                                <td>{{ $t->status?->name }}</td>
                                <td>{{ ['low'=>'منخفض','medium'=>'متوسط','high'=>'مرتفع','urgent'=>'عاجل'][$t->priority] ?? $t->priority }}</td>
                                <td>{{ $t->creator?->f_name }} {{ $t->creator?->l_name }}</td>
                                <td>{{ $t->due_at }}</td>
                                <td>
                                    @if($t->approval_required)
                                        <span class="badge {{ $t->approval_status=='approved'?'bg-success':($t->approval_status=='rejected'?'bg-danger':'bg-warning text-dark') }}">
                                            {{ ['pending'=>'قيد المراجعة','approved'=>'موافق عليه','rejected'=>'مرفوض'][$t->approval_status] ?? $t->approval_status }}
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">لا يتطلب</span>
                                    @endif
                                </td>
                                <td class="text-start">
                                    <div class="icon-actions">
                                        <a href="{{ route('admin.tasks.show',$t->id) }}" class="btn btn-sm btn-outline-info icon-btn" title="عرض"><i class="fas fa-eye"></i></a>
                                        <a href="{{ route('admin.tasks.edit',$t->id) }}" class="btn btn-sm btn-outline-primary icon-btn" title="تعديل"><i class="fas fa-pen"></i></a>
                                        <form action="{{ route('admin.tasks.destroy',$t->id) }}" method="POST" onsubmit="return confirm('حذف هذه المهمة؟')" style="display:inline-block">
                                            @csrf @method('DELETE')
        <button class="btn btn-sm btn-outline-danger icon-btn" title="حذف"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="9" class="text-center text-muted">لا توجد بيانات.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {!! $tasks->links() !!}
        </div>
    </div>
</div>
@endsection

@push('script_2')
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js"></script>
<script>$(function(){$('.js-select2').select2({dir:'rtl',width:'100%'});});</script>
@endpush
