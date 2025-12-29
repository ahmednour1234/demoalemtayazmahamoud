{{-- resources/views/admin-views/accounts/statement.blade.php --}}
@extends('layouts.admin.app')

@section('title', __('كشف حساب'))

@section('content')
@php
    use Carbon\Carbon;

    // هل المستخدم فعّل أي فلتر؟
    $hasSearch = request('account_id')
        || request('account_from')
        || request('account_to')
        || request('from_date')
        || request('to_date')
        || request('description');

    // هل توجد نتائج؟
    $hasRows = isset($rows) && $rows->count() > 0;

    // للحالات التي قد لا يمرر فيها الكنترولر القيم
    $pageDebit       = isset($pageDebit)       ? (float)$pageDebit       : ($hasRows ? (float)$rows->sum('debit')  : 0.0);
    $pageCredit      = isset($pageCredit)      ? (float)$pageCredit      : ($hasRows ? (float)$rows->sum('credit') : 0.0);
    $openingBalance  = isset($openingBalance)  ? (float)$openingBalance  : 0.0;
    $runningStart    = isset($runningStart)    ? (float)$runningStart    : $openingBalance;

    // صافي الحركة (للصفحة الحالية فقط) + رصيد الإقفال (افتتاحي + حركة الصفحة)
    $netMovement     = $pageDebit - $pageCredit;                 // (+) مدين / (-) دائن
    $closingBalance  = $openingBalance + $netMovement;           // (+) مدين / (-) دائن

    // دوال مساعدة بسيطة لتنسيق عرض (مدين/دائن)
    $formatMoney = fn($n) => number_format((float)$n, 2);
    $sideLabel   = function ($val) {
        if ($val > 0)  return __('مدين');
        if ($val < 0)  return __('دائن');
        return __('متزن');
    };

    // خرائط لأسماء الكيانات لعرض أسماء الفلاتر
    $accountsMap   = $accounts->keyBy('id');

    // إعدادات المتجر للترويسة المطبوعة
    $settings = \App\Models\BusinessSetting::whereIn('key', [
        'shop_name','shop_address','shop_phone','shop_email','shop_logo','vat_reg_no','number_tax'
    ])->pluck('value','key');

    $shopName   = $settings['shop_name']    ?? '';
    $shopAddr   = $settings['shop_address'] ?? '';
    $shopPhone  = $settings['shop_phone']   ?? '';
    $shopEmail  = $settings['shop_email']   ?? '';
    $shopLogo   = $settings['shop_logo']    ?? '';
    $crNo       = $settings['vat_reg_no']   ?? ''; // رقم السجل التجاري
    $taxNo      = $settings['number_tax']   ?? ''; // الرقم الضريبي

    // بداية ترقيم الصفوف وفق ترقيم الصفحات
    $rowStart = ($hasRows && $rows instanceof \Illuminate\Pagination\LengthAwarePaginator)
        ? ($rows->currentPage() - 1) * $rows->perPage() + 1
        : 1;

    // الفترة المطلوبة للطباعة
    $fromDate = request('from_date') ?: '—';
    $toDate   = request('to_date')   ?: '—';

    // تاريخ/وقت الطباعة (حسب Timezone التطبيق)
    $printAt  = Carbon::now()->timezone(config('app.timezone', 'Africa/Cairo'))->format('Y-m-d H:i');
@endphp

@php
    // ✅ تجميع إعدادات المتجر مرة واحدة بدل 6 queries كل مرة
    $bs = \App\Models\BusinessSetting::whereIn('key', [
        'vat_reg_no','number_tax','shop_email','shop_logo','shop_name','shop_address','shop_phone'
    ])->pluck('value','key');

    $vatRegNo   = $bs['vat_reg_no'] ?? '';
    $taxNo      = $bs['number_tax'] ?? '';
    $shopEmail  = $bs['shop_email'] ?? '';
    $shopLogo   = $bs['shop_logo'] ?? '';
    $shopName   = $bs['shop_name'] ?? '';
    $shopAddr   = $bs['shop_address'] ?? '';
    $shopPhone  = $bs['shop_phone'] ?? '';
