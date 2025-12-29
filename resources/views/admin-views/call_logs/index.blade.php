{{-- resources/views/admin/calls/logs/index.blade.php --}}
@extends('layouts.admin.app')
@section('title','سجلات المكالمات')

@section('content')
@php
  $q = request()->query();

  // شارة "التالي"
  $badgeForNext = function($dt){
    if(!$dt) return null;
    if(now()->gt($dt))      return 'badge-overdue';
    elseif($dt->isToday())  return 'badge-today';
    return 'badge-upcoming';
  };

  // فورمات مدة بالثواني -> H:MM:SS
  $fmtDur = function($sec){
    if(!is_numeric($sec) || $sec < 0) return '—';
    $h = intdiv($sec, 3600);
    $m = intdiv($sec % 3600, 60);
    $s = $sec % 60;
    return ($h ? $h.':' : '').str_pad($m,2,'0',STR_PAD_LEFT).':'.str_pad($s,2,'0',STR_PAD_LEFT);
  };

  // إحصائيات الصفحة الحالية
  $pageCount = $logs->count();
  // إن كان الحقل duration_sec غير موجود، نحسبه من الفرق بين البدء والانتهاء
  $pageDur   = $logs->sum(function($l){
    if(is_numeric($l->duration_sec)) return (int)$l->duration_sec;
    if($l->started_at && $l->ended_at) return $l->ended_at->diffInSeconds($l->started_at);
    return 0;
  });

  // خرائط للاتجاه والقناة
  $dirMap = [
    'in'      => ['label'=>'واردة','class'=>'badge-soft-success','icon'=>'tio-call-incoming'],
    'out'     => ['label'=>'صادرة','class'=>'badge-soft-primary','icon'=>'tio-call-outgoing'],
    'missed'  => ['label'=>'فائتة','class'=>'badge-soft-warning','icon'=>'tio-warning'],
  ];
  $chanMap = [
    'phone'   => ['label'=>'هاتف','icon'=>'tio-iphone'],
    'whatsapp'=> ['label'=>'واتساب','icon'=>'tio-whatsapp'],
    'sms'     => ['label'=>'SMS','icon'=>'tio-message'],
  ];
@endphp

