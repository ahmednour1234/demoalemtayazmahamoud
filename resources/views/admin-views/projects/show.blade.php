@extends('layouts.admin.app')
@section('title','تفاصيل مشروع')

@push('css_or_js')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
<style>
    .kv{display:grid;grid-template-columns:160px 1fr;gap:8px 16px}
    .kv .k{color:#6c757d}
    .badge.round{border-radius:10px;padding:.4rem .6rem}
    .icon-actions{display:inline-flex;gap:8px}
    .icon-btn{width:36px;height:36px;display:inline-flex;align-items:center;justify-content:center;border-radius:8px;padding:0!important}
    .icon-btn i{font-size:14px;line-height:1}
    .section-title{font-weight:700;font-size:1.05rem}
</style>
@endpush

@section('content')
<div class="content container-fluid">

    {{-- Breadcrumb --}}
    <div class="mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white px-3 py-2 rounded shadow-sm">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-secondary"><i class="tio-home-outlined"></i> الرئيسية</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.projects.index') }}" class="text-primary">المشروعات</a></li>
                <li class="breadcrumb-item active" aria-current="page">تفاصيل مشروع</li>
            </ol>
        </nav>
    </div>

    <div class="card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h5 class="mb-0">{{ $project->name }} <small class="text-muted">(<code>{{ $project->code }}</code>)</small></h5>
            <div class="icon-actions">
                <a href="{{ route('admin.projects.edit',$project->id) }}" class="btn btn-sm btn-outline-primary icon-btn" title="تعديل">
                    <i class="fas fa-pen"></i>
                </a>
                <form action="{{ route('admin.projects.destroy',$project->id) }}" method="POST" onsubmit="return confirm('حذف هذا المشروع؟')" style="display:inline-block">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger icon-btn" title="حذف"><i class="fas fa-trash"></i></button>
                </form>
            </div>
        </div>

        <div class="card-body">
            <div class="row g-4">
                <div class="col-lg-7">
                    <div class="kv">
                        <div class="k">الاسم:</div> <div class="v">{{ $project->name }}</div>
                        <div class="k">الكود:</div> <div class="v"><code>{{ $project->code }}</code></div>
                        <div class="k">الحالة:</div> <div class="v">{{ $project->status?->name ?? '—' }}</div>
                        <div class="k">الأولوية:</div>
                        <div class="v">
                            @php $prioMap=['low'=>'منخفض','medium'=>'متوسط','high'=>'مرتفع','urgent'=>'عاجل']; @endphp
                            <span class="badge round bg-light text-dark">{{ $prioMap[$project->priority] ?? $project->priority }}</span>
                        </div>
                        <div class="k">المالك:</div>
                        <div class="v">{{ $project->owner?->f_name }} {{ $project->owner?->l_name }}</div>
                        <div class="k">تاريخ البدء:</div> <div class="v">{{ $project->start_date ?? '—' }}</div>
                        <div class="k">الاستحقاق:</div>   <div class="v">{{ $project->due_date ?? '—' }}</div>
                        <div class="k">نشط؟</div>
                        <div class="v">
                            @if($project->active)
                                <span class="badge bg-success">نشط</span>
                            @else
                                <span class="badge bg-secondary">متوقف</span>
                            @endif
                        </div>
                    </div>
                    @if($project->description)
                        <hr>
                        <div>
                            <div class="section-title mb-2">الوصف</div>
                            <p class="mb-0">{{ $project->description }}</p>
                        </div>
                    @endif
                </div>

                <div class="col-lg-5">
                    {{-- أعضاء المشروع --}}
                    <div class="section-title mb-2">أعضاء المشروع</div>
                    <div class="table-responsive">
                        <table class="table table-sm align-middle">
                            <thead>
                                <tr>
                                    <th>الموظف</th>
                                    <th>الدور</th>
                                    <th class="text-start">إجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($project->members as $m)
                                    <tr>
                                        <td>{{ $m->admin?->f_name }} {{ $m->admin?->l_name }}</td>
                                        <td>{{ ['owner'=>'مالك','leader'=>'قائد','member'=>'عضو','viewer'=>'مشاهد'][$m->role] ?? $m->role }}</td>
                                        <td class="text-start">
                                            <form action="{{ route('admin.projects.members.destroy',[$project->id,$m->id]) }}" method="POST" onsubmit="return confirm('إزالة العضو؟')" style="display:inline-block">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger icon-btn" title="حذف"><i class="fas fa-user-minus"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="text-muted text-center">لا يوجد أعضاء.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- إضافة عضو --}}
                    <form action="{{ route('admin.projects.members.store',$project->id) }}" method="POST" class="row g-2 align-items-end">
                        @csrf
                        <div class="col-7">
                            <label class="form-label mb-1">إضافة عضو</label>
                            <select name="admin_id" class="form-control js-select2" data-placeholder="— اختر الموظف —" required>
                                <option value="">—</option>
                                @foreach(\App\Models\Admin::select('id','f_name','l_name')->orderBy('f_name')->get() as $a)
                                    <option value="{{ $a->id }}">{{ $a->f_name }} {{ $a->l_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-5">
                            <label class="form-label mb-1">الدور</label>
                            <select name="role" class="form-control js-select2" required>
                                <option value="member">عضو</option>
                                <option value="leader">قائد</option>
                                <option value="viewer">مشاهد</option>
                            </select>
                        </div>
                        <div class="col-12 d-flex justify-content-end">
                            <button class="btn btn-primary">إضافة</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- مهام المشروع --}}
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="mb-0">مهام المشروع</h6>
            <a href="{{ route('admin.tasks.create', ['project_id'=>$project->id]) }}" class="btn btn-sm btn-success">إضافة مهمة</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>العنوان</th>
                            <th>الحالة</th>
                            <th>الأولوية</th>
                            <th>الاستحقاق</th>
                            <th class="text-start">إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($project->tasks as $i=>$t)
                            <tr>
                                <td>{{ $i+1 }}</td>
                                <td><a href="{{ route('admin.tasks.show',$t->id) }}">{{ $t->title }}</a></td>
                                <td>{{ $t->status?->name }}</td>
                                <td>{{ ['low'=>'منخفض','medium'=>'متوسط','high'=>'مرتفع','urgent'=>'عاجل'][$t->priority] ?? $t->priority }}</td>
                                <td>{{ $t->due_at ?? '—' }}</td>
                                <td class="text-start">
                                    <div class="icon-actions">
                                        <a href="{{ route('admin.tasks.show',$t->id) }}" class="btn btn-sm btn-outline-info icon-btn" title="عرض"><i class="fas fa-eye"></i></a>
                                        <a href="{{ route('admin.tasks.edit',$t->id) }}" class="btn btn-sm btn-outline-primary icon-btn" title="تعديل"><i class="fas fa-pen"></i></a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center text-muted">لا توجد مهام.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js"></script>
<script>$(function(){$('.js-select2').select2({dir:'rtl',width:'100%',allowClear:true});});</script>
