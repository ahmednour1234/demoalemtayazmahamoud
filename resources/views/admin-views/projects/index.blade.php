@extends('layouts.admin.app')

@section('title', 'المشروعات')

@push('css_or_js')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
<style>
    .filter-col{min-width:220px}
    .icon-actions{display:inline-flex;gap:8px}
    .icon-btn{width:36px;height:36px;display:inline-flex;align-items:center;justify-content:center;border-radius:8px;padding:0!important}
    .icon-btn i{font-size:14px;line-height:1}
    [dir="rtl"] .select2-container .select2-selection--single .select2-selection__rendered{text-align:right}
    .select2-container--default .select2-selection--single{height:38px}
    .select2-container--default .select2-selection--single .select2-selection__rendered{line-height:38px}
    .select2-container--default .select2-selection--single .select2-selection__arrow{height:38px}
</style>
@endpush

@section('content')
<div class="content container-fluid">

    {{-- Breadcrumb --}}
    <div class="mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white px-3 py-2 rounded shadow-sm">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}" class="text-secondary">
                        <i class="tio-home-outlined"></i> الرئيسية
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">المشروعات</li>
            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h5 class="mb-0">المشروعات</h5>
            <div class="text-start d-flex gap-2">
                <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-secondary">إعادة تحميل</a>
                <a href="{{ route('admin.projects.create') }}" class="btn btn-success">إضافة مشروع</a>
            </div>
        </div>

        <div class="card-body">
            {{-- Filters --}}
            <form method="GET" action="{{ route('admin.projects.index') }}" class="row g-2 align-items-end mb-3">
                @php($f=$filters ?? [])
                <div class="col-md-3 filter-col">
                    <label class="form-label mb-1">بحث</label>
                    <input type="text" name="q" class="form-control" value="{{ $f['q'] ?? '' }}" placeholder="الاسم أو الكود...">
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
                    <label class="form-label mb-1">المالك</label>
                    <select name="owner_id" class="form-control js-select2" data-placeholder="الكل">
                        <option value="">الكل</option>
                        @foreach($owners as $o)
                            <option value="{{ $o->id }}" @selected(($f['ownerId'] ?? null)==$o->id)>{{ $o->f_name }} {{ $o->l_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 filter-col">
                    <label class="form-label mb-1">نشط؟</label>
                    <select name="active" class="form-control js-select2" data-placeholder="الكل">
                        <option value="">الكل</option>
                        <option value="1" @selected(($f['active'] ?? '')==='1')>نشط</option>
                        <option value="0" @selected(($f['active'] ?? '')==='0')>متوقف</option>
                    </select>
                </div>
                <div class="col-12 d-flex gap-2">
                    <button class="btn btn-primary">تصفية</button>
                    <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-secondary">إعادة الضبط</a>
                </div>
            </form>

            {{-- Table --}}
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>الاسم</th>
                            <th>الكود</th>
                            <th>الحالة</th>
                            <th>الأولوية</th>
                            <th>المالك</th>
                            <th>تاريخ البدء</th>
                            <th>الإستحقاق</th>
                            <th>نشط</th>
                            <th class="text-start">إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($projects as $idx => $p)
                            <tr>
                                <td>{{ $projects->firstItem() + $idx }}</td>
                                <td>{{ $p->name }}</td>
                                <td><code>{{ $p->code }}</code></td>
                                <td>{{ $p->status?->name }}</td>
                                <td>{{ ucfirst($p->priority) }}</td>
                                <td>{{ $p->owner?->f_name }} {{ $p->owner?->l_name }}</td>
                                <td>{{ $p->start_date }}</td>
                                <td>{{ $p->due_date }}</td>
                                <td>
                                    @if($p->active)
                                        <span class="badge bg-success">نشط</span>
                                    @else
                                        <span class="badge bg-secondary">متوقف</span>
                                    @endif
                                </td>
                                <td class="text-start">
                                    <div class="icon-actions" role="group">
                                        <a href="{{ route('admin.projects.show',$p->id) }}" class="btn btn-sm btn-outline-info icon-btn" title="عرض">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.projects.edit',$p->id) }}" class="btn btn-sm btn-outline-primary icon-btn" title="تعديل">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <form action="{{ route('admin.projects.destroy',$p->id) }}" method="POST" onsubmit="return confirm('حذف هذا المشروع؟')" style="display:inline-block">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger icon-btn" title="حذف">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="10" class="text-center text-muted">لا توجد بيانات.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {!! $projects->links() !!}
        </div>
    </div>
</div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js"></script>
<script>
$(function(){
  $('.js-select2').select2({dir:'rtl',width:'100%',minimumResultsForSearch:0});
});
</script>
