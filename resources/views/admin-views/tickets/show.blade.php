@extends('layouts.layoutMaster')
@section('title', 'عرض تذكرة')

@section('content')
<div class="card mb-3">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0">تذكرة #{{ $ticket->id }} — {{ $ticket->title }}</h5>
    <div class="d-flex gap-2">
      <a class="btn btn-sm btn-warning" href="{{ route('admin.tickets.edit', $ticket->id) }}">تعديل</a>
      <form method="post" action="{{ route('admin.tickets.destroy', $ticket->id) }}" onsubmit="return confirm('حذف التذكرة؟');">
        @csrf @method('delete')
        <button class="btn btn-sm btn-danger">حذف</button>
      </form>
    </div>
  </div>
  <div class="card-body">
    <dl class="row mb-0">
      <dt class="col-sm-2">الكود</dt><dd class="col-sm-10">{{ $ticket->code ?? '-' }}</dd>
      <dt class="col-sm-2">الموافقة</dt>
      <dd class="col-sm-10">
        @php $s = $ticket->approved_status?->value ?? $ticket->approved_status; @endphp
        <span class="badge bg-{{ $s==='approved'?'success':($s==='rejected'?'danger':'warning') }}">
          {{ $s==='approved'?'موافق عليها':($s==='rejected'?'مرفوضة':'قيد الموافقة') }}
        </span>
        @if($ticket->approver) — بواسطة: {{ $ticket->approver->name ?? $ticket->approver->email }} @endif
        @if($ticket->approved_at) — {{ $ticket->approved_at->format('Y-m-d H:i') }} @endif
      </dd>

      <dt class="col-sm-2">الحل</dt>
      <dd class="col-sm-10">
        {!! $ticket->is_resolved ? '<span class="badge bg-success">محلولة</span>' : '<span class="badge bg-secondary">غير محلولة</span>' !!}
        @if($ticket->resolver) — بواسطة: {{ $ticket->resolver->name ?? $ticket->resolver->email }} @endif
        @if($ticket->resolved_at) — {{ $ticket->resolved_at->format('Y-m-d H:i') }} @endif
      </dd>

      <dt class="col-sm-2">المُعيَّن</dt>
      <dd class="col-sm-10">{{ $ticket->currentAssignee?->admin?->name ?? $ticket->currentAssignee?->admin?->email ?? '-' }}</dd>

      <dt class="col-sm-2">المنشئ</dt>
      <dd class="col-sm-10">{{ $ticket->creator?->name ?? $ticket->creator?->email ?? '-' }}</dd>

      <dt class="col-sm-2">الوصف</dt>
      <dd class="col-sm-10"><pre class="mb-0" style="white-space:pre-wrap">{{ $ticket->description }}</pre></dd>
    </dl>
  </div>
</div>

{{-- التعليقات --}}
<div id="comments" class="card">
  <div class="card-header">
    <h6 class="mb-0">التعليقات ({{ $ticket->comments->count() }})</h6>
  </div>
  <div class="card-body">
    @forelse($ticket->comments->sortBy('id') as $c)
      <div class="border rounded p-2 mb-2">
        <div class="d-flex justify-content-between">
          <strong>{{ $c->admin?->name ?? $c->admin?->email ?? 'مستخدم' }}</strong>
          <small class="text-muted">{{ $c->created_at?->format('Y-m-d H:i') }}</small>
        </div>
        <div class="mt-1">{{ $c->body }}</div>
        @if(auth('admin')->id() === $c->admin_id)
          <form method="post" class="mt-2" action="{{ route('admin.tickets.comments.destroy', [$ticket->id, $c->id]) }}" onsubmit="return confirm('حذف التعليق؟');">
            @csrf @method('delete')
            <button class="btn btn-sm btn-outline-danger">حذف</button>
          </form>
        @endif
      </div>
    @empty
      <p class="text-muted mb-0">لا توجد تعليقات بعد.</p>
    @endforelse

    <hr>
    <form method="post" action="{{ route('admin.tickets.comments.store', $ticket->id) }}">
      @csrf
      <label class="form-label">تعليق جديد</label>
      <textarea name="body" rows="3" class="form-control" required placeholder="اكتب تعليقك هنا..."></textarea>
      @error('body')<div class="text-danger small">{{ $message }}</div>@enderror
      <button class="btn btn-primary mt-2">إضافة تعليق</button>
    </form>
  </div>
</div>
@endsection
