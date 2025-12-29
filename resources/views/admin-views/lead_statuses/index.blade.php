{{-- resources/views/admin/lead_statuses/index.blade.php --}}
@extends('layouts.admin.app')

@section('title','حالات العملاء المحتملين')

@section('content')
<div class="content container-fluid">

  {{-- Breadcrumb --}}
  <div class="mb-3">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb bg-white px-3 py-2 rounded shadow-sm">
        <li class="breadcrumb-item">
          <a href="{{ route('admin.dashboard') }}" class="text-secondary">
            <i class="tio-home-outlined"></i> {{ \App\CPU\translate('الرئيسية') }}
          </a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
          {{ \App\CPU\translate('حالات العملاء المحتملين') }}
        </li>
      </ol>
    </nav>
  </div>

  {{-- Actions --}}
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">{{ \App\CPU\translate('حالات العملاء المحتملين') }}</h3>
    <a href="{{ route('admin.lead-statuses.create') }}" class="btn btn-primary">
      <i class="tio-add"></i> {{ \App\CPU\translate('إضافة حالة') }}
    </a>
  </div>

  {{-- Filters --}}
  <form class="row g-2 mb-3" method="GET">
    <div class="col-md-4">
      <input type="text"
             name="search"
             value="{{ $filters['search'] ?? '' }}"
             class="form-control"
             placeholder="{{ \App\CPU\translate('بحث بالاسم/الكود') }}">
    </div>
    <div class="col-md-2">
      <button type="submit" class="btn btn-secondary w-100">
        <i class="tio-filter-list"></i> {{ \App\CPU\translate('فلترة') }}
      </button>
    </div>
  </form>

  {{-- Table --}}
  <div class="card">
    <div class="table-responsive">
      <table class="table table-nowrap align-middle mb-0">
        <thead>
          <tr>
            <th style="width:80px">#</th>
            <th>{{ \App\CPU\translate('الاسم') }}</th>
            <th>{{ \App\CPU\translate('الكود') }}</th>
            <th style="width:140px">{{ \App\CPU\translate('الترتيب') }}</th>
            <th style="width:140px">{{ \App\CPU\translate('التفعيل') }}</th>
            <th style="width:120px" class="text-center">{{ \App\CPU\translate('إجراءات') }}</th>
          </tr>
        </thead>
        <tbody>
        @forelse($statuses as $s)
          <tr>
            <td>{{ $s->id }}</td>
            <td class="fw-semibold">{{ $s->name }}</td>
            <td><code>{{ $s->code }}</code></td>
            <td>{{ $s->sort_order }}</td>

            {{-- Button Switch Toggle (بدون checkbox) --}}
            <td>
              <form method="post"
                    action="{{ route('admin.lead-statuses.active', $s) }}"
                    class="m-0 p-0 js-toggle-form">
                @csrf @method('PATCH')
                <input type="hidden" name="active" value="{{ $s->is_active ? 0 : 1 }}">
                <button type="button"
                        class="btn btn-sm {{ $s->is_active ? 'btn-success' : 'btn-outline-secondary' }} js-toggle-btn"
                        data-next="{{ $s->is_active ? 0 : 1 }}"
                        title="{{ $s->is_active ? \App\CPU\translate('تعطيل') : \App\CPU\translate('تفعيل') }}">
                  {{ $s->is_active ? \App\CPU\translate('مفعّل') : \App\CPU\translate('معطّل') }}
                </button>
              </form>
            </td>

            {{-- Actions (Outline + Icons only) --}}
            <td class="text-center">
              <div class="d-inline-flex align-items-start">
                <a href="{{ route('admin.lead-statuses.edit', $s) }}"
                   class="btn btn-sm btn-outline-primary me-2"
                   title="{{ \App\CPU\translate('تعديل') }}">
                  <i class="tio-edit"></i>
                </a>

                <form method="post"
                      action="{{ route('admin.lead-statuses.destroy', $s) }}"
                      onsubmit="return confirm('{{ \App\CPU\translate('حذف الحالة؟') }}');"
                      class="d-inline">
                  @csrf @method('DELETE')
                  <button type="submit"
                          class="btn btn-sm btn-outline-danger"
                          title="{{ \App\CPU\translate('حذف') }}">
                    <i class="tio-delete-outlined"></i>
                  </button>
                </form>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="6" class="text-center text-muted py-4">
              {{ \App\CPU\translate('لا توجد بيانات') }}
            </td>
          </tr>
        @endforelse
        </tbody>
      </table>
    </div>

    <div class="card-footer">
      {{ $statuses->appends(request()->query())->links() }}
    </div>
  </div>
</div>
@endsection

<script>
  // تبديل حالة التفعيل بزر واحد (بدون checkbox)
  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.js-toggle-btn').forEach(function (btn) {
      btn.addEventListener('click', function () {
        var form = btn.closest('form');
        if (!form) return;
        var hidden = form.querySelector('input[name="active"]');
        if (hidden) hidden.value = btn.getAttribute('data-next');
        form.submit();
      });
    });
  });
</script>
