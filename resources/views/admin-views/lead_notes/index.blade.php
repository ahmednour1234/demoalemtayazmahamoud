@extends('layouts.admin.app')
@section('title','ملاحظات الـLeads')
@section('content')
@php use Illuminate\Support\Str; @endphp
<div class="content container-fluid">

  <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <h3 class="mb-0 fw-bold">ملاحظات الـLeads</h3>
    <a href="{{ route('admin.lead-notes.create') }}" class="btn btn-primary">ملاحظة جديدة</a>
  </div>

  <div class="card mb-3">
    <form method="get" id="filters-form">
      <div class="card-body">
        <div class="row g-3 align-items-end">
          <div class="col-12 col-md-4">
            <label class="form-label">بحث</label>
            <input class="form-control" name="search" placeholder="نص الملاحظة / اسم / هاتف" value="{{ request('search') }}">
          </div>
          <div class="col-6 col-md-3">
            <label class="form-label">Lead</label>
            <select name="lead_id" class="form-select js-select2" data-placeholder="الكل">
              <option value=""></option>
              @foreach($leads as $ld)
                <option value="{{ $ld->id }}" @selected(request('lead_id')==$ld->id)>{{ $ld->contact_name ?: $ld->company_name }} — {{ $ld->phone }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-6 col-md-3">
            <label class="form-label">المسؤول</label>
            <select name="admin_id" class="form-select js-select2" data-placeholder="الكل">
              <option value=""></option>
              @foreach($admins as $ad)
                <option value="{{ $ad->id }}" @selected(request('admin_id')==$ad->id)>{{ $ad->email }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-6 col-md-2">
            <label class="form-label">الظهور</label>
            <select name="visibility" class="form-select js-select2" data-placeholder="الكل">
              <option value=""></option>
              <option value="private" @selected(request('visibility')==='private')>خاص</option>
              <option value="team"    @selected(request('visibility')==='team')>الفريق</option>
              <option value="public"  @selected(request('visibility')==='public')>عام</option>
            </select>
          </div>
          <div class="col-12 col-md-12 d-flex justify-content-end gap-2">
            <button class="btn btn-secondary"><i class="tio-filter-list"></i> فلترة</button>
            <a href="{{ route('admin.lead-notes.index') }}" class="btn btn-light">إعادة</a>
          </div>
        </div>
      </div>
    </form>
  </div>

  <div class="card">
    <div class="table-responsive">
      <table class="table table-hover table-nowrap align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th style="width:72px">#</th>
            <th>Lead</th>
            <th>النص</th>
            <th>المسؤول</th>
            <th>الظهور</th>
            <th>التاريخ</th>
            <th class="text-center" style="width:140px">إجراءات</th>
          </tr>
        </thead>
        <tbody>
          @forelse($notes as $n)
            <tr>
              <td class="text-muted">{{ $n->id }}</td>
              <td>
                @if($n->lead)
                  <div class="fw-semibold">{{ $n->lead->contact_name ?: $n->lead->company_name }}</div>
                  <div class="small text-muted">{{ $n->lead->country_code }} {{ $n->lead->phone }}</div>
                @else
                  <span class="text-muted">—</span>
                @endif
              </td>
              <td class="text-truncate" style="max-width:420px" title="{{ $n->note }}">{{ $n->note }}</td>
              <td>{{ optional($n->admin)->email ?: '—' }}</td>
              <td>
                @switch($n->visibility)
                  @case('public') <span >عام</span> @break
                  @case('team')   <span>الفريق</span>  @break
                  @default        <span>خاص</span>
                @endswitch
              </td>
              <td class="small text-muted">{{ $n->created_at?->format('Y-m-d H:i') }}</td>
              <td class="text-center">
                <div class="d-inline-flex align-items-center gap-1">
                  <a href="{{ route('admin.lead-notes.edit',$n) }}" class="icon-btn text-primary" title="تعديل"><i class="tio-edit"></i></a>
                  <form method="post" action="{{ route('admin.lead-notes.destroy',$n) }}" class="d-inline" onsubmit="return confirm('حذف الملاحظة؟');">
                    @csrf @method('DELETE')
                    <button class="icon-btn text-danger" type="submit" title="حذف"><i class="tio-delete-outlined"></i></button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr><td colspan="7" class="text-center text-muted py-4">لا توجد ملاحظات</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="card-footer d-flex justify-content-between align-items-center flex-wrap gap-2">
      <div class="small text-muted">عرض {{ $notes->firstItem() }}–{{ $notes->lastItem() }} من {{ $notes->total() }}</div>
      <div>{{ $notes->links() }}</div>
    </div>
  </div>
</div>

<style>
  .icon-btn{ width:36px; height:36px; display:inline-grid; place-items:center; border:0; background:transparent; border-radius:.6rem; color:#495057; }
  .icon-btn:hover{ background:#f1f3f5; color:#0d6efd; }
</style>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.full.min.js"></script>
<script>
  (function(){
    const $=window.jQuery;
    if($ && $.fn.select2){
      $('.js-select2').select2({dir:'rtl',width:'100%',theme:'bootstrap-5',allowClear:true,placeholder:function(){return $(this).data('placeholder')||'';}});
    }
  })();
</script>
@endsection
