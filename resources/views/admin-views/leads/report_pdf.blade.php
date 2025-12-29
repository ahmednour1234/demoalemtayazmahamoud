{{-- resources/views/admin/leads/report.blade.php --}}
@php
  /** @var \App\Models\Lead $lead */
  // تحميل العلاقات لتفادي N+1
  $lead->loadMissing([
    'status','source','owner',
    'customFieldValues.customField',
    'callLogs.outcome','callLogs.admin',
    'notes.admin',
  ]);

  // تجهيز الحقول المخصّصة (يدعم multiselect/select/json)
  $cfPairs = [];
  foreach ($lead->customFieldValues as $v) {
    $field = $v->customField;
    if (!$field || !$field->is_active) continue;

    $label = $field->name;
    $type  = strtolower($field->type ?? '');
    $opts  = $field->options;

    // استخراج choices إن وُجدت
    $choicesById = [];
    if (is_string($opts)) {
      $tmp = json_decode($opts, true);
      if (json_last_error() === JSON_ERROR_NONE) $opts = $tmp;
    }
    if (is_array($opts) && isset($opts['choices']) && is_array($opts['choices'])) {
      foreach ($opts['choices'] as $c) {
        if (isset($c['id'])) $choicesById[(string)$c['id']] = $c['name'] ?? (string)$c['id'];
      }
    }

    // تنسيق القيمة
    $display = '—';
    if (!is_null($v->value_json)) {
      if ($type === 'multiselect') {
        $arr = is_array($v->value_json) ? $v->value_json : [];
        $labels = array_map(function($x) use ($choicesById){
          $k = (string)(is_scalar($x) ? $x : json_encode($x, JSON_UNESCAPED_UNICODE));
          return $choicesById[$k] ?? $k;
        }, $arr);
        $display = count($labels) ? implode('، ', $labels) : '—';
      } elseif ($type === 'json') {
        $display = json_encode($v->value_json, JSON_UNESCAPED_UNICODE);
      } else {
        $display = is_scalar($v->value_json) ? (string)$v->value_json : json_encode($v->value_json, JSON_UNESCAPED_UNICODE);
      }
    } else {
      $raw = $v->value;
      if ($raw === null || $raw === '') {
        $display = '—';
      } else {
        if ($type === 'boolean') {
          $display = in_array((string)$raw, ['1','true','on','yes'], true) ? 'نعم' : 'لا';
        } elseif ($type === 'select') {
          $display = $choicesById[(string)$raw] ?? (string)$raw;
        } else {
          $display = (string)$raw;
        }
      }
    }

    $cfPairs[] = [$label, $display, $type];
  }

  // مساعدات
  $fmtPhone = trim(($lead->country_code ?? '') . ' ' . ($lead->phone ?? '')) ?: '—';
  $fmtOwner = optional($lead->owner)->name ?: optional($lead->owner)->email ?: '—';
  $nowStamp = now()->format('Y-m-d H:i');

  // (اختياري) شعار مضمَّن Base64 لو حبيت تفعّله لاحقًا:
  // $logoAbs = public_path('images/logo.png');
  // $logoData = (is_file($logoAbs) ? 'data:image/png;base64,'.base64_encode(@file_get_contents($logoAbs)) : null);
