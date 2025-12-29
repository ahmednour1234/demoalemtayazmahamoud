{{-- resources/views/admin-views/statuses/index.blade.php --}}
@extends('layouts.admin.app')

@section('title', 'الحالات')

@push('css_or_js')
<style>
    .action-btn { width: 36px; height: 36px; display:inline-flex; align-items:center; justify-content:center; border-radius:8px; }
    .table thead th { white-space: nowrap; }
    .filter-col { min-width: 220px; }
</style>
@endpush

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
                <li class="breadcrumb-item active" aria-current="page">الحالات</li>
            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h5 class="mb-0">الحالات</h5>
            <div>
                <a href="{{ route('admin.status.create') }}" class="btn btn-success">إضافة</a>
            </div>
        </div>

        <div class="card-body">
            {{-- فلاتر --}}
            <form method="GET" action="{{ route('admin.status.index') }}" class="row g-2 align-items-end mb-3">
                <div class="col-md-4 filter-col">
                    <label class="form-label mb-1">بحث</label>
                    <input type="text" name="q" class="form-control" value="{{ $q }}" placeholder="الاسم أو الكود">
                </div>
                <div class="col-md-4 filter-col">
                    <label class="form-label mb-1">الحالة</label>
                    <select name="active" class="form-select">
                        <option value="">الكل</option>
                        <option value="1" @selected($active==='1')>نشط</option>
                        <option value="0" @selected($active==='0')>متوقف</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button class="btn btn-primary flex-fill">تصفية</button>
                    <a href="{{ route('admin.status.index') }}" class="btn btn-outline-secondary flex-fill">إعادة</a>
                </div>
            </form>

            {{-- جدول --}}
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        <th>الكود</th>
                        <th>اللون</th>
                        <th>الترتيب</th>
                        <th>نشط؟</th>
                        <th class="text-start">إجراءات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($statuses as $i => $st)
                        <tr>
                            <td>{{ $statuses->firstItem() + $i }}</td>
                            <td>{{ $st->name }}</td>
                            <td><code>{{ $st->code }}</code></td>
                            <td>
                                @if($st->color)
                                    <span class="badge" style="background: {{ $st->color }};">&nbsp;&nbsp;</span>
                                    <small class="text-muted">{{ $st->color }}</small>
                                @else
                                    —
                                @endif
                            </td>
                            <td>{{ $st->sort_order }}</td>
                            <td>
                                @if($st->active)
                                    <span class="badge bg-success">نشط</span>
                                @else
                                    <span class="badge bg-secondary">متوقف</span>
                                @endif
                            </td>
                            <td class="text-start">
                                <div class="d-inline-flex gap-1">
                                    <form action="{{ route('admin.status.active', $st->id) }}" method="POST" onsubmit="return confirm('تبديل حالة التفعيل؟')">
                                        @csrf @method('PATCH')
                                        <button class="btn btn-sm btn-outline-warning action-btn" title="تفعيل/تعطيل">
                                            <i class="fas fa-power-off"></i>
                                        </button>
                                    </form>

                                    <a href="{{ route('admin.status.edit', $st->id) }}" class="btn btn-sm btn-outline-primary action-btn" title="تعديل">
                                        <i class="fas fa-pen"></i>
                                    </a>

                                    <form action="{{ route('admin.status.destroy', $st->id) }}" method="POST" onsubmit="return confirm('حذف الحالة؟')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger action-btn" title="حذف">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted">لا توجد حالات.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            {!! $statuses->links() !!}
        </div>
    </div>
</div>
@endsection

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js"></script>