<div class="content container-fluid">

  {{-- العنوان + الإجراءات --}}
  <div class="page-head mb-3">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
      <div class="d-flex align-items-center gap-2">
        <div>
          <h3 class="mb-0 fw-bold">سجلات المكالمات</h3>
          <div class="text-muted small mt-1">تابع مكالمات فريقك، فلتر بسرعة، وصدّر النتائج.</div>
        </div>
      </div>
      <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('admin.call-logs.export', $q) }}" class="btn btn-secondary btn-eq">
          <i class="tio-file-outlined"></i> تصدير
        </a>
        <a href="{{ route('admin.call-logs.create') }}" class="btn btn-primary btn-eq">
          <i class="tio-add"></i> جديد
        </a>
      </div>
    </div>

    {{-- كروت سريعة --}}
    <div class="row g-3 mt-3">
      <div class="col-12 col-sm-6 col-lg-4">
        <div class="card kpi-card">
          <div class="card-body d-flex justify-content-between align-items-center">
            <div>
              <div class="kpi-label">إجمالي السجلات</div>
              <div class="kpi-value">{{ $logs->total() }}</div>
            </div>
            <i class="tio-menu-vs kpi-icon"></i>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-lg-4">
        <div class="card kpi-card">
          <div class="card-body d-flex justify-content-between align-items-center">
            <div>
              <div class="kpi-label">سجلات الصفحة</div>
              <div class="kpi-value">{{ $pageCount }}</div>
            </div>
            <i class="tio-list kpi-icon"></i>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-lg-4">
        <div class="card kpi-card">
          <div class="card-body d-flex justify-content-between align-items-center">
            <div>
              <div class="kpi-label">مدة مكالمات الصفحة</div>
              <div class="kpi-value">{{ $fmtDur($pageDur) }}</div>
            </div>
            <i class="tio-timer-20-s kpi-icon"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- الفلاتر --}} 
  <div class="card mb-3">
    <form method="GET" id="filters-form">
      <div class="card-body">
        <div class="row g-3 align-items-end">

          {{-- 🔎 مربع البحث الكبير --}}
          <div class="col-12">
            <div class="search-wrap">
              <i class="tio-search search-icon"></i>
              <input type="text" name="search" id="search-input" value="{{ $filters['search'] ?? ($q['search'] ?? '') }}" class="form-control form-control-hero" placeholder="ابحث بالاسم / الشركة / الهاتف / الملاحظات…">
              <button type="button" id="search-clear" class="search-clear" title="مسح"><i class="tio-clear"></i></button>
              <button class="btn btn-primary btn-hero" type="submit"><i class="tio-search"></i> بحث</button>
            </div>
          </div>

          {{-- بقية الفلاتر --}}
          <div class="col-12 col-sm-6 col-xl-2">
            <label class="form-label">النتيجة</label>
            <select name="outcome_id" class="form-select js-select2" data-placeholder="الكل">
              <option value="">الكل</option>
              @foreach($outcomes as $o)
                <option value="{{ $o->id }}" @selected(($filters['outcome_id'] ?? ($q['outcome_id'] ?? ''))==$o->id)>{{ $o->name }}</option>
              @endforeach
            </select>
          </div>

          <div class="col-12 col-sm-6 col-xl-2">
            <label class="form-label">المسؤول</label>
            <select name="admin_id" class="form-select js-select2" data-placeholder="الكل">
              <option value="">الكل</option>
              @foreach($admins as $ad)
                <option value="{{ $ad->id }}" @selected(($filters['admin_id'] ?? ($q['admin_id'] ?? ''))==$ad->id)>{{ $ad->email }}</option>
              @endforeach
            </select>
          </div>

          <div class="col-12">
            <div class="row g-3">
              <div class="col-6 col-md-3">
                <label class="form-label">بدأت من</label>
                <input type="date" name="started_from" value="{{ $filters['started_from'] ?? ($q['started_from'] ?? '') }}" class="form-control">
              </div>
              <div class="col-6 col-md-3">
                <label class="form-label">بدأت إلى</label>
                <input type="date" name="started_to" value="{{ $filters['started_to'] ?? ($q['started_to'] ?? '') }}" class="form-control">
              </div>
              <div class="col-6 col-md-3">
                <label class="form-label">انتهت من</label>
                <input type="date" name="ended_from" value="{{ $filters['ended_from'] ?? ($q['ended_from'] ?? '') }}" class="form-control">
              </div>
              <div class="col-6 col-md-3">
                <label class="form-label">انتهت إلى</label>
                <input type="date" name="ended_to" value="{{ $filters['ended_to'] ?? ($q['ended_to'] ?? '') }}" class="form-control">
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- أشرطة الفلاتر النشطة (chips) --}}
      @php
        $chips = [];
        $mkchip = function($label,$param) use($q,&$chips){
          if(!isset($q[$param]) || $q[$param]==='') return;
          $url = route('admin.call-logs.index', collect($q)->except($param,'page')->toArray());
          $chips[] = '<a href="'.$url.'" class="filter-chip" title="إزالة">'.$label.' <i class="tio-clear"></i></a>';
        };
        $mkchip('بحث: '.($q['search'] ?? ''), 'search');
        if(!empty($q['outcome_id'])) $mkchip('نتيجة: #'.$q['outcome_id'], 'outcome_id');
        if(!empty($q['admin_id']))   $mkchip('مسؤول: #'.$q['admin_id'], 'admin_id');
        if(!empty($q['started_from'])) $mkchip('بدأت من: '.$q['started_from'], 'started_from');
        if(!empty($q['started_to']))   $mkchip('بدأت إلى: '.$q['started_to'], 'started_to');
        if(!empty($q['ended_from']))   $mkchip('انتهت من: '.$q['ended_from'], 'ended_from');
        if(!empty($q['ended_to']))     $mkchip('انتهت إلى: '.$q['ended_to'], 'ended_to');
      @endphp
      @if(count($chips))
        <div class="px-3 pb-2">
          <div class="d-flex flex-wrap align-items-center gap-2">
            {!! implode('', $chips) !!}
            <a class="filter-chip clear" href="{{ route('admin.call-logs.index') }}" title="مسح الكل">
              مسح الكل <i class="tio-rotate"></i>
            </a>
          </div>
        </div>
      @endif

      <div class="card-footer d-flex justify-content-end flex-wrap gap-2">
        <button class="btn btn-secondary btn-eq">
          <i class="tio-filter-list"></i> فلترة
        </button>
        <a href="{{ route('admin.call-logs.index') }}" class="btn btn-light btn-eq">
          <i class="tio-rotate"></i> إعادة
        </a>
      </div>
    </form>
  </div>

  {{-- الجدول --}}
  <div class="card">
    <div class="table-responsive">
      <table class="table table-hover table-nowrap align-middle mb-0">
        <thead class="table-light sticky-head">
          <tr>
            <th style="width:72px">#</th>
            <th>Lead</th>
            <th>الهاتف</th>
            <th>الاتجاه</th>
            <th>القناة</th>
            <th>المسؤول</th>
            <th>النتيجة</th>
            <th>بدأت</th>
            <th>انتهت</th>
            <th>المدة</th>
            <th>التالي</th>
            <th class="text-center" style="width:200px">إجراءات</th>
          </tr>
        </thead>
        <tbody>
          @forelse($logs as $l)
            @php
              $lead = $l->lead;
              $cc   = trim($lead->country_code ?? '');
              $ph   = trim($lead->phone ?? '');
              $tel  = ($cc && $ph) ? ($cc.$ph) : null;

              $next = $l->next_action_at;
              $nextClass = $badgeForNext($next);

              $durSec = is_numeric($l->duration_sec)
                        ? (int)$l->duration_sec
                        : (($l->started_at && $l->ended_at) ? $l->ended_at->diffInSeconds($l->started_at) : null);

              $dirKey = strtolower((string)$l->direction);
              $dir    = $dirMap[$dirKey] ?? ['label'=>'—','class'=>'badge-soft-dark','icon'=>'tio-more'];
              $chanKey= strtolower((string)$l->channel);
              $chan   = $chanMap[$chanKey] ?? ['label'=>($l->channel ?: '—'),'icon'=>'tio-more'];
            @endphp
            <tr>
              <td class="text-muted">{{ $l->id }}</td>

              <td class="fw-semibold">
                <div class="d-flex flex-column">
                  <span class="text-truncate-2" style="max-width:220px">{{ $lead?->contact_name ?: $lead?->company_name ?: '—' }}</span>
                  @if($lead?->company_name)
                    <span class="small text-muted text-truncate" style="max-width:220px">{{ $lead->company_name }}</span>
                  @endif
                </div>
              </td>

              <td dir="ltr">
                @if($tel)
                  <div class="d-flex align-items-center gap-2 flex-wrap">
                    <a class="link-primary" href="tel:{{ $tel }}">{{ $cc }} {{ $ph }}</a>
                    <button class="icon-btn copy-btn" data-copy="{{ $tel }}" data-bs-toggle="tooltip" data-bs-placement="top" title="نسخ">
                      <i class="tio-copy"></i>
                    </button>
                  </div>
                  @if($l->phone_used)
                    <div class="small text-muted">من خط: {{ $l->phone_used }}</div>
                  @endif
                @else
                  <span class="text-muted">—</span>
                @endif
              </td>

              <td>
                <span class="badge {{ $dir['class'] }}">
                  <i class="{{ $dir['icon'] }}"></i> {{ $dir['label'] }}
                </span>
              </td>

              <td>
                <span class="badge badge-soft-info">
                  <i class="{{ $chan['icon'] }}"></i> {{ $chan['label'] }}
                </span>
              </td>

              <td>
                @if($l->admin)
                  <span class="badge badge-soft-dark">{{ $l->admin->email }}</span>
                @else
                  <span class="text-muted">—</span>
                @endif
              </td>

              <td>
                @if($l->outcome)
                  <span class="badge badge-soft-info">{{ $l->outcome->name }}</span>
                @else
                  <span class="text-muted">—</span>
                @endif
              </td>

              <td title="{{ optional($l->started_at)?->toDateTimeString() ?: '' }}">
                {{ optional($l->started_at)?->format('Y-m-d H:i') ?: '—' }}
              </td>

              <td title="{{ optional($l->ended_at)?->toDateTimeString() ?: '' }}">
                {{ optional($l->ended_at)?->format('Y-m-d H:i') ?: '—' }}
              </td>

              <td>{{ $fmtDur($durSec) }}</td>

              <td>
                @if($next)
                  <span class="badge {{ $nextClass }}">{{ $next->format('Y-m-d H:i') }}</span>
                @else
                  <span class="text-muted">—</span>
                @endif
              </td>

              <td class="text-center">
                <div class="d-inline-flex align-items-center flex-wrap gap-1">
                  @if(!empty($l->recording_url))
                    <a href="{{ $l->recording_url }}" target="_blank" class="icon-btn" data-bs-toggle="tooltip" title="تسجيل">
                      <i class="tio-headset"></i>
                    </a>
                  @endif
                  @if(!empty($l->notes))
                    <button type="button" class="icon-btn btn-notes" data-notes="{{ e($l->notes) }}" data-bs-toggle="tooltip" title="ملاحظات">
                      <i class="tio-info"></i>
                    </button>
                  @endif
                  <a href="{{ route('admin.call-logs.edit',$l) }}" class="icon-btn text-primary" data-bs-toggle="tooltip" title="تعديل">
                    <i class="tio-edit"></i>
                  </a>
                  <form method="post" action="{{ route('admin.call-logs.destroy',$l) }}" onsubmit="return confirm('حذف السجل؟');" class="d-inline">
                    @csrf @method('DELETE')
                    <button class="icon-btn text-danger" type="submit" data-bs-toggle="tooltip" title="حذف">
                      <i class="tio-delete-outlined"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr><td colspan="12" class="text-center text-muted py-4">لا توجد بيانات</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="card-footer d-flex justify-content-between align-items-center flex-wrap gap-2">
      <div class="small text-muted">
        عرض {{ $logs->firstItem() }}–{{ $logs->lastItem() }} من {{ $logs->total() }}
      </div>
      <div>{{ $logs->appends($q)->links() }}</div>
    </div>
  </div>
