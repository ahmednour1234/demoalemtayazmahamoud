@extends('layouts.layoutMaster')

@section('title', 'التذاكر')

@section('content')
<div class="card">
  <div class="card-header">
    <h5 class="mb-0">التذاكر</h5>
  </div>

  <div class="card-body">
    {{-- فلاتر --}}
    <form method="get" action="{{ route('admin.tickets.index') }}" class="row g-2 mb-3">
      <div class="col-md-3">
        <input type="text" name="q" value="{{ $filters['q'] ?? '' }}" class="form-control" placeholder="بحث بالعنوان/الكود/الوصف">
      </div>

      <div class="col-md-2">
        <select name="approved_status" class="form-select">
          <option value="">حالة الموافقة</option>
          @foreach(['pending'=>'قيد الموافقة','approved'=>'موافق عليها','rejected'=>'مرفوضة'] as $k=>$lbl)
            <option value="{{ $k }}" @selected(($filters['approved_status'] ?? '')===$k)>{{ $lbl }}</option>
          @endforeach
        </select>
      </div>

      <div class="col-md-2">
        <select name="is_resolved" class="form-select">
          <option value="">الحل</option>
          <option value="1" @selected(($filters['is_resolved'] ?? '')==='1')>محلولة</option>
          <option value="0" @selected(($filters['is_resolved'] ?? '')==='0')>غير محلولة</option>
        </select>
      </div>

      <div class="col-md-2">
        <select name="assigned_admin_id" class="form-select">
          <option value="">المُعيَّن الحالي</option>
          @foreach($admins as $a)
            <option value="{{ $a->id }}" @selected(($filters['assigned_admin_id'] ?? '')==$a->id)>{{ $a->name ?? $a->email }}</option>
          @endforeach
        </select>
      </div>

      <div class="col-md-2">
        <select name="created_by" class="form-select">
          <option value="">منشئ التذكرة</option>
          @foreach($admins as $a)
            <option value="{{ $a->id }}" @selected(($filters['created_by'] ?? '')==$a->id)>{{ $a->name ?? $a->email }}</option>
          @endforeach
        </select>
      </div>

      <div class="col-md-2">
        <input type="date" name="date_from" class="form-control" value="{{ $filters['date_from'] ?? '' }}" placeholder="من">
      </div>
      <div class="col-md-2">
        <input type="date" name="date_to" class="form-control" value="{{ $filters['date_to'] ?? '' }}" placeholder="إلى">
      </div>

      <div class="col-md-2">
        <button class="btn btn-primary w-100">تصفية</button>
      </div>
      <div class="col-md-2">
        <a href="{{ route('admin.tickets.index') }}" class="btn btn-light w-100">تفريغ</a>
      </div>
      <div class="col-md-2 ms-auto">
        <a href="{{ route('admin.tickets.create') }}" class="btn btn-success w-100">+ تذكرة جديدة</a>
      </div>
    </form>

    {{-- جدول --}}
    <div class="table-responsive">
      <table class="table table-striped align-middle">
        <thead>
          <tr>
            <th>#</th>
            <th>الكود</th>
            <th>العنوان</th>
            <th>الموافقة</th>
            <th>الحل</th>
            <th>المُعيَّن</th>
            <th>المنشئ</th>
            <th>تاريخ الإنشاء</th>
            <th>إجراءات</th>
          </tr>
        </thead>
        <tbody>
          @forelse($tickets as $t)
            <tr>
              <td>{{ $t->id }}</td>
              <td>{{ $t->code ?? '-' }}</td>
              <td><a href="{{ route('admin.tickets.show', $t->id) }}">{{ $t->title }}</a></td>
              <td>
                @php $s = $t->approved_status?->value ?? $t->approved_status; @endphp
                <span class="badge bg-{{ $s==='approved'?'success':($s==='rejected'?'danger':'warning') }}">
                  {{ $s==='approved'?'موافق عليها':($s==='rejected'?'مرفوضة':'قيد الموافقة') }}
                </span>
              </td>
              <td>
                {!! $t->is_resolved ? '<span class="badge bg-success">محلولة</span>' : '<span class="badge bg-secondary">غير محلولة</span>' !!}
              </td>
              <td>{{ $t->currentAssignee?->admin?->name ?? $t->currentAssignee?->admin?->email ?? '-' }}</td>
              <td>{{ $t->creator?->name ?? $t->creator?->email ?? '-' }}</td>
              <td>{{ $t->created_at?->format('Y-m-d H:i') }}</td>
              <td class="d-flex gap-1">
                <a class="btn btn-sm btn-primary" href="{{ route('admin.tickets.show', $t->id) }}">عرض</a>
                <a class="btn btn-sm btn-warning" href="{{ route('admin.tickets.edit', $t->id) }}">تعديل</a>
                <form method="post" action="{{ route('admin.tickets.destroy', $t->id) }}" onsubmit="return confirm('حذف التذكرة؟');">
                  @csrf @method('delete')
                  <button class="btn btn-sm btn-danger">حذف</button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="9" class="text-center">لا توجد نتائج.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>

    {{ $tickets->links() }}
  </div>
</div>
@endsection
