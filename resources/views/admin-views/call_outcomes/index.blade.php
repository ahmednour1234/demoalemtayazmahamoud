{{-- resources/views/admin/calls/outcomes/index.blade.php --}}
@extends('layouts.admin.app')
@section('title','نتائج المكالمات')

@section('content')
@php
  $q      = request()->query();
  $tab    = $filters['active'] ?? '';
  $urlAll = route('admin.call-outcomes.index', collect($q)->except('active','page')->toArray());
  $urlAct = route('admin.call-outcomes.index', array_merge(collect($q)->except('page')->toArray(), ['active'=>'1']));
  $urlIna = route('admin.call-outcomes.index', array_merge(collect($q)->except('page')->toArray(), ['active'=>'0']));
@endphp

<div class="content container-fluid">

  {{-- Page heading + actions --}}
  <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <h3 class="mb-0">نتائج المكالمات</h3>
    <div class="d-flex flex-wrap gap-2">
      <a href="{{ route('admin.call-outcomes.export', request()->query()) }}"
         class="btn btn-outline-secondary btn-eq-sm">
        <i class="tio-file-outlined"></i> تصدير
      </a>
      <a href="{{ route('admin.call-outcomes.create') }}"
         class="btn btn-primary btn-eq-sm">
        <i class="tio-add"></i> جديد
      </a>
    </div>
  </div>

  {{-- Top NAV (filters) --}}
  <div class="card mb-3">
    <div class="card-body py-2">
      <ul class="nav nav-pills gap-2 flex-wrap">
        <li class="nav-item">
          <a class="nav-link {{ $tab==='' ? 'active' : '' }}" href="{{ $urlAll }}">
            الكل
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ $tab==='1' ? 'active' : '' }}" href="{{ $urlAct }}">
            النشِطة
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ $tab==='0' ? 'active' : '' }}" href="{{ $urlIna }}">
            المعطّلة
          </a>
        </li>
      </ul>
    </div>
  </div>

  {{-- Filters --}}
  <div class="card mb-3">
    <form method="GET">
      <div class="card-body">
        <div class="row g-3 align-items-end">
          <div class="col-12 col-md-5">
            <label class="form-label">بحث</label>
            <input type="text" name="search" value="{{ $filters['search'] ?? '' }}"
                   class="form-control" placeholder="اسم/كود">
          </div>
    
      </div>
      <div class="card-footer d-flex justify-content-end flex-wrap gap-2">
        <button class="btn btn-secondary btn-eq-sm">
          <i class="tio-filter-list"></i> فلترة
        </button>
        <a href="{{ route('admin.call-outcomes.index') }}" class="btn btn-light btn-eq-sm">
          <i class="tio-rotate"></i> إعادة
        </a>
      </div>
    </form>
  </div>

  {{-- Table --}}
  <div class="card">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th style="width:72px">#</th>
            <th>الاسم</th>
            <th>الكود</th>
            <th>الترتيب</th>
            <th>التفعيل</th>
            <th class="text-center" style="width:160px">إجراءات</th>
          </tr>
        </thead>
        <tbody>
          @forelse($outcomes as $o)
            <tr>
              <td class="text-muted">{{ $o->id }}</td>
              <td class="fw-semibold">{{ $o->name }}</td>
              <td><code>{{ $o->code }}</code></td>
              <td>{{ $o->sort_order }}</td>
              <td>
                <form method="post" action="{{ route('admin.call-outcomes.active',$o) }}"
                      class="m-0 p-0 d-inline">
                  @csrf @method('PATCH')
                  <input type="hidden" name="active" value="{{ $o->is_active ? 0 : 1 }}">
                  <button type="submit"
                          class="btn {{ $o->is_active ? 'btn-success' : 'btn-outline-secondary' }}">
                    {{ $o->is_active ? 'مفعّل' : 'معطّل' }}
                  </button>
                </form>
              </td>
              <td class="text-center">
                <div class="d-inline-flex align-items-start gap-2">
                  <a href="{{ route('admin.call-outcomes.edit',$o) }}"
                     class="btn btn-outline-primary btn-eq-sm" title="تعديل">
                    <i class="tio-edit"></i> 
                  </a>
                  <form method="post" action="{{ route('admin.call-outcomes.destroy',$o) }}"
                        onsubmit="return confirm('حذف؟');" class="d-inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-outline-danger btn-eq-sm" title="حذف">
                      <i class="tio-delete-outlined"></i> 
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr><td colspan="6" class="text-center text-muted py-4">لا توجد بيانات</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="card-footer d-flex justify-content-between align-items-center flex-wrap gap-2">
      <div class="small text-muted">عرض {{ $outcomes->firstItem() }}–{{ $outcomes->lastItem() }} من {{ $outcomes->total() }}</div>
      <div>{{ $outcomes->links() }}</div>
    </div>
  </div>

</div>
@endsection

  {{-- Equal buttons + spacing + select2 RTL --}}

  {{-- Select2 CSS (CDN) --}}
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">

  {{-- jQuery (لو غير محمّل من اللAYOUT، يمكن حذف السطرين التاليين إن كان موجوداً بالفعل) --}}
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  {{-- Select2 JS --}}
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script>
    (function(){
      const $ = window.jQuery;
      if(!$) return console.warn('Select2 يحتاج jQuery.');

      $('.js-select2').each(function(){
        const $el = $(this);
        $el.select2({
          width: '100%',
          dir: 'rtl',
          placeholder: $el.data('placeholder') || '',
          allowClear: true,
          language: {
            noResults: function(){ return 'لا توجد نتائج'; }
          }
        });
      });
    })();
  </script>