@endphp
<!doctype html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="utf-8">
  <title>تقرير Lead #{{ $lead->id }}</title>
  <style>
    /* ===== تضمين خط عربي (إن وُجد) ===== */
    @font-face {
      font-family: 'Amiri';
      font-style: normal;
      font-weight: normal;
      src: url('{{ public_path('fonts/Amiri-Regular.ttf') }}') format('truetype');
    }
    @font-face {
      font-family: 'Amiri';
      font-style: normal;
      font-weight: bold;
      src: url('{{ public_path('fonts/Amiri-Bold.ttf') }}') format('truetype');
    }

    @page { margin: 90px 40px 70px 40px; }
    #page-header {
      position: fixed; top: -70px; left: 0; right: 0; height: 60px;
      border-bottom: 1px solid #e5e7eb; padding: 8px 0;
    }
    #page-footer {
      position: fixed; bottom: -50px; left: 0; right: 0; height: 40px;
      border-top: 1px solid #e5e7eb; font-size: 11px; color:#666;
      display: flex; align-items: center; justify-content: space-between;
    }
    .pagenum:before { content: counter(page); }
    .pagecount:before { content: counter(pages); }

    *{ box-sizing: border-box; }
    html,body{ direction: rtl; }
    body{
      /* لو خط Amiri مش موجود، يرجع لـ DejaVu Sans */
      font-family: 'Amiri', 'DejaVu Sans', Tahoma, Arial, sans-serif;
      font-size: 12px; color:#111; line-height: 1.65;
      /* تحسين ربط الأحرف */
      font-kerning: normal; font-variant-ligatures: contextual common-ligatures;
    }
    h1,h2,h3{ margin:0 0 8px; }
    .muted{ color:#666; }
    .small{ font-size: 11px; }
    .section{ margin-bottom: 16px; page-break-inside: avoid; }
    .card{ border:1px solid #e5e7eb; border-radius:8px; padding:12px; }
    .mb-6{ margin-bottom: 6px; }
    .mt-2{ margin-top: 8px; }
    .two-col{ display:flex; gap:12px; }
    .two-col > div{ flex:1; }
    .badge{ display:inline-block; padding:2px 6px; border-radius:4px; background:#eef2ff; }

    table{ width:100%; border-collapse: collapse; }
    th,td{ border:1px solid #e5e7eb; padding:6px 8px; vertical-align: top; }
    th{ background:#f7f7f7; }
    thead { display: table-header-group; }
    tfoot { display: table-footer-group; }
    tr { page-break-inside: avoid; }

    .ltr { direction: ltr; unicode-bidi: plaintext; }
    .prelike {
      white-space: pre-wrap; word-break: break-word;
      background:#fafafa; border:1px solid #efefef; border-radius:6px; padding:6px 8px;
      font-family: 'DejaVu Sans', Tahoma, Arial, sans-serif;
    }
  </style>
</head>
<body>

  {{-- Header ثابت بدون صور (لتجنّب خطأ Image not found). لو عايز شعار، فعّل $logoData فوق وحط <img src="{{ $logoData }}"> --}}
  <div id="page-header">
    <table style="width:100%; border-collapse:collapse; border:none;">
      <tr>
        <td style="border:none;">
          <h2>تقرير العميل المحتمل — Lead #{{ $lead->id }}</h2>
          <div class="small muted">تاريخ الطباعة: {{ $nowStamp }}</div>
        </td>
        <td style="border:none; text-align:left;" class="ltr small muted">
          {{-- شعار اختياري:
          @if(!empty($logoData))
            <img src="{{ $logoData }}" alt="Logo" height="36">
          @endif
          --}}
        </td>
      </tr>
    </table>
  </div>

  <div id="page-footer">
    <div>Lead #{{ $lead->id }} — {{ $lead->contact_name ?: '—' }}</div>
    <div class="ltr">صفحة <span class="pagenum"></span> / <span class="pagecount"></span></div>
  </div>

  <main>
    {{-- معلومات أساسية --}}
    <div class="section">
      <div class="card">
        <h3>البيانات الأساسية</h3>
        <div class="two-col">
          <div>
            <div><strong>الشركة:</strong> {{ $lead->company_name ?: '—' }}</div>
            <div><strong>الاسم:</strong> {{ $lead->contact_name ?: '—' }}</div>
            <div class="ltr"><strong>الهاتف:</strong> {{ $fmtPhone }}</div>
            <div class="ltr"><strong>الإيميل:</strong> {{ $lead->email ?: '—' }}</div>
          </div>
          <div>
            <div><strong>الحالة:</strong> {{ optional($lead->status)->name ?: '—' }}</div>
            <div><strong>المصدر:</strong> {{ optional($lead->source)->name ?: '—' }}</div>
            <div><strong>المسؤول:</strong> {{ $fmtOwner }}</div>
            <div><strong>آخر متابعة:</strong> {{ $lead->next_action_at?->format('Y-m-d H:i') ?: '—' }}</div>
          </div>
        </div>
        <div class="mt-2"><strong>ملاحظات المتابعة (Pipeline):</strong>
          <div class="prelike">{{ $lead->pipeline_notes ?: '—' }}</div>
        </div>
      </div>
    </div>

    {{-- الحقول المخصّصة --}}
    <div class="section">
      <div class="card">
        <h3>الحقول المخصّصة</h3>
        @if(empty($cfPairs))
          <div class="muted">لا توجد حقول مخصّصة.</div>
        @else
          <table>
            <thead>
              <tr><th style="width:28%;">الحقل</th><th>القيمة</th></tr>
            </thead>
            <tbody>
              @foreach($cfPairs as [$k, $v, $t])
                @php
                  $vStr = is_string($v) ? $v : json_encode($v, JSON_UNESCAPED_UNICODE);
                  $isJsonLike = is_string($vStr) && strlen($vStr) > 0 && (substr($vStr,0,1) === '{' || substr($vStr,0,1) === '[');
                @endphp
                <tr>
                  <td>{{ $k }}</td>
                  <td>
                    @if($t === 'json' && $isJsonLike)
                      <div class="prelike ltr">{{ $vStr }}</div>
                    @else
                      {{ $vStr }}
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        @endif
      </div>
    </div>

    {{-- المكالمات --}}
    <div class="section">
      <div class="card">
        <h3>سجل المكالمات</h3>
        @if($lead->callLogs->isEmpty())
          <div class="muted">لا توجد مكالمات.</div>
        @else
          <table>
            <thead>
              <tr>
                <th style="width:60px;">#</th>
                <th style="width:90px;">الاتجاه</th>
                <th style="width:90px;">القناة</th>
                <th style="width:140px;">البداية</th>
                <th style="width:140px;">النهاية</th>
                <th style="width:90px;">المدة (د)</th>
                <th style="width:120px;">النتيجة</th>
                <th style="width:180px;">المسؤول</th>
                <th>ملاحظات</th>
              </tr>
            </thead>
            <tbody>
              @foreach($lead->callLogs->sortBy('started_at') as $c)
                @php
                  $start = $c->started_at; $end = $c->ended_at;
                  $durationMin = ($start && $end) ? $end->diffInMinutes($start) : null;
                @endphp
                <tr>
                  <td class="small muted">{{ $c->id }}</td>
                  <td>{{ ['out'=>'صادرة','in'=>'واردة','missed'=>'فائتة'][$c->direction] ?? '—' }}</td>
                  <td class="ltr">{{ strtoupper($c->channel ?? '—') }}</td>
                  <td class="ltr">{{ $start? $start->format('Y-m-d H:i') : '—' }}</td>
                  <td class="ltr">{{ $end? $end->format('Y-m-d H:i') : '—' }}</td>
                  <td>{{ is_null($durationMin) ? '—' : $durationMin }}</td>
                  <td>{{ $c->outcome->name ?? '—' }}</td>
                  <td class="ltr">{{ $c->admin->email ?? '—' }}</td>
                  <td>{{ $c->notes ?: '—' }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        @endif
      </div>
    </div>

    {{-- الملاحظات --}}
    <div class="section">
      <div class="card">
        <h3>الملاحظات</h3>
        @if($lead->notes->isEmpty())
          <div class="muted">لا توجد ملاحظات.</div>
        @else
          <table>
            <thead>
              <tr>
                <th style="width:60px;">#</th>
                <th>النص</th>
                <th style="width:110px;">الظهور</th>
                <th style="width:200px;">المسؤول</th>
                <th style="width:140px;">التاريخ</th>
              </tr>
            </thead>
            <tbody>
              @foreach($lead->notes->sortBy('created_at') as $n)
                <tr>
                  <td class="small muted">{{ $n->id }}</td>
                  <td>{{ $n->note }}</td>
                  <td>{{ ['private'=>'خاص','team'=>'الفريق','public'=>'عام'][$n->visibility] ?? $n->visibility }}</td>
                  <td class="ltr small">{{ $n->admin->email ?? '—' }}</td>
                  <td class="ltr small">{{ $n->created_at?->format('Y-m-d H:i') }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        @endif
      </div>
    </div>

    {{-- السجل الزمني --}}
    <div class="section">
      <div class="card">
        <h3>السجل الزمني</h3>
        @php $logs = ($logs ?? collect()); @endphp
        @if($logs->isEmpty())
          <div class="muted">لا توجد سجلات.</div>
        @else
          <table>
            <thead>
              <tr>
                <th style="width:60px;">#</th>
                <th style="width:140px;">التاريخ</th>
                <th style="width:110px;">العملية</th>
                <th style="width:140px;">الجدول</th>
                <th style="width:90px;">السجل</th>
                <th style="width:200px;">بواسطة</th>
                <th>تفاصيل</th>
              </tr>
            </thead>
            <tbody>
              @foreach($logs as $lg)
                <tr>
                  <td class="small muted">{{ $lg->id }}</td>
                  <td class="ltr small">{{ $lg->created_at?->timezone(config('app.timezone'))->format('Y-m-d H:i') }}</td>
                  <td>{{ $lg->action }}</td>
                  <td>{{ $lg->table_name ?: '—' }}</td>
                  <td>{{ $lg->record_id ?: '—' }}</td>
                  <td class="ltr small">{{ optional($lg->actorAdmin)->email ?? '—' }}</td>
                  <td class="small prelike ltr">{{ json_encode($lg->meta, JSON_UNESCAPED_UNICODE) }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        @endif
      </div>
    </div>
  </main>
</body>
</html>
