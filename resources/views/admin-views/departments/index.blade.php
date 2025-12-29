@extends('layouts.admin.app')

@section('title', 'الأقسام')

@push('css_or_js')
    {{-- Select2 + Font Awesome --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet"/>

    <style>
        /* ضبط RTL داخل Select2 */
        [dir="rtl"] .select2-container .select2-selection--single .select2-selection__rendered { text-align: right; }
        /* أعمدة الفلاتر */
        .filter-col { min-width: 220px; }
        /* زرار الإضافة العلوي */
        .action-btn { min-width: 86px; }
        .breadcrumb { margin-bottom: 0; }
        .table thead th { white-space: nowrap; }

        /* أزرار الإجراءات داخل الجدول: نفس المقاس، أيقونات فقط */
        .icon-btn {
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            padding: 0 !important;
        }
        .icon-btn i { font-size: 14px; line-height: 1; }
        /* مسافة متساوية بين الأزرار */
        .icon-actions {
            display: inline-flex;
            gap: 8px;
        }
        /* ألوان هادئة للحواف */
        .btn-outline-info   { border-color: #bfe4ff; color: #0d6efd; }
        .btn-outline-primary{ border-color: #cfe2ff; }
        .btn-outline-danger { border-color: #ffd6d6; }
        .btn-outline-info:hover,
        .btn-outline-primary:hover,
        .btn-outline-danger:hover { color: #fff; }
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
                <li class="breadcrumb-item active" aria-current="page">الأقسام</li>
            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h5 class="mb-0">الأقسام</h5>
            <div class="text-start">
                <a href="{{ route('admin.departments.create') }}" class="btn btn-success action-btn">إضافة</a>
            </div>
        </div>

        <div class="card-body">
            {{-- فلاتر --}}
            <form method="GET" action="{{ route('admin.departments.index') }}" class="row g-2 align-items-end mb-3">
                <div class="col-md-3 filter-col">
                    <label class="form-label mb-1">بحث (الاسم/الكود)</label>
                    <input type="text" name="q" class="form-control" value="{{ $q }}" placeholder="ابحث بالاسم أو الكود">
                </div>

                <div class="col-md-3 filter-col">
                    <label class="form-label mb-1">الحالة</label>
                    <select name="active" class="form-select js-select2" data-placeholder="الكل">
                        <option value="">الكل</option>
                        <option value="1" @selected($active==='1')>نشط</option>
                        <option value="0" @selected($active==='0')>متوقف</option>
                    </select>
                </div>

                <div class="col-md-3 filter-col">
                    <label class="form-label mb-1">القسم الأب</label>
                    <select name="parent_id" class="form-select js-select2" data-allow-clear="true" data-placeholder="— بدون —">
                        <option value="">— بدون —</option>
                        @foreach(\App\Models\Department::orderBy('level')->orderBy('name')->get(['id','name','level']) as $p)
                            <option value="{{ $p->id }}" @selected(request('parent_id')==$p->id)>
                                {{ str_repeat('— ', $p->level) }} {{ $p->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 filter-col d-flex gap-2">
                    <button class="btn btn-primary flex-fill action-btn">تصفية</button>
                    <a href="{{ route('admin.departments.index') }}" class="btn btn-outline-secondary flex-fill action-btn">إعادة</a>
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
                            <th>الأب</th>
                            <th>المستوى</th>
                            <th>الحالة</th>
                            <th>تاريخ الإنشاء</th>
                            <th class="text-start">إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($departments as $dept)
                            <tr>
                                <td>{{ $dept->id }}</td>
                                <td>{{ $dept->name }}</td>
                                <td><code>{{ $dept->code }}</code></td>
                                <td>{{ $dept->parent?->name ?? '—' }}</td>
                                <td>{{ $dept->level }}</td>
                                <td>
                                    @if($dept->active)
                                        <span class="badge bg-success">نشط</span>
                                    @else
                                        <span class="badge bg-secondary">متوقف</span>
                                    @endif
                                </td>
                                <td>{{ $dept->created_at?->format('Y-m-d') }}</td>
                                <td class="text-start">
                                    <div class="icon-actions" role="group" aria-label="عمليات">
                                        <a href="{{ route('admin.departments.show', $dept->id) }}"
                                           class="btn btn-sm btn-outline-info icon-btn"
                                           title="عرض">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.departments.edit', $dept->id) }}"
                                           class="btn btn-sm btn-outline-primary icon-btn"
                                           title="تعديل">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <form action="{{ route('admin.departments.destroy', $dept->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('هل تريد حذف هذا القسم؟')"
                                              style="display:inline-block">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger icon-btn" title="حذف">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="text-center text-muted">لا توجد أقسام.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $departments->links() }}
        </div>
    </div>
</div>
@endsection

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.full.min.js"></script>
    <script>
        $(function () {
            $('.js-select2').each(function () {
                $(this).select2({
                    dir: 'rtl',
                    width: '100%',
                    allowClear: $(this).data('allow-clear') === true || $(this).data('allow-clear') === 'true',
                    placeholder: $(this).data('placeholder') || ''
                });
            });
        });
    </script>
