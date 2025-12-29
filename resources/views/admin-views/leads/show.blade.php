{{-- resources/views/admin/leads/show.blade.php --}}
@extends('layouts.admin.app')
@section('title','تفاصيل العميل المحتمل')

@section('content')
@php
  /** @var \App\Models\Lead $lead */
  // نضمن تحميل العلاقات
  $lead->loadMissing([
    'status','source','owner',
    'callLogs.outcome','callLogs.admin',
    'notes.admin',
    'customFieldValues.customField',
  ]);

  $next = $lead->next_action_at; // Carbon|null
  $nextClass = '';
  $nextLabel = $next ? $next->format('Y-m-d H:i') : null;
  if ($next) {
    if (now()->gt($next))      { $nextClass = 'badge-overdue'; }
    elseif ($next->isToday())  { $nextClass = 'badge-today'; }
    else                       { $nextClass = 'badge-upcoming'; }
  }

  // Phone/WhatsApp
  $tel_cc = trim($lead->country_code ?? '');
  $tel_ph = trim($lead->phone ?? '');
  $tel_uri = $tel_ph ? $tel_cc.$tel_ph : null;

  $wa_cc  = preg_replace('/\D+/','', $lead->country_code ?? '');
  $wa_ph  = preg_replace('/\D+/','', $lead->whatsapp ?? $lead->phone ?? '');
  $wa_num = $wa_cc.$wa_ph;
  $wa_url = $wa_num ? ('https://wa.me/'.$wa_num) : null;

  // الحقول المخصّصة: تجميع بالمجموعة
  $cfGroups = [];
  foreach ($lead->customFieldValues as $val) {
    $field = $val->customField;
    if (!$field || !$field->is_active) continue;

    $group = $field->group ?: 'بدون مجموعة';
    $type  = strtolower($field->type);

    // options->choices
    $choicesById = [];
    $opts = $field->options;
    if (is_string($opts)) { $tmp = json_decode($opts, true); if (json_last_error()===JSON_ERROR_NONE) $opts = $tmp; }
    if (is_array($opts) && isset($opts['choices']) && is_array($opts['choices'])) {
      foreach ($opts['choices'] as $c) {
        if (isset($c['id'])) $choicesById[(string)$c['id']] = $c['name'] ?? (string)$c['id'];
      }
    }

    // عرض القيمة
    $display = '—';
    if (!is_null($val->value_json)) {
      if ($type === 'multiselect') {
        $arr = is_array($val->value_json) ? $val->value_json : [];
        $labels = array_map(fn($x)=>$choicesById[(string)$x] ?? (is_scalar($x)?(string)$x:json_encode($x,JSON_UNESCAPED_UNICODE)) , $arr);
        $display = count($labels) ? implode('، ', $labels) : '—';
      } elseif ($type === 'json') {
        $display = json_encode($val->value_json, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
      } else {
        $display = is_scalar($val->value_json) ? (string)$val->value_json : json_encode($val->value_json, JSON_UNESCAPED_UNICODE);
      }
    } else {
      $v = $val->value;
      if ($v === null || $v === '') {
        $display = '—';
      } else {
        switch ($type) {
          case 'boolean': $display = in_array((string)$v, ['1','true','on','yes'], true) ? 'نعم' : 'لا'; break;
          case 'select':  $display = $choicesById[(string)$v] ?? (string)$v; break;
          default:        $display = (string)$v; break;
        }
      }
    }

    $cfGroups[$group][] = [
      'label'   => $field->name,
      'key'     => $field->key,
      'type'    => $type,
      'display' => $display,
      'order'   => (int)($field->sort_order ?? 0),
    ];
  }
  foreach ($cfGroups as $g => $items) {
    usort($items, fn($a,$b)=> $a['order'] === $b['order'] ? strcmp($a['label'],$b['label']) : ($a['order'] <=> $b['order']));
    $cfGroups[$g] = $items;
  }

  // تأمين $logs لو مش متبعت
  $logs = $logs ?? collect();
@endphp

<div class="content container-fluid">

  {{-- Breadcrumb --}}
  <nav class="mb-3" aria-label="breadcrumb">
    <ol class="breadcrumb bg-white px-3 py-2 rounded shadow-sm">
      <li class="breadcrumb-item">
        <a href="{{ route('admin.dashboard') }}" class="text-secondary">
          <i class="tio-home-outlined"></i> {{ \App\CPU\translate('الرئيسية') }}
        </a>
      </li>
      <li class="breadcrumb-item">
        <a href="{{ route('admin.leads.index') }}" class="text-secondary">
          {{ \App\CPU\translate('العملاء المحتملون') }}
        </a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">
        {{ \App\CPU\translate('تفاصيل العميل المحتمل') }}
      </li>
    </ol>
  </nav>

  {{-- Header --}}
  <div class="card crm-card mb-3">
    <div class="card-body d-flex flex-wrap align-items-center justify-content-between gap-3">
      <div class="d-flex align-items-center gap-3">
        <div>
          <h3 class="mb-1 d-flex align-items-center gap-2">
            Lead #{{ $lead->id }}
            <span class="text-muted">—</span>
            <span>{{ $lead->contact_name ?: '—' }}</span>
            @if($lead->is_archived)
              <span class="badge badge-archived ms-2">مؤرشف</span>
            @endif
          </h3>
          <div class="small text-muted d-flex flex-wrap gap-2 align-items-center">
            <span><i class="tio-briefcase"></i> {{ $lead->company_name ?: '—' }}</span>
            <span class="dot-sep">•</span>
            <span>
              <i class="tio-bookmark-outlined"></i>
              الحالة:
              @if($lead->status)
                <span class="badge badge-soft-info align-middle">{{ $lead->status->name }}</span>
              @else
                <span class="text-muted">—</span>
              @endif
            </span>
            <span class="dot-sep">•</span>
            <span><i class="tio-share"></i> المصدر: {{ optional($lead->source)->name ?: '—' }}</span>
            @if($next)
              <span class="dot-sep">•</span>
              <span><i class="tio-time-20-s"></i> التالي: <span class="badge {{ $nextClass }}">{{ $nextLabel }}</span></span>
            @endif
          </div>
        </div>
      </div>

      {{-- Actions --}}
      <div class="btn-toolbar flex-wrap gap-2" role="toolbar" aria-label="Actions">
        <a href="{{ route('admin.leads.edit',$lead) }}" class="btn btn-outline-primary btn-eq" data-bs-toggle="tooltip" title="تعديل">
          <i class="tio-edit"></i><span class="d-none d-sm-inline ms-1">تعديل</span>
        </a>

        <a href="{{ route('admin.leads.report.pdf',$lead) }}" class="btn btn-outline-dark btn-eq" target="_blank" title="تقرير PDF">
          <i class="tio-file"></i><span class="d-none d-sm-inline ms-1">تقرير PDF</span>
        </a>

        <form method="post" action="{{ route('admin.leads.archive',$lead) }}" class="d-inline">
          @csrf @method('PATCH')
          <input type="hidden" name="archived" value="{{ $lead->is_archived ? 0 : 1 }}">
          <button type="submit"
                  class="btn btn-eq {{ $lead->is_archived ? 'btn-success' : 'btn-outline-secondary' }}"
                  data-bs-toggle="tooltip"
                  title="{{ $lead->is_archived ? 'إلغاء الأرشفة' : 'أرشفة' }}">
            <i class="tio-archive"></i><span class="d-none d-sm-inline ms-1">{{ $lead->is_archived ? 'مؤرشف' : 'أرشفة' }}</span>
          </button>
        </form>

        <form method="post" action="{{ route('admin.leads.destroy',$lead) }}"
              onsubmit="return confirm('هل أنت متأكد من حذف هذا العميل؟');" class="d-inline">
          @csrf @method('DELETE')
          <button class="btn btn-outline-danger btn-eq" data-bs-toggle="tooltip" title="حذف">
            <i class="tio-delete-outlined"></i><span class="d-none d-sm-inline ms-1">حذف</span>
          </button>
        </form>
      </div>
    </div>
  </div>

  {{-- Main --}}
  <div class="row g-3">
    {{-- Left --}}
    <div class="col-lg-8">
      {{-- Basic Info --}}
      <div class="card crm-card">
        <div class="card-header py-2 d-flex align-items-center gap-2">
          <i class="tio-user"></i><strong>البيانات الأساسية</strong>
        </div>
        <div class="card-body">
          <dl class="row mb-0 deflist deflist-2col">
            <dt class="col-sm-3">الشركة</dt>
            <dd class="col-sm-9">{{ $lead->company_name ?: '—' }}</dd>

            <dt class="col-sm-3">الاسم</dt>
            <dd class="col-sm-9">{{ $lead->contact_name ?: '—' }}</dd>

            <dt class="col-sm-3">الهاتف</dt>
            <dd class="col-sm-9" dir="ltr">
              @if($tel_uri)
                <a href="tel:{{ $tel_uri }}" class="me-2">{{ $tel_cc }} {{ $tel_ph }}</a>
                <button type="button" class="btn btn-xs btn-light copy-btn" data-copy="{{ $tel_uri }}" data-bs-toggle="tooltip" title="نسخ الرقم">
                  <i class="tio-copy"></i>
                </button>
              @else
                <span class="text-muted">—</span>
              @endif
            </dd>

            <dt class="col-sm-3">الإيميل</dt>
            <dd class="col-sm-9" dir="ltr">
              @if($lead->email)
                <a href="mailto:{{ $lead->email }}" class="me-2">{{ $lead->email }}</a>
                <button type="button" class="btn btn-xs btn-light copy-btn" data-copy="{{ $lead->email }}" data-bs-toggle="tooltip" title="نسخ الإيميل">
                  <i class="tio-copy"></i>
                </button>
              @else
                <span class="text-muted">—</span>
              @endif
            </dd>

            <dt class="col-sm-3">الحالة</dt>
            <dd class="col-sm-9">
              @if($lead->status)
                <span class="badge badge-soft-info">{{ $lead->status->name }}</span>
              @else
                <span class="text-muted">—</span>
              @endif
            </dd>

            <dt class="col-sm-3">المصدر</dt>
            <dd class="col-sm-9">{{ optional($lead->source)->name ?: '—' }}</dd>

            <dt class="col-sm-3">المسؤول</dt>
            <dd class="col-sm-9">{{ optional($lead->owner)->name ?: optional($lead->owner)->email ?: '—' }}</dd>

            <dt class="col-sm-3">ملاحظات</dt>
            <dd class="col-sm-9 text-body">{{ $lead->pipeline_notes ?: '—' }}</dd>
          </dl>
        </div>
      </div>

      {{-- Custom Fields --}}
      <div class="card crm-card mt-3">
        <div class="card-header py-2 d-flex align-items-center gap-2">
          <i class="tio-grid"></i><strong>الحقول المخصّصة</strong>
        </div>
        <div class="card-body">
          @if(empty($cfGroups))
            <div class="text-muted">لا توجد حقول مخصّصة لهذا العميل.</div>
          @else
            @foreach($cfGroups as $groupName => $items)
              <div class="mb-3">
                <div class="fw-bold mb-2 text-primary">
                  <i class="tio-tag"></i> {{ $groupName }}
                </div>
                <dl class="row mb-0 deflist deflist-2col">
                  @foreach($items as $item)
                    <dt class="col-sm-3">{{ $item['label'] }}</dt>
                    <dd class="col-sm-9">
                      @if($item['type'] === 'json' && $item['display'] !== '—')
                        <pre class="cf-json mb-0">{{ $item['display'] }}</pre>
                      @else
                        {{ $item['display'] }}
                      @endif
                    </dd>
                  @endforeach
                </dl>
              </div>
            @endforeach
          @endif
        </div>
      </div>

      {{-- Tabs --}}
      <div class="card crm-card mt-3">
        <div class="card-body pb-0">
          <ul class="nav nav-pills crm-tabs mb-3" id="leadTabs" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="tab-calls-tab" data-bs-toggle="tab" data-bs-target="#tab-calls" type="button" role="tab" aria-controls="tab-calls" aria-selected="true">
                <i class="tio-call-outgoing"></i> المكالمات
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="tab-notes-tab" data-bs-toggle="tab" data-bs-target="#tab-notes" type="button" role="tab" aria-controls="tab-notes" aria-selected="false">
                <i class="tio-notebook-bookmarked"></i> الملاحظات
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="tab-logs-tab" data-bs-toggle="tab" data-bs-target="#tab-logs" type="button" role="tab" aria-controls="tab-logs" aria-selected="false">
                <i class="tio-history"></i> السجل
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="tab-overview-tab" data-bs-toggle="tab" data-bs-target="#tab-overview" type="button" role="tab" aria-controls="tab-overview" aria-selected="false">
                <i class="tio-info-outlined"></i> ملخص
              </button>
            </li>
          </ul>
        </div>

        <div class="tab-content p-3 pt-0" id="leadTabsContent">
          {{-- Calls --}}
          <div class="tab-pane fade show active" id="tab-calls" role="tabpanel" aria-labelledby="tab-calls-tab">
            <div class="table-responsive">
              <table class="table table-hover align-middle table-sm mb-0">
                <thead class="table-light">
                  <tr class="text-nowrap">
                    <th>#</th>
                    <th>اتجاه</th>
                    <th>القناة</th>
                    <th>البدء</th>
                    <th>الانتهاء</th>
                    <th>المدة</th>
                    <th>النتيجة</th>
                    <th>المسؤول</th>
                    <th style="min-width: 220px">ملاحظات</th>
                  </tr>
                </thead>
                <tbody>
                @forelse($lead->callLogs as $c)
                  @php
                    $start = $c->started_at; $end = $c->ended_at;
                    $durationMin = ($start && $end) ? $end->diffInMinutes($start) : null;
                    $durStr = '—';
                    if(!is_null($durationMin)){
                      $h = intdiv($durationMin, 60); $m = $durationMin % 60;
                      $durStr = $h ? ($h.'س '.($m ? $m.'د' : '')) : ($m.'د');
                    }
                  @endphp
                  <tr>
                    <td class="text-muted small">{{ $c->id }}</td>
                    <td>
                      @if($c->direction === 'out')
                        <span class="badge dir-badge dir-out"><i class="tio-call-outgoing me-1"></i> صادرة</span>
                      @elseif($c->direction === 'in')
                        <span class="badge dir-badge dir-in"><i class="tio-call-incoming me-1"></i> واردة</span>
                      @else
                        <span class="badge bg-secondary">فائتة</span>
                      @endif
                    </td>
                    <td class="text-muted">{{ strtoupper($c->channel ?? '—') }}</td>
                    <td>{{ $start ? $start->format('Y-m-d H:i') : '—' }}</td>
                    <td>{{ $end ? $end->format('Y-m-d H:i') : '—' }}</td>
                    <td>{{ $durStr }}</td>
                    <td>{!! $c->outcome ? '<span class="badge outcome-badge">'.$c->outcome->name.'</span>' : '<span class="text-muted">—</span>' !!}</td>
                    <td class="text-muted small">{{ optional($c->admin)->email ?: '—' }}</td>
                    <td class="text-truncate" title="{{ $c->notes }}">{{ $c->notes ?: '—' }}</td>
                  </tr>
                @empty
                  <tr><td colspan="9" class="text-muted text-center py-4">لا يوجد مكالمات</td></tr>
                @endforelse
                </tbody>
              </table>
            </div>
          </div>

          {{-- Notes --}}
          <div class="tab-pane fade" id="tab-notes" role="tabpanel" aria-labelledby="tab-notes-tab">
            <div class="d-flex justify-content-end mb-2">
              <a href="{{ route('admin.lead-notes.create', ['lead_id' => $lead->id]) }}" class="btn btn-sm btn-primary">
                <i class="tio-add"></i> إضافة ملاحظة
              </a>
            </div>
            <div class="table-responsive">
              <table class="table table-hover align-middle table-sm mb-0">
                <thead class="table-light">
                  <tr>
                    <th style="width: 76px">#</th>
                    <th>النص</th>
                    <th style="width: 140px">الظهور</th>
                    <th style="width: 200px">المسؤول</th>
                    <th style="width: 140px">التاريخ</th>
                    <th style="width: 110px" class="text-center">إجراءات</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($lead->notes->sortByDesc('id') as $n)
                    <tr>
                      <td class="text-muted small">{{ $n->id }}</td>
                      <td class="text-truncate" title="{{ $n->note }}">{{ $n->note }}</td>
                      <td>
                        @switch($n->visibility)
                          @case('public') <span class="badge bg-success-subtle text-success">عام</span> @break
                          @case('team')   <span class="badge bg-info-subtle text-info">الفريق</span> @break
                          @default        <span class="badge bg-secondary-subtle text-secondary">خاص</span>
                        @endswitch
                      </td>
                      <td class="small text-muted">{{ optional($n->admin)->email ?: '—' }}</td>
                      <td class="small text-muted">{{ $n->created_at?->format('Y-m-d H:i') }}</td>
                      <td class="text-center">
                        <a class="btn btn-sm btn-light" href="{{ route('admin.lead-notes.edit',$n) }}" title="تعديل"><i class="tio-edit"></i></a>
                      </td>
                    </tr>
                  @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">لا توجد ملاحظات</td></tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>

          {{-- System Logs --}}
          <div class="tab-pane fade" id="tab-logs" role="tabpanel" aria-labelledby="tab-logs-tab">
            <div class="table-responsive">
              <table class="table table-hover align-middle table-sm mb-0">
                <thead class="table-light">
                  <tr class="text-nowrap">
                    <th>#</th>
                    <th>التاريخ</th>
                    <th>العملية</th>
                    <th>الجدول</th>
                    <th>السجل</th>
                    <th>بواسطة</th>
                    <th>تفاصيل</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($logs as $lg)
                    <tr>
                      <td class="text-muted small">{{ $lg->id }}</td>
                      <td class="small text-muted">{{ $lg->created_at?->timezone(config('app.timezone'))->format('Y-m-d H:i') }}</td>
                      <td><span class="badge bg-light text-dark">{{ $lg->action }}</span></td>
                      <td class="text-muted small">{{ $lg->table_name ?: '—' }}</td>
                      <td class="text-muted small">{{ $lg->record_id ?: '—' }}</td>
                      <td class="text-muted small">{{ optional($lg->actorAdmin)->email ?? '—' }}</td>
                      <td class="text-truncate" style="max-width:420px" title="{{ json_encode($lg->meta, JSON_UNESCAPED_UNICODE) }}">
                        {{ \Illuminate\Support\Str::limit(json_encode($lg->meta, JSON_UNESCAPED_UNICODE), 120) }}
                      </td>
                    </tr>
                  @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">لا يوجد سجلات</td></tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>

          {{-- Summary --}}
          <div class="tab-pane fade" id="tab-overview" role="tabpanel" aria-labelledby="tab-overview-tab">
            <div class="row g-3">
              <div class="col-md-6"><strong>الشركة:</strong> {{ $lead->company_name ?: '—' }}</div>
              <div class="col-md-6"><strong>الاسم:</strong> {{ $lead->contact_name ?: '—' }}</div>
              <div class="col-md-6" dir="ltr"><strong>الهاتف:</strong> {{ $tel_uri ? ($tel_cc.' '.$tel_ph) : '—' }}</div>
              <div class="col-md-6" dir="ltr"><strong>الإيميل:</strong> {{ $lead->email ?: '—' }}</div>
              <div class="col-md-6"><strong>الحالة:</strong> {{ optional($lead->status)->name ?: '—' }}</div>
              <div class="col-md-6"><strong>المصدر:</strong> {{ optional($lead->source)->name ?: '—' }}</div>
              <div class="col-md-6"><strong>المسؤول:</strong> {{ optional($lead->owner)->name ?: optional($lead->owner)->email ?: '—' }}</div>
              <div class="col-md-12"><strong>ملاحظات:</strong> {{ $lead->pipeline_notes ?: '—' }}</div>

              @if(!empty($cfGroups))
                <div class="col-12">
                  <hr>
                  <strong class="d-block mb-2">الحقول المخصّصة:</strong>
                  @foreach($cfGroups as $groupName => $items)
                    <div class="mb-2">
                      <span class="fw-semibold text-primary"><i class="tio-tag"></i> {{ $groupName }}</span>
                      <ul class="mb-0 small mt-1">
                        @foreach($items as $item)
                          <li>
                            <span class="text-muted">{{ $item['label'] }}:</span>
                            @if($item['type'] === 'json' && $item['display'] !== '—')
                              <pre class="cf-json-inline mb-1">{{ $item['display'] }}</pre>
                            @else
                              {{ $item['display'] }}
                            @endif
                          </li>
                        @endforeach
                      </ul>
                    </div>
                  @endforeach
                </div>
              @endif

            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Right --}}
    <div class="col-lg-4">
      <div class="aside-sticky">
        <div class="card crm-card mb-3">
          <div class="card-header py-2 d-flex align-items-center gap-2">
            <i class="tio-bolt"></i><strong>إجراءات سريعة</strong>
          </div>
          <div class="card-body d-grid gap-2">
            <a class="btn btn-primary btn-eq" href="{{ $tel_uri ? 'tel:'.$tel_uri : 'javascript:void(0)' }}" {{ $tel_uri ? '' : 'disabled' }}>
              <i class="tio-call-outgoing me-1"></i> اتصال
            </a>
            <a class="btn btn-success btn-eq" href="{{ $wa_url ?: 'javascript:void(0)' }}" target="_blank" rel="noopener" {{ $wa_url ? '' : 'disabled' }}>
              <i class="tio-whatsapp me-1"></i> واتساب
            </a>
            <a class="btn btn-outline-secondary btn-eq" href="{{ $lead->email ? 'mailto:'.$lead->email : 'javascript:void(0)' }}" {{ $lead->email ? '' : 'disabled' }}>
              <i class="tio-email-outlined me-1"></i> إرسال إيميل
            </a>
            @if($next)
              <div class="mt-2 small text-muted">
                <i class="tio-time-20-s me-1"></i> الموعد التالي:
                <span class="badge {{ $nextClass }}">{{ $nextLabel }}</span>
              </div>
            @endif
          </div>
        </div>

        <div class="card crm-card">
          <div class="card-header py-2 d-flex align-items-center gap-2">
            <i class="tio-calendar-month"></i><strong>معلومات إضافية</strong>
          </div>
          <div class="card-body small">
            <div class="d-flex justify-content-between py-1 border-bottom-100"><span class="text-muted">أنشئ في</span><span>{{ $lead->created_at?->format('Y-m-d H:i') ?: '—' }}</span></div>
            <div class="d-flex justify-content-between py-1 border-bottom-100"><span class="text-muted">آخر تحديث</span><span>{{ $lead->updated_at?->format('Y-m-d H:i') ?: '—' }}</span></div>
            <div class="d-flex justify-content-between py-1"><span class="text-muted">الحالة</span>
              <span>@if($lead->is_archived)<span class="badge badge-archived">مؤرشف</span>@else<span class="badge bg-success-subtle text-success">نشط</span>@endif</span>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>{{-- /row --}}