@endphp
{{-- Select2 + XLSX --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js" defer></script>

<style>
    :root{
        --c-bg:#f6f8ff; --c-line:#eef2f7; --c-soft:#fbfdff; --c-dash:#dbe2ea;
        --c-green:#10b981; --c-red:#ef4444; --c-blue:#2563eb;
        --rd:14px;
    }
    .page-wrap{direction:rtl}
    .breadcrumb{border:1px solid var(--c-line)}
    .filter-card{border:1px solid var(--c-line);border-radius:var(--rd)}
    .card.shadowed{box-shadow:0 10px 25px -10px rgba(2, 32, 71, .12);border:1px solid var(--c-line);border-radius:var(--rd)}
    .toolbar{position:sticky;top:64px;z-index:6;background:#fff;border:1px solid var(--c-line);border-radius:12px;padding:12px}
    .kpi{display:flex;gap:10px;flex-wrap:wrap}
    .kpi .item{background:#fff;border:1px solid var(--c-line);border-radius:12px;padding:10px 12px;min-width:190px}
    .kpi .item .title{font-size:.875rem;color:#374151}
    .kpi .item .value{font-weight:800;font-size:1.05rem}
    .kpi .dr{color:var(--c-green)}
    .kpi .cr{color:var(--c-red)}
    .empty-state{border:1px dashed var(--c-dash);border-radius:var(--rd);padding:22px;background:var(--c-soft)}
    .btn-gap > *{margin-inline-start:.5rem}

    .table thead th{position:sticky;top:0;background:var(--c-bg);z-index:2}
    table.table{border-color:var(--c-line)}
    table.table tbody tr:nth-child(even){background:#fcfdff}
    table.table tbody tr:hover{background:#f3f7ff}
    td,th{vertical-align:middle}

    .amount-debit{color:var(--c-green);font-weight:700}
    .amount-credit{color:var(--c-red);font-weight:700}

    tfoot tr td{background:#fff;border-top:2px solid var(--c-line) !important}
    tfoot .tfoot-title{font-weight:700}

    .select2-container--default .select2-selection--single{
        height:38px;border-color:var(--c-line)
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered{line-height:36px}
    .select2-container--default .select2-selection--single .select2-selection__arrow{height:36px}

    .signatures{ display:none; }

    /* --- عناصر خاصة بالطباعة --- */
    @media print{
        @page{
            size: A8; /* يمكن تغييره لـ A4 حسب الحاجة */
            margin: 14mm 10mm 20mm 10mm;
        }
        body * { visibility: hidden !important; }
        #print-area, #print-area * { visibility: visible !important; }
        #print-area { position:absolute; inset:0; width:100%; }

        table { page-break-inside:auto; border-collapse: collapse; width:100%;}
        thead { display: table-header-group; }
        tfoot { display: table-row-group; }
        tr    { page-break-inside: avoid; page-break-after: auto; }

        .non-printable{ display:none !important; }

        .print-header{
            display:block !important;
            margin-bottom:12px;
            border-bottom:2px solid #000;
            padding-bottom:10px;
            font-size:13px;
            color:#000;
        }
        .print-header .header-section{
            display:flex; align-items:center; justify-content:space-between; gap:16px;
        }
        .print-header .left, .print-header .right{
            width:32%;
        }
        .print-header .logo{ width:36%; text-align:center; }
        .print-header .logo img{ max-width:150px; height:auto; }

        .print-title{
            text-align:center; font-size:18px; font-weight:700; margin:8px 0 6px;
        }

        .filters-summary{
            border:1px solid #000; border-radius:8px; padding:8px 10px; margin:6px 0 12px;
            font-size:12px;
        }
        .filters-summary .row{ display:flex; flex-wrap:wrap; gap:8px 16px; }
        .filters-summary .item{ min-width:180px; }
        .filters-summary .label{ font-weight:700; }

        .print-footer{
            position: fixed;
            bottom: 8mm;
            left: 10mm;
            right: 10mm;
            font-size: 12px;
            display:flex;
            align-items:center;
            justify-content:space-between;
            border-top:1px dashed #000;
            padding-top:6px;
        }

        .signatures{
            display:grid; grid-template-columns: repeat(4,1fr); gap:12px; margin-top:14px;
        }
        .signatures .box{
            border:1px solid #000; border-radius:8px; height:80px; padding:8px; font-size:12px;
            display:flex; flex-direction:column; justify-content:space-between;
        }
        .signatures .title{ font-weight:700; }
        .signatures .line{ border-top:1px dashed #000; height:1px; margin-top:6px; }
    }

    .print-header{ display:none; }

    .filters-summary.screen{
        border:1px dashed var(--c-dash); background:#fff; padding:10px 12px; border-radius:10px; margin-bottom:12px;
    }
    .filters-summary .row{ display:flex; flex-wrap:wrap; gap:8px 16px; }
    .filters-summary .item .label{ font-weight:700; color:#111827; }
    .filters-summary .item .value{ color:#374151; }
</style>

<div class="container-fluid page-wrap">

    {{-- Breadcrumb --}}
      <x-breadcrumb :title="\App\CPU\translate('تقرير كشف حساب ')" />


    {{-- الفلاتر --}}
    <div class="card filter-card shadow-sm mb-3 non-printable">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.account.statement') }}" class="row g-3">

          
                {{-- من حساب --}}
                <div class="col-md-3">
                    <label class="form-label">{{ __('من حساب (اختياري)') }}</label>
                    <select name="account_from" id="account_from" class="form-control select2-account" data-placeholder="—">
                        <option value=""></option>
                        @foreach($accounts as $a)
                            <option value="{{ $a->id }}" @selected(request('account_from')==$a->id)
                                data-name="{{ $a->account }}" data-code="{{ $a->code }}">
                                {{ $a->account }} @if($a->code) ({{ $a->code }}) @endif
                            </option>
                        @endforeach
                    </select>
                    <small class="text-muted">{{ __('يُستخدم مع "إلى حساب" فقط.') }}</small>
                </div>

                {{-- إلى حساب --}}
                <div class="col-md-3">
                    <label class="form-label">{{ __('إلى حساب (اختياري)') }}</label>
                    <select name="account_to" id="account_to" class="form-control select2-account" data-placeholder="—">
                        <option value=""></option>
                        @foreach($accounts as $a)
                            <option value="{{ $a->id }}" @selected(request('account_to')==$a->id)
                                data-name="{{ $a->account }}" data-code="{{ $a->code }}">
                                {{ $a->account }} @if($a->code) ({{ $a->code }}) @endif
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- من/إلى تاريخ --}}
                <div class="col-md-1">
                    <label class="form-label">{{ __('من تاريخ') }}</label>
                    <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
                </div>
                <div class="col-md-1">
                    <label class="form-label">{{ __('إلى تاريخ') }}</label>
                    <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
                </div>

                {{-- الوصف --}}
      

                {{-- أزرار --}}
                <div class="col-12 d-flex flex-wrap btn-gap mt-2">
                    <button class="btn btn-primary px-4">{{ __('تطبيق') }}</button>
                    <a href="{{ route('admin.account.statement') }}" class="btn btn-outline-secondary">{{ __('مسح') }}</a>

                    @if($hasSearch && $hasRows)
                        <button type="button" class="btn btn-info" onclick="exportTableToExcel('statementTable')">Excel</button>
                        <button type="button" class="btn btn-success" onclick="window.print()">{{ __('طباعة') }}</button>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- ملخّص الفلاتر (شاشة) --}}
        <div class="filters-summary screen non-printable">
            <div class="row">
                @if(request('account_id'))
                    <div class="item"><span class="label">{{ __('الحساب') }}:</span>
                        <span class="value">
                            {{ optional($accountsMap->get((int)request('account_id')))->account }}
                            @if(optional($accountsMap->get((int)request('account_id')))->code)
                                ({{ optional($accountsMap->get((int)request('account_id')))->code }})
                            @endif
                            @if(request('with_children')) — {{ __('شامل الفرعية') }} @endif
                        </span>
                    </div>
                @endif

                @if(request('account_from') || request('account_to'))
                    <div class="item"><span class="label">{{ __('النطاق') }}:</span>
                        <span class="value">
                            {{ request('account_from') ? optional($accountsMap->get((int)request('account_from')))->account : '—' }}
                            →
                            {{ request('account_to') ? optional($accountsMap->get((int)request('account_to')))->account : '—' }}
                        </span>
                    </div>
                @endif

                @if(request('from_date') || request('to_date'))
                    <div class="item"><span class="label">{{ __('الفترة') }}:</span>
                        <span class="value">{{ $fromDate }} → {{ $toDate }}</span>
                    </div>
                @endif

                @if(request('description'))
                    <div class="item"><span class="label">{{ __('الوصف يحتوي') }}:</span>
                        <span class="value">“{{ request('description') }}”</span>
                    </div>
                @endif
            </div>
        </div>

        {{-- شريط KPIs يعرِض الرصيد الافتتاحي والحركة ورصيد الإقفال (صفحة) --}}
        <div class="toolbar non-printable">
            <div class="kpi">
                <div class="item">
                    <div class="title">{{ __('الرصيد الافتتاحي') }} ({{ $sideLabel($openingBalance) }})</div>
                    <div class="value {{ $openingBalance>=0 ? 'dr':'cr' }}">
                        {{ $formatMoney(abs($openingBalance)) }}
                    </div>
                </div>
                <div class="item">
                    <div class="title">{{ __('إجمالي مدين (الصفحة)') }}</div>
                    <div class="value dr">{{ $formatMoney($pageDebit) }}</div>
                </div>
                <div class="item">
                    <div class="title">{{ __('إجمالي دائن (الصفحة)') }}</div>
                    <div class="value cr">{{ $formatMoney($pageCredit) }}</div>
                </div>
                <div class="item">
                    <div class="title">{{ __('صافي الحركة (الصفحة)') }} ({{ $sideLabel($netMovement) }})</div>
                    <div class="value {{ $netMovement>=0 ? 'dr':'cr' }}">
                        {{ $formatMoney(abs($netMovement)) }}
                    </div>
                </div>
                <div class="item">
                    <div class="title">{{ __('رصيد الإقفال (افتتاحي + حركة الصفحة)') }} ({{ $sideLabel($closingBalance) }})</div>
                    <div class="value {{ $closingBalance>=0 ? 'dr':'cr' }}">
                        {{ $formatMoney(abs($closingBalance)) }}
                    </div>
                </div>
            </div>
        </div>


    {{-- الحالة بدون فلاتر --}}
    @if(!$hasSearch)
        <div class="empty-state shadow-sm mb-4 non-printable">
            <h5 class="mb-2">{{ __('ابدأ بتحديد فلاتر البحث') }}</h5>
            <ul class="mb-0 text-muted">
                <li>{{ __('اختر حسابًا محددًا أو نطاق حسابات') }}</li>
                <li>{{ __('حدد فترة زمنية') }}</li>
                <li>{{ __('يمكنك تضييق النتائج بكلمة في الوصف') }}</li>
            </ul>
        </div>
    @else

        {{-- بحث بلا نتائج --}}
        @if(!$hasRows)
            <div class="empty-state shadow-sm mb-4 non-printable">
                <h5 class="mb-1">{{ __('لا توجد حركات مطابقة') }}</h5>
                <p class="mb-0 text-muted">{{ __('جرّب تغيير الفلاتر أو توسيع النطاق الزمني.') }}</p>
            </div>
        @else

            {{-- منطقة الطباعة: ترويسة + ملخص فلاتر (نسخة للطباعة) --}}
            <div id="print-area">
                <div class="print-header">
                         <x-print-header
            :vatRegNo="$vatRegNo"
            :taxNo="$taxNo"
            :shopEmail="$shopEmail"
            :shopLogo="$shopLogo"
            :shopName="$shopName"
            :shopAddr="$shopAddr"
            :shopPhone="$shopPhone"
        />


                    <div class="print-title">{{ __('كشف حساب') }}</div>

                    {{-- ملخص الفلاتر للطباعة + سطر الفترة (من → إلى) --}}
                    <div class="filters-summary">
                        <div class="row">
                            @if(request('account_id'))
                                <div class="item"><span class="label">{{ __('الحساب') }}:</span>
                                    <span class="value">
                                        {{ optional($accountsMap->get((int)request('account_id')))->account }}
                                        @if(optional($accountsMap->get((int)request('account_id')))->code)
                                            ({{ optional($accountsMap->get((int)request('account_id')))->code }})
                                        @endif
                                        @if(request('with_children')) — {{ __('شامل الفرعية') }} @endif
                                    </span>
                                </div>
                            @endif

                            @if(request('account_from') || request('account_to'))
                                <div class="item"><span class="label">{{ __('النطاق') }}:</span>
                                    <span class="value">
                                        {{ request('account_from') ? optional($accountsMap->get((int)request('account_from')))->account : '—' }}
                                        →
                                        {{ request('account_to') ? optional($accountsMap->get((int)request('account_to')))->account : '—' }}
                                    </span>
                                </div>
                            @endif

                            <div class="item">
                                <span class="label">{{ __('الفترة') }}:</span>
                                <span class="value">{{ $fromDate }} → {{ $toDate }}</span>
                            </div>

                            {{-- رصيد افتتاحي/إقفال للطباعة --}}
                            <div class="item">
                                <span class="label">{{ __('الرصيد الافتتاحي') }}:</span>
                                <span class="value">
                                    {{ $formatMoney(abs($openingBalance)) }} ({{ $sideLabel($openingBalance) }})
                                </span>
                            </div>
                            <div class="item">
                                <span class="label">{{ __('رصيد الإقفال (صفحة)') }}:</span>
                                <span class="value">
                                    {{ $formatMoney(abs($closingBalance)) }} ({{ $sideLabel($closingBalance) }})
                                </span>
                            </div>

                            @if(request('description'))
                                <div class="item"><span class="label">{{ __('الوصف يحتوي') }}:</span>
                                    <span class="value">“{{ request('description') }}”</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- الجدول --}}
                <div class="card shadowed">
                    <div class="table-responsive">
                        <table id="statementTable" class="table align-middle mb-0">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('التاريخ') }}</th>
                                <th>{{ __('المرجع') }}</th>
                                <th>{{ __('الحساب') }}</th>
                                <th>{{ __('البيان') }}</th>
                                <th>{{ __('مدين') }}</th>
                                <th>{{ __('دائن') }}</th>
                                <th class="non-printable">{{ __('عرض') }}</th>
                            </tr>
                            </thead>

                            <tbody>
                            @php
                                $running = $runningStart;
                                $i = $rowStart;
                            @endphp

                            {{-- صف رصيد افتتاحي (يُعرض إن كان غير صفر) --}}
                            @if($runningStart != 0)
                                <tr>
                                    <td>—</td>
                                    <td>{{ request('from_date') ?: '—' }}</td>
                                    <td>{{ __('رصيد افتتاحي') }}</td>
                                    <td>—</td>
                                    <td>{{ __('رصيد مرحّل لبداية الفترة') }}</td>
                                    <td class="amount-debit">{{ $runningStart > 0 ? $formatMoney($runningStart) : '0.00' }}</td>
                                    <td class="amount-credit">{{ $runningStart < 0 ? $formatMoney(abs($runningStart)) : '0.00' }}</td>
                                    <td class="non-printable">—</td>
                                </tr>
                            @endif

                            @foreach($rows as $r)
                                @php
                                    $running += ($r->debit - $r->credit);
                                @endphp
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ \Carbon\Carbon::parse($r->head_date)->format('Y-m-d') }}</td>
                                    <td>{{ $r->head_ref }}</td>
                                    <td>
                                        {{ $r->account->account ?? '—' }}
                                        @if(optional($r->account)->code)
                                            <small class="text-muted">({{ $r->account->code }})</small>
                                        @endif
                                    </td>
                                    <td>{{ $r->description ?: $r->head_desc }}</td>
                                    <td class="amount-debit">{{ $formatMoney($r->debit) }}</td>
                                    <td class="amount-credit">{{ $formatMoney($r->credit) }}</td>
                                    <td class="non-printable">
                                        <a class="btn btn-sm btn-white" href="{{ route('admin.journal-entries.show', $r->journal_entry_id) }}">
                                            {{ __('عرض') }}
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>

                            <tfoot>
                            <tr>
                                <td colspan="5" class="tfoot-title text-end">{{ __('الإجماليات (صفحة)') }}</td>
                                <td class="amount-debit">{{ $formatMoney($pageDebit) }}</td>
                                <td class="amount-credit">{{ $formatMoney($pageCredit) }}</td>
                                <td class="non-printable"></td>
                            </tr>
                            <tr>
                                <td colspan="5" class="text-end">{{ __('صافي الحركة (صفحة)') }} ({{ $sideLabel($netMovement) }})</td>
                                <td class="amount-debit">{{ $netMovement > 0 ? $formatMoney($netMovement) : '0.00' }}</td>
                                <td class="amount-credit">{{ $netMovement < 0 ? $formatMoney(abs($netMovement)) : '0.00' }}</td>
                                <td class="non-printable"></td>
                            </tr>
                            <tr>
                                <td colspan="5" class="text-end"><strong>{{ __('رصيد الإقفال (افتتاحي + حركة الصفحة)') }}</strong> ({{ $sideLabel($closingBalance) }})</td>
                                <td class="amount-debit"><strong>{{ $closingBalance > 0 ? $formatMoney($closingBalance) : '0.00' }}</strong></td>
                                <td class="amount-credit"><strong>{{ $closingBalance < 0 ? $formatMoney(abs($closingBalance)) : '0.00' }}</strong></td>
                                <td class="non-printable"></td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>

                    {{-- ترقيم --}}
                    @if($rows->hasPages())
                        <div class="card-footer non-printable">
                            {{ $rows->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>

                {{-- منطقة التوقيعات --}}
                <div class="signatures non-printable" style="display:none;"></div>
                <div class="signatures">
                    <div class="box">
                        <div class="title">{{ __('محاسب') }}</div>
                        <div class="line"></div>
                        <div>{{ __('الاسم/التوقيع') }}</div>
                    </div>
                    <div class="box">
                        <div class="title">{{ __('رئيس الحسابات') }}</div>
                        <div class="line"></div>
                        <div>{{ __('الاسم/التوقيع') }}</div>
                    </div>
                    <div class="box">
                        <div class="title">{{ __('المدير المالي') }}</div>
                        <div class="line"></div>
                        <div>{{ __('الاسم/التوقيع') }}</div>
                    </div>
                    <div class="box">
                        <div class="title">{{ __('توقيع العميل / صاحب الحساب') }}</div>
                        <div class="line"></div>
                        <div>{{ __('الاسم/التوقيع') }}</div>
                    </div>
                </div>

                {{-- فوتر الطباعة: تاريخ الطباعة + تكرار الفترة والتوازن --}}
                <div class="print-footer">
                    <div><strong>{{ __('الفترة') }}:</strong> {{ $fromDate }} → {{ $toDate }}</div>
                    <div>
                        <strong>{{ __('الافتتاحي') }}:</strong> {{ $formatMoney(abs($openingBalance)) }} ({{ $sideLabel($openingBalance) }})
                        &nbsp;|&nbsp;
                        <strong>{{ __('الإقفال (صفحة)') }}:</strong> {{ $formatMoney(abs($closingBalance)) }} ({{ $sideLabel($closingBalance) }})
                    </div>
                    <div><strong>{{ __('تاريخ الطباعة') }}:</strong> {{ $printAt }}</div>
                </div>
            </div>
        @endif
    @endif
</div>

@endsection

{{-- Export Excel --}}
<script>
function exportTableToExcel(tableId, filename = 'account_statement.xlsx') {
    const table = document.getElementById(tableId);
    if (!table) return;
    const wb = XLSX.utils.table_to_book(table, { sheet: "Statement" });
    XLSX.writeFile(wb, filename);
}
</script>

{{-- تهيئة Select2 مع قوالب تعرض الاسم + الكود والبحث عليهم --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    function accountTemplate (state) {
        if (!state.id) return state.text;
        const $opt = state.element;
        const name = $opt.getAttribute('data-name') || '';
        const code = $opt.getAttribute('data-code') || '';
        const label = code ? `${name} (${code})` : name;
        return label;
    }

    $('.select2-account').select2({
        width: '100%',
        dir: 'rtl',
        allowClear: true,
        placeholder: function(){ return $(this).data('placeholder') || '—'; },
        templateResult: accountTemplate,
        templateSelection: accountTemplate,
        matcher: function(params, data) {
            if ($.trim(params.term) === '') return data;
            if (typeof data.element === 'undefined') return null;

            const term = params.term.toLowerCase();
            const name = (data.element.getAttribute('data-name') || '').toLowerCase();
            const code = (data.element.getAttribute('data-code') || '').toLowerCase();
            const text = (data.text || '').toLowerCase();

            return (name.indexOf(term) > -1 || code.indexOf(term) > -1 || text.indexOf(term) > -1) ? data : null;
        }
    });

    $('.select2-basic').select2({
        width: '100%',
        dir: 'rtl',
        allowClear: true,
        placeholder: function(){ return $(this).data('placeholder') || '{{ __("الكل") }}'; }
    });
});
</script>
