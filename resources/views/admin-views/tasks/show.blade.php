@extends('layouts.admin.app')
@section('title','تفاصيل مهمة')

@push('css_or_js')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
<style>
    .kv{display:grid;grid-template-columns:160px 1fr;gap:8px 16px}
    .kv .k{color:#6c757d}
    .badge.round{border-radius:10px;padding:.35rem .55rem}
    .icon-actions{display:inline-flex;gap:8px}
    .icon-btn{width:36px;height:36px;display:inline-flex;align-items:center;justify-content:center;border-radius:8px;padding:0!important}
    .icon-btn i{font-size:14px;line-height:1}
    .section-title{font-weight:700;font-size:1.05rem}
</style>
@endpush

@section('content')
<div class="content container-fluid">

    {{-- تأكيد تحميل العلاقات المطلوبة حتى لو Lazy Loading مقفول --}}
    @php
        /** @var \App\Models\Task $task */
        $task->loadMissing([
            'project:id,name',
            'status:id,name',
            'creator:id,f_name,l_name',
            'assignees.admin:id,f_name,l_name',
            'followUps' => fn($q) => $q->orderByDesc('next_follow_up_at'),
            'comments.admin:id,f_name,l_name',
        ]);
        $prioMap=['low'=>'منخفض','medium'=>'متوسط','high'=>'مرتفع','urgent'=>'عاجل'];
    @endphp

    {{-- Breadcrumb --}}
    <div class="mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white px-3 py-2 rounded shadow-sm">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}" class="text-secondary">
                        <i class="tio-home-outlined"></i> الرئيسية
                    </a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('admin.tasks.index') }}" class="text-primary">المهام</a></li>
                <li class="breadcrumb-item active" aria-current="page">تفاصيل مهمة</li>
            </ol>
        </nav>
    </div>

    <div class="card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h5 class="mb-0">{{ $task->title }}</h5>
            <div class="icon-actions">
                <a href="{{ route('admin.tasks.edit',$task->id) }}" class="btn btn-sm btn-outline-primary icon-btn" title="تعديل">
                    <i class="fas fa-pen"></i>
                </a>
                <form action="{{ route('admin.tasks.destroy',$task->id) }}" method="POST" onsubmit="return confirm('حذف هذه المهمة؟')" style="display:inline-block">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger icon-btn" title="حذف"><i class="fas fa-trash"></i></button>
                </form>
            </div>
        </div>

        <div class="card-body">
            <div class="row g-4">
                {{-- معلومات عامة --}}
                <div class="col-lg-7">
                    <div class="kv">
                        <div class="k">العنوان:</div> <div class="v">{{ $task->title }}</div>

                        <div class="k">المشروع:</div>
                        <div class="v">
                            @if($task->project)
                                <a href="{{ route('admin.projects.show',$task->project_id) }}">{{ $task->project->name }}</a>
                            @else
                                —
                            @endif
                        </div>

                        <div class="k">الحالة:</div> <div class="v">{{ $task->status?->name ?? '—' }}</div>

                        <div class="k">الأولوية:</div>
                        <div class="v">
                            <span class="badge round bg-light text-dark">{{ $prioMap[$task->priority] ?? $task->priority }}</span>
                        </div>

                        <div class="k">المنشئ:</div> <div class="v">{{ $task->creator?->f_name }} {{ $task->creator?->l_name }}</div>

                        <div class="k">يبدأ في:</div>
                        <div class="v">{{ $task->start_at ? \Carbon\Carbon::parse($task->start_at)->format('Y-m-d H:i') : '—' }}</div>

                        <div class="k">الاستحقاق:</div>
                        <div class="v">
                            {{ $task->due_at ? \Carbon\Carbon::parse($task->due_at)->format('Y-m-d H:i') : '—' }}
                            @if($task->due_at && \Carbon\Carbon::parse($task->due_at)->isPast() && $task->approval_status !== 'approved')
                                <span class="badge bg-danger ms-1">متأخرة</span>
                            @endif
                        </div>

                        <div class="k">موافقة مطلوبة؟</div>
                        <div class="v">
                            @if($task->approval_required)
                                <span class="badge {{ $task->approval_status=='approved'?'bg-success':($task->approval_status=='rejected'?'bg-danger':'bg-warning text-dark') }}">
                                    {{ ['pending'=>'قيد المراجعة','approved'=>'موافق عليه','rejected'=>'مرفوض'][$task->approval_status] ?? $task->approval_status }}
                                </span>
                            @else
                                <span class="badge bg-secondary">لا</span>
                            @endif
                        </div>
                    </div>

                    @if($task->description)
                        <hr>
                        <div>
                            <div class="section-title mb-2">الوصف</div>
                            <p class="mb-0">{{ $task->description }}</p>
                        </div>
                    @endif
                </div>

                {{-- اعتماد + إسناد --}}
                <div class="col-lg-5">

                    {{-- الاعتماد --}}
                    @if($task->approval_required)
                        <div class="card border mb-3">
                            <div class="card-header py-2"><strong>الاعتماد</strong></div>
                            <div class="card-body">
                                @if($task->approval_status === 'pending')
                                    <form action="{{ route('admin.tasks.approve',$task->id) }}" method="POST" class="d-inline-block me-2">
                                        @csrf
                                        <button class="btn btn-success btn-sm">موافقة</button>
                                    </form>
                                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#rejectModal">رفض</button>
                                @elseif($task->approval_status === 'approved')
                                    <div class="alert alert-success mb-0">تم اعتماد المهمة. ✅</div>
                                @elseif($task->approval_status === 'rejected')
                                    <div class="alert alert-danger">
                                        <div class="fw-bold mb-1">المهمة مرفوضة</div>
                                        <div><strong>السبب:</strong> {{ $task->rejection_reason ?: '—' }}</div>
                                        <div><strong>الخطوة التالية:</strong> {{ $task->next_step_hint ?: '—' }}</div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Modal رفض --}}
                        <div class="modal fade" id="rejectModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('admin.tasks.reject',$task->id) }}" method="POST">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title">رفض المهمة</h5>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>سبب الرفض</label>
                                                <input type="text" name="rejection_reason" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label>الخطوة التالية المقترحة</label>
                                                <input type="text" name="next_step_hint" class="form-control">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-danger">تأكيد الرفض</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- المسند إليهم --}}
                    <div class="card border">
                        <div class="card-header py-2 d-flex justify-content-between align-items-center">
                            <strong>المُسنَد إليهم</strong>
                            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#assignModal">إسناد</button>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-sm mb-0">
                                    <thead>
                                        <tr>
                                            <th>الموظف</th>
                                            <th>الدور</th>
                                            <th>الأولوية</th>
                                            <th class="text-start">إزالة</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($task->assignees as $a)
                                            <tr>
                                                <td>{{ $a->admin?->f_name }} {{ $a->admin?->l_name }}</td>
                                                <td>{{ ['assignee'=>'منفذ','reviewer'=>'مراجع','watcher'=>'متابع'][$a->role] ?? $a->role }}</td>
                                                <td>{{ $prioMap[$a->priority] ?? $a->priority }}</td>
                                                <td class="text-start">
                                                    <form action="{{ route('admin.tasks.assignees.destroy',[$task->id,$a->id]) }}" method="POST" onsubmit="return confirm('إزالة هذا الإسناد؟')" style="display:inline-block">
                                                        @csrf @method('DELETE')
                                                        <button class="btn btn-sm btn-outline-danger icon-btn" title="حذف"><i class="fas fa-user-minus"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="4" class="text-center text-muted">لا يوجد إسناد.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- Modal إسناد --}}
                    <div class="modal fade" id="assignModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('admin.tasks.assignees.store',$task->id) }}" method="POST">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title">إسناد مهمة</h5>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>الموظف</label>
                                            <select name="admin_id" class="form-control js-select2" data-placeholder="— اختر —" required>
                                                <option value="">—</option>
                                                @foreach(\App\Models\Admin::select('id','f_name','l_name')->orderBy('f_name')->get() as $u)
                                                    <option value="{{ $u->id }}">{{ $u->f_name }} {{ $u->l_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>الدور</label>
                                            <select name="role" class="form-control js-select2">
                                                <option value="assignee">منفذ</option>
                                                <option value="reviewer">مراجع</option>
                                                <option value="watcher">متابع</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>الأولوية</label>
                                            <select name="priority" class="form-control js-select2">
                                                <option value="low">منخفض</option>
                                                <option value="medium" selected>متوسط</option>
                                                <option value="high">مرتفع</option>
                                                <option value="urgent">عاجل</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>تاريخ الاستحقاق (اختياري)</label>
                                            <input type="datetime-local" name="due_at" class="form-control">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-primary">إسناد</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>{{-- /col --}}
            </div>
        </div>
    </div>

    {{-- المتابعة (Follow-up) --}}
    <div class="card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="mb-0">المتابعة (Follow-up)</h6>
            <span class="text-muted small">يُرسل تنبيه للليدر والسوبر أدمن عند التأخير</span>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.tasks.followups.store',$task->id) }}" method="POST" class="row g-2 align-items-end mb-3">
                @csrf
                <div class="col-md-3">
                    <label class="form-label mb-1">تاريخ المتابعة</label>
                    <input type="datetime-local" name="next_follow_up_at" class="form-control" required>
                </div>
                <div class="col-md-7">
                    <label class="form-label mb-1">ملاحظة</label>
                    <input type="text" name="comment" class="form-control" placeholder="ماذا ستتابع؟">
                </div>
                <div class="col-md-2 d-flex justify-content-end">
                    <button class="btn btn-primary w-100">إضافة</button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>الموعد</th>
                            <th>الملاحظة</th>
                            <th>الحالة</th>
                            <th class="text-start">إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php use Carbon\Carbon; @endphp
                        @forelse(($task->followUps ?? []) as $i=>$f)
                            @php
                                $isLate = ($f->status === 'scheduled') && $f->next_follow_up_at && Carbon::parse($f->next_follow_up_at)->isPast();
                            @endphp
                            <tr>
                                <td>{{ $i+1 }}</td>
                                <td>{{ $f->next_follow_up_at ? Carbon::parse($f->next_follow_up_at)->format('Y-m-d H:i') : '—' }}</td>
                                <td>{{ $f->comment ?: '—' }}</td>
                                <td>
                                    @switch($f->status)
                                        @case('scheduled')
                                            <span class="badge {{ $isLate ? 'bg-warning text-dark' : 'bg-info' }}">{{ $isLate ? 'متأخر' : 'مجدولة' }}</span>
                                            @break
                                        @case('done')
                                            <span class="badge bg-success">تمّت</span>
                                            @break
                                        @case('skipped')
                                            <span class="badge bg-secondary">تخطّي</span>
                                            @break
                                        @case('lost')
                                            <span class="badge bg-danger">ضاعت</span>
                                            @break
                                        @default
                                            <span class="badge bg-light text-dark">{{ $f->status }}</span>
                                    @endswitch
                                </td>
                                <td class="text-start">
                                    <div class="icon-actions">
                                        @if($f->status !== 'done')
                                            <form action="{{ route('admin.tasks.followups.done',[$task->id,$f->id]) }}" method="POST" style="display:inline-block">
                                                @csrf
                                                <button class="btn btn-sm btn-outline-success icon-btn" title="تم"><i class="fas fa-check"></i></button>
                                            </form>
                                        @endif
                                        <form action="{{ route('admin.tasks.followups.destroy',[$task->id,$f->id]) }}" method="POST" onsubmit="return confirm('حذف المتابعة؟')" style="display:inline-block">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger icon-btn" title="حذف"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-muted">لا توجد متابعات.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- التعليقات --}}
    <div class="card">
        <div class="card-header"><h6 class="mb-0">التعليقات</h6></div>
        <div class="card-body">
            <form action="{{ route('admin.tasks.comments.store',$task->id) }}" method="POST" class="row g-2 align-items-end mb-3">
                @csrf
                <div class="col-md-10">
                    <label class="form-label mb-1">تعليق</label>
                    <input type="text" name="body" class="form-control" placeholder="أكتب تعليقًا..." required>
                </div>
                <div class="col-md-2 d-flex justify-content-end">
                    <button class="btn btn-primary w-100">إرسال</button>
                </div>
            </form>

            <ul class="list-group">
                @forelse(($task->comments ?? []) as $c)
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">{{ $c->author?->f_name }} {{ $c->author?->l_name }}</div>
                            {{ $c->body }}
                            <div class="text-muted small">{{ optional($c->created_at)->format('Y-m-d H:i') }}</div>
                        </div>
                        <form action="{{ route('admin.tasks.comments.destroy',[$task->id,$c->id]) }}" method="POST" onsubmit="return confirm('حذف التعليق؟')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger icon-btn" title="حذف"><i class="fas fa-trash"></i></button>
                        </form>
                    </li>
                @empty
                    <li class="list-group-item text-center text-muted">لا توجد تعليقات.</li>
                @endforelse
            </ul>
        </div>
    </div>

</div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js"></script>
<script>
$(function(){
    $('.js-select2').select2({dir:'rtl',width:'100%',allowClear:true});
});
</script>
