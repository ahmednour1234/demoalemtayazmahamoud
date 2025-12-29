@props([
    'title' => 'قائمة الدخل',
    'action' => null,
    'options' => [],
])

@php
    $action = $action ?? url()->current();

    $basis = $options['report_basis'] ?? request('report_basis', 'general');
    $level = $options['account_level'] ?? request('account_level', 1);

    $start = $options['start_date'] ?? request('start_date');
    $end   = $options['end_date']   ?? request('end_date');

    $withOpening = $options['with_opening_balance'] ?? request()->boolean('with_opening_balance');
    $showFirst   = $options['show_first_income'] ?? request()->boolean('show_first_income');

    $id = 'reportFilters_' . uniqid();
@endphp

<style>
    .rf-card{background:#fff;border-radius:10px;box-shadow:0 6px 18px rgba(0,0,0,.06);border:1px solid #eef1f6;overflow:hidden}
    .rf-head{display:flex;align-items:center;justify-content:space-between;padding:12px 16px;background:#f7fbff;border-bottom:1px solid #e7eef9}
    .rf-head .rf-title{display:flex;align-items:center;gap:10px;font-weight:700;color:#1e3a8a}
    .rf-head .rf-title i{font-size:18px}
    .rf-section{border-bottom:1px solid #f0f2f7}
    .rf-section:last-child{border-bottom:none}
    .rf-section-btn{
        width:100%;display:flex;align-items:center;justify-content:space-between;
        padding:12px 16px;background:#fff;border:0;cursor:pointer
    }
    .rf-section-btn .label{display:flex;align-items:center;gap:10px;color:#1f2937;font-weight:700}
    .rf-section-btn .label .tag{
        background:#eaf2ff;color:#1d4ed8;font-weight:700;border-radius:8px;padding:2px 8px;font-size:12px
    }
    .rf-section-btn .icon{display:flex;align-items:center;gap:8px;color:#6b7280}
    .rf-section-body{padding:14px 16px;background:#fbfdff}
    .rf-grid{display:grid;grid-template-columns:repeat(12,1fr);gap:12px}
    .rf-col-12{grid-column:span 12}
    .rf-col-6{grid-column:span 6}
    .rf-col-4{grid-column:span 4}
    .rf-col-3{grid-column:span 3}
    .rf-col-8{grid-column:span 8}

    @media (max-width: 992px){
        .rf-col-6,.rf-col-4,.rf-col-3,.rf-col-8{grid-column:span 12}
    }

    .rf-label{font-weight:700;color:#374151;margin-bottom:6px}
    .rf-radio-wrap{display:flex;gap:18px;flex-wrap:wrap;align-items:center}
    .rf-radio{
        display:flex;align-items:center;gap:8px;
        padding:8px 10px;border:1px solid #e5e7eb;border-radius:10px;background:#fff
    }
    .rf-radio input{margin:0}
    .rf-check{display:flex;align-items:center;gap:10px;padding:10px 12px;border:1px dashed #dbeafe;background:#eff6ff;border-radius:12px}
    .rf-check input{margin:0}
    .rf-actions{padding:14px 16px;background:#fff;border-top:1px solid #eef2f7}
    .rf-mini-note{font-size:12px;color:#6b7280;margin-top:4px}
</style>

<div class="rf-card no-print">
    {{-- Header --}}
    <div class="rf-head">
        <div class="rf-title">
            <i class="tio-file-text"></i>
            <span>{{ $title }}</span>
        </div>
        <div class="text-muted" style="font-weight:700;">
            {{ \App\CPU\translate('إعدادات التقرير') }}
        </div>
    </div>

    <form method="GET" action="{{ $action }}">
        <input type="hidden" name="preview" value="1">

        {{-- ===================== Section: نوع البيان + الفترة ===================== --}}
        <div class="rf-section">
            <button type="button"
                    class="rf-section-btn"
                    data-toggle="collapse"
                    data-target="#{{ $id }}_main">
                <div class="label">
                    <span>قائمة الدخل</span>
                    <span class="tag">Filters</span>
                </div>
                <div class="icon">
                    <span class="text-muted"> </span>
                    <i class="tio-chevron-down"></i>
                </div>
            </button>

            <div id="{{ $id }}_main" class="collapse show">
                <div class="rf-section-body">

                    <div class="rf-grid">
                        {{-- نوع البيان --}}
                        <div class="rf-col-12">
                            <div class="rf-label">نوع البيان</div>

                            <div class="rf-radio-wrap">
                                <label class="rf-radio">
                                    <input type="radio" name="report_basis" value="general" {{ $basis==='general'?'checked':'' }}>
                                    <span>بناء على الحسابات العامة</span>
                                </label>

                                <label class="rf-radio">
                                    <input type="radio" name="report_basis" value="accounts" {{ $basis==='accounts'?'checked':'' }}>
                                    <span>بناء على الحسابات</span>
                                </label>

                                <label class="rf-radio">
                                    <input type="radio" name="report_basis" value="level" {{ $basis==='level'?'checked':'' }}>
                                    <span>رمز مستوى الحساب</span>
                                </label>

                                <div style="min-width:180px;">
                                    <select name="account_level" class="form-control">
                                        @for($i=1;$i<=10;$i++)
                                            <option value="{{ $i }}" {{ (int)$level===$i?'selected':'' }}>مستوى {{ $i }}</option>
                                        @endfor
                                    </select>
                                    <div class="rf-mini-note">يُستخدم فقط عند اختيار "رمز مستوى الحساب"</div>
                                </div>
                            </div>
                        </div>

                        {{-- الفترة --}}
                        <div class="rf-col-6">
                            <div class="rf-label">الفترة من</div>
                            <input type="date" name="start_date" class="form-control" value="{{ $start }}" required>
                        </div>

                        <div class="rf-col-6">
                            <div class="rf-label">إلى</div>
                            <input type="date" name="end_date" class="form-control" value="{{ $end }}" required>
                        </div>

                        {{-- خيارات --}}
                        <div class="rf-col-6">
                            <label class="rf-check">
                                <input type="checkbox" name="with_opening_balance" value="1" {{ $withOpening?'checked':'' }}>
                                <span style="font-weight:700">مع الرصيد الافتتاحي</span>
                            </label>
                        </div>

                        <div class="rf-col-6">
                            <label class="rf-check">
                                <input type="checkbox" name="show_first_income" value="1" {{ $showFirst?'checked':'' }}>
                                <span style="font-weight:700">عرض الدخل الأول</span>
                            </label>
                        </div>

                    </div>

                </div>
            </div>
        </div>

        {{-- ===================== Section: ملف الشركة ===================== --}}
        <div class="rf-section">
            <button type="button"
                    class="rf-section-btn"
                    data-toggle="collapse"
                    data-target="#{{ $id }}_company">
                <div class="label">
                    <span>ملف الشركة</span>
                </div>
                <div class="icon">
                    <i class="tio-chevron-down"></i>
                </div>
            </button>

            <div id="{{ $id }}_company" class="collapse show">
                <div class="rf-section-body">
                    <x-report.company-options :options="$options" />
                </div>
            </div>
        </div>

        {{-- ===================== Section: عرض التوقيع ===================== --}}
        <div class="rf-section">
            <button type="button"
                    class="rf-section-btn"
                    data-toggle="collapse"
                    data-target="#{{ $id }}_sign">
                <div class="label">
                    <span>عرض التوقيع</span>
                </div>
                <div class="icon">
                    <i class="tio-chevron-down"></i>
                </div>
            </button>

            <div id="{{ $id }}_sign" class="collapse show">
                <div class="rf-section-body">
                    <x-report.signature-options :options="$options" />
                </div>
            </div>
        </div>

        {{-- ===================== Actions ===================== --}}
        <div class="rf-actions">
            {{-- أزرارك: عرض / طباعة / اكسل ... --}}
            <x-actions title="{{ $title }}" />
        </div>
    </form>
</div>