</div>

<style>
  :root{
    --card-radius: 1rem;
    --shadow-1: 0 6px 18px rgba(0,0,0,.06);
    --soft-info-bg:#e8f4ff; --soft-info:#0d6efd;
    --overdue-bg:#fdecec; --overdue:#c1121f;
    --today-bg:#fff6e5; --today:#b35c00;
    --upcoming-bg:#e9f7ef; --upcoming:#0f5132;
  }
  .crm-card{ border:0; border-radius:var(--card-radius); box-shadow:var(--shadow-1); }
  .card-header{ background:#fff; border-bottom:1px dashed #eee; }

  .btn-eq{
    --h:38px;
    min-height:var(--h); height:var(--h); line-height:calc(var(--h) - 2px);
    padding:0 .9rem; display:inline-flex; align-items:center; justify-content:center; gap:.4rem;
    border-radius:.6rem; font-size:.95rem;
  }
  .btn-xs{ --h:28px; min-height:var(--h); height:var(--h); padding:0 .6rem; font-size:.85rem; border-radius:.5rem; }

  .badge-soft-info{ background:var(--soft-info-bg); color:var(--soft-info); }
  .badge-overdue{ background:var(--overdue-bg); color:var(--overdue); }
  .badge-today{ background:var(--today-bg); color:var(--today); }
  .badge-upcoming{ background:var(--upcoming-bg); color:var(--upcoming); }
  .badge-archived{ background:#f1f1f1; color:#6c757d; border:1px solid #e7e7e7; }

  .crm-tabs .nav-link{ padding:.35rem .9rem; border-radius:2rem; }
  .crm-tabs .nav-link i{ margin-inline-start:.25rem; }

  .table td{ vertical-align:middle; }
  .table thead th{ white-space:nowrap; }

  .deflist dt{ color:#6c757d; }
  .deflist-2col dt, .deflist-2col dd{ padding-top:.4rem; padding-bottom:.4rem; }

  .dir-badge{ background:#eef2ff; color:#3d52d5; }
  .dir-in{ background:#e7fff3; color:#0f6b3e; }
  .outcome-badge{ background:#e9f6ff; color:#0b6aa2; }

  .border-bottom-100{ border-bottom:1px dashed #eee; }
  .dot-sep{ opacity:.6; }

  .aside-sticky{ position:sticky; top:88px; }

  .cf-json{
    white-space: pre-wrap;
    background: #f8fafc;
    border: 1px solid #eef2f7;
    border-radius: .5rem;
    padding: .5rem .75rem;
    font-size: .875rem;
    direction: ltr;
    text-align: left;
  }
  .cf-json-inline{
    white-space: pre-wrap;
    background: #f8fafc;
    border: 1px solid #eef2f7;
    border-radius: .35rem;
    padding: .25rem .5rem;
    direction: ltr;
    text-align: left;
  }
</style>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
  // ===== Tooltips (آمنة حتى لو مفيش Bootstrap) =====
  if (typeof bootstrap !== 'undefined' && bootstrap?.Tooltip) {
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function (el) {
      try { new bootstrap.Tooltip(el); } catch (e) {}
    });
  }

  // ===== Copy buttons via delegation (يمنع null) =====
  document.addEventListener('click', async function (e) {
    var btn = e.target.closest('.copy-btn');
    if (!btn) return;

    var val = btn.getAttribute('data-copy') || '';
    try {
      await navigator.clipboard.writeText(val);
      // جرّب إظهار Tooltip "تم النسخ"
      if (typeof bootstrap !== 'undefined' && bootstrap?.Tooltip) {
        let tip = bootstrap.Tooltip.getInstance(btn) || new bootstrap.Tooltip(btn);
        btn.setAttribute('data-bs-original-title', 'تم النسخ');
        tip.show();
        setTimeout(function () { tip.hide(); btn.setAttribute('data-bs-original-title', 'نسخ'); }, 900);
      }
    } catch (err) {
      // صامت
    }
  });

  // ===== Tabs: Bootstrap ثم Fallback =====
  var tabsContainer = document.getElementById('leadTabs');
  var panesContainer = document.getElementById('leadTabsContent');
  if (!tabsContainer || !panesContainer) return;

  var useBootstrap = (typeof bootstrap !== 'undefined' && typeof bootstrap.Tab === 'function');

  function activatePane(targetSelector) {
    var target = panesContainer.querySelector(targetSelector);
    if (!target) return;

    // deactivate all
    tabsContainer.querySelectorAll('[data-bs-toggle="tab"]').forEach(function (b) {
      b.classList.remove('active');
      b.setAttribute('aria-selected', 'false');
    });
    panesContainer.querySelectorAll('.tab-pane').forEach(function (p) {
      p.classList.remove('show', 'active');
    });

    // activate current
    var btn = tabsContainer.querySelector('[data-bs-target="' + targetSelector + '"]');
    if (btn) {
      btn.classList.add('active');
      btn.setAttribute('aria-selected', 'true');
    }
    target.classList.add('show', 'active');
  }

  // إن كان Bootstrap موجود فعِّل التابز
  if (useBootstrap) {
    tabsContainer.querySelectorAll('[data-bs-toggle="tab"]').forEach(function (btn) {
      try {
        // اربط إنstance مرّة واحدة
        if (!btn._bsTab) btn._bsTab = new bootstrap.Tab(btn, { toggle: false });

        // عند الإظهار حدّث الهاش
        btn.addEventListener('shown.bs.tab', function (e) {
          var target = e.target?.getAttribute('data-bs-target');
          if (target) {
            try { history.replaceState(null, '', target); } catch (e) {}
          }
        });

        // عند الضغط، استدعِ show يدويًا لضمان العمل
        btn.addEventListener('click', function (ev) {
          ev.preventDefault();
          btn._bsTab.show();
        });
      } catch (e) {}
    });
  } else {
    // Fallback: تفويض النقر على الأزرار
    tabsContainer.addEventListener('click', function (e) {
      var b = e.target.closest('[data-bs-toggle="tab"]');
      if (!b) return;
      e.preventDefault();
      var target = b.getAttribute('data-bs-target');
      if (target) {
        activatePane(target);
        try { history.replaceState(null, '', target); } catch (e) {}
      }
    });
  }

  // افتح التاب من الهاش إن وُجد وإلا اضمن تفعيل أول واحد
  (function initFromHash() {
    var hash = window.location.hash;
    var hasMatch = !!tabsContainer.querySelector('[data-bs-target="' + hash + '"]');
    if (hash && hasMatch) {
      if (useBootstrap) {
        var btn = tabsContainer.querySelector('[data-bs-target="' + hash + '"]');
        btn && btn._bsTab && btn._bsTab.show();
      } else {
        activatePane(hash);
      }
    } else {
      // تأكد في الحالتين
      var firstBtn = tabsContainer.querySelector('[data-bs-toggle="tab"]');
      var firstTarget = firstBtn?.getAttribute('data-bs-target');
      if (firstTarget) {
        if (useBootstrap) { firstBtn._bsTab && firstBtn._bsTab.show(); }
        else { activatePane(firstTarget); }
      }
    }
  })();
});
</script>
@endsection