</div>

{{-- Modal الملاحظات --}}
<div class="modal fade" id="notesModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-3">
      <div class="modal-header">
        <h5 class="modal-title"><i class="tio-notes"></i> ملاحظات المكالمة</h5>
        <button type="button" class="btn-close ms-0" data-bs-dismiss="modal" aria-label="اغلاق"></button>
      </div>
      <div class="modal-body">
        <pre class="notes-pre mb-0" id="notesBody"></pre>
      </div>
      <div class="modal-footer">
        <button class="btn btn-light" data-bs-dismiss="modal">اغلاق</button>
      </div>
    </div>
  </div>
</div>

<style>
  :root{
    --card-radius: 1rem;
    --shadow-1: 0 6px 18px rgba(0,0,0,.06);
    --soft-info-bg:#e8f4ff; --soft-info:#0d6efd;
    --soft-dark-bg:#f4f4f4; --soft-dark:#39424e;
    --overdue-bg:#fdecec; --overdue:#c1121f;
    --today-bg:#fff6e5; --today:#b35c00;
    --upcoming-bg:#e9f7ef; --upcoming:#0f5132;
  }
  .card{ border:0; border-radius:var(--card-radius); box-shadow:var(--shadow-1); }
  .kpi-card .kpi-label{ font-size:.86rem; color:#6c757d; }
  .kpi-card .kpi-value{ font-size:1.25rem; font-weight:700; }
  .kpi-card .kpi-icon{ font-size:1.4rem; opacity:.45; }

  /* أزرار موحّدة المقاس */
  .btn-eq{ min-height:42px; display:inline-flex; align-items:center; gap:.35rem; padding-inline:.85rem; }

  /* 🔎 مربع بحث هيرو */
  .form-control-hero{ height:56px; padding-inline:2.8rem 7.25rem; border-radius:.75rem; font-size:1.05rem; border:1px solid #dfe3e8; box-shadow: inset 0 1px 0 rgba(0,0,0,0.02), 0 2px 10px rgba(0,0,0,0.04); transition: box-shadow .2s, border-color .2s; background:white; }
  .form-control-hero:focus{ border-color:#b6c7ff; box-shadow:0 6px 20px rgba(13,110,253,.08); }
  .search-wrap{ position:relative; }
  .search-icon{ position:absolute; inset-inline-start:12px; top:50%; transform:translateY(-50%); opacity:.6; font-size:1.1rem; }
  .search-clear{ position:absolute; inset-inline-end:148px; top:50%; transform:translateY(-50%); border:0; background:#f2f4f7; color:#6b7280; width:36px; height:36px; border-radius:50%; display:none; align-items:center; justify-content:center; }
  .search-clear:hover{ background:#e9ecef; }
  .btn-hero{ position:absolute; inset-inline-end:8px; top:8px; height:40px; border-radius:.6rem; display:inline-flex; align-items:center; gap:.35rem; }

  .badge-soft-info{ background:var(--soft-info-bg); color:var(--soft-info); }
  .badge-soft-dark{ background:var(--soft-dark-bg); color:var(--soft-dark); }
  .badge-overdue{ background:var(--overdue-bg); color:var(--overdue); }
  .badge-today{ background:var(--today-bg); color:var(--today); }
  .badge-upcoming{ background:var(--upcoming-bg); color:var(--upcoming); }

  /* جدول */
  .table td{ vertical-align:middle; }
  .table thead th{ white-space:nowrap; }
  .table-hover tbody tr:hover{ background:#fcfcfd; }
  .sticky-head{ position:sticky; top:0; z-index:1; }
  .text-truncate-2{ overflow:hidden; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; }

  /* فلاتر نشطة (chips) */
  .filter-chip{ display:inline-flex; align-items:center; gap:.45rem; padding:.35rem .7rem; border-radius:1rem; font-size:.85rem; background:#f6f7f9; color:#39424e; text-decoration:none; border:1px solid #eceff3; }
  .filter-chip i{ opacity:.6; font-size:1rem; }
  .filter-chip.clear{ background:#fff4f4; color:#c1121f; border-color:#ffe2e2; }

  /* Select2 + RTL */
  .select2-container{ width:100%!important; }
  .select2-container--default .select2-selection--single{ height:44px; border:1px solid #ced4da; border-radius:.5rem; display:flex; align-items:center; }
  .select2-container--default .select2-selection--single .select2-selection__rendered{ padding-inline:.5rem; width:100%; }
  .select2-container--default .select2-selection--single .select2-selection__arrow{ height:44px; inset-inline-end:.35rem; }

  /* Icon-only buttons for table actions */
  .icon-btn{ width:36px; height:36px; display:inline-grid; place-items:center; border:0; background:transparent; border-radius:.6rem; color:#495057; }
  .icon-btn:hover{ background:#f1f3f5; color:#0d6efd; }
  .icon-btn:focus{ outline:0; box-shadow:0 0 0 .2rem rgba(13,110,253,.15); }

  .notes-pre{ white-space:pre-wrap; font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, 'Liberation Mono', 'Courier New', monospace; background:#f8fafc; border:1px solid #eef2f7; padding:1rem; border-radius:.75rem; }

  @media (max-width: 575.98px){
    .form-control-hero{ padding-inline:2.6rem 6.3rem; height:52px; }
    .search-clear{ inset-inline-end:130px; }
    .btn-hero{ height:40px; }
  }
</style>

{{-- Select2 CSS (CDN) --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">

{{-- jQuery (لو مش محمّل في الـlayout) --}}
<script>
  window.jQuery || document.write('<script src="https://code.jquery.com/jquery-3.7.1.min.js"><\/script>')
</script>

{{-- Select2 JS --}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
  (function(){
    const $ = window.jQuery; if(!$) return;

    // تهيئة Select2
    $('.js-select2').each(function(){
      const $el = $(this);
      $el.select2({ width:'100%', dir:'rtl', placeholder:$el.data('placeholder')||'', allowClear:true, language:{ noResults:()=> 'لا توجد نتائج' } });
    });

    // 🔎 تحكم زر المسح
    const $searchInput = $('#search-input');
    const $clearBtn    = $('#search-clear');
    function toggleClear(){ const hasValue = ($searchInput.val()||'').trim().length>0; $clearBtn.css('display', hasValue ? 'inline-flex' : 'none'); }
    toggleClear();
    $searchInput.on('input change keyup', toggleClear);
    $clearBtn.on('click', function(){ $searchInput.val(''); toggleClear(); $searchInput.focus(); });

    // Enter يسبميت
    $searchInput.on('keydown', function(e){ if(e.key==='Enter'){ e.preventDefault(); $('#filters-form').trigger('submit'); }});

    // نسخ الهاتف
    $(document).on('click','.copy-btn', function(){
      const val = $(this).data('copy');
      if(navigator.clipboard && window.isSecureContext){
        navigator.clipboard.writeText(val).then(()=> {
          $(this).attr('title','تم النسخ').addClass('copied');
          setTimeout(()=>$(this).attr('title','نسخ').removeClass('copied'),800);
        });
      } else {
        const ta = $('<textarea>').val(val).css({position:'fixed',opacity:0});
        $('body').append(ta); ta[0].select(); try{ document.execCommand('copy'); }catch(e){} ta.remove();
      }
    });

    // Tooltips (Bootstrap)
    if(window.bootstrap){
      const triggers = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
      triggers.forEach(el => new bootstrap.Tooltip(el));
    }

    // ملاحظات
    const $notesModal = $('#notesModal'), $notesBody = $('#notesBody');
    $(document).on('click','.btn-notes', function(){
      const notes = $(this).data('notes') || '';
      $notesBody.text(notes);
      const modal = new bootstrap.Modal($notesModal[0]);
      modal.show();
    });
  })();
</script>

@endsection
