@extends('layouts.admin.app')

@section('content')

<style>
    .header-section{margin-bottom:30px;padding:25px;background:#fff;border-radius:10px;border-bottom:5px solid #343a40;box-shadow:0 4px 6px rgba(0,0,0,.08)}
    table{width:100%;margin-bottom:20px;background:#fff;border-radius:10px;overflow:hidden}
    th,td{padding:15px 25px;text-align:right}
    thead{background:#f0f4f8}
    .no-print{display:block}
    .print-only{display:none}

    @media print{
        *{-webkit-print-color-adjust:exact}
        .no-print{display:none !important}
        .print-only{display:block !important}
        body{font-size:15px;margin:10mm;background:#fff}
        table,th,td{padding:12px !important}
        .btn{display:none !important}
    }
</style>

@php
    // reportOptions جاي من الكنترولر (أفضل)، ولو مش جاي نبنيه من الريكوست
    $reportOptions = $reportOptions ?? app(\App\Services\ReportOptionsService::class)->fromRequest(request());

    // هل التقرير اتطلب عرضه؟
    $isPreview = request()->boolean('preview');

    /**
     * ✅ Format money without negative display (UI only)
     * - If value < 0 => show 0.00
     * - Otherwise => normal format
     */
    $fmt = function($value, $decimals = 2) {
        $v = (float) ($value ?? 0);
        $v = abs($v); // ✅ السالب يتحول لموجب بدل 0
        return number_format($v, $decimals);
    };
@endphp

<div class="container">

    {{-- Breadcrumb يظهر فقط في preview --}}
    @if($isPreview)
        <x-breadcrumb title="{{ \App\CPU\translate('تقرير قائمة الدخل') }}" />
    @endif

    @if($isPreview)
        {{-- ✅ Actions تظهر فقط في preview (زي طلبك) --}}
        <x-actions />
    @endif

    {{-- ✅ الفلاتر تظهر فقط لو مش preview --}}
    @if(! $isPreview)

        <x-report.filters
            title="{{ \App\CPU\translate('قائمة الدخل') }}"
            :options="$reportOptions"
        />

        <div class="alert alert-info no-print">
            برجاء تحديد الفلاتر ثم الضغط على عرض.
        </div>

    @else

        <div id="printableArea">

            {{-- Header حسب خيارات ملف الشركة --}}
            <x-print-header :options="$reportOptions" />

            <table id="excel-table" class="table">

                {{-- الإيرادات --}}
                <thead>
                    <tr class="bg-info text-white">
                        <th colspan="3">الإيرادات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($revenuesData ?? [] as $revenue)
                        @php $revAcc = $revenue['account'] ?? null; @endphp
                        <tr>
                            <td>{{ $revAcc?->account ?? '-' }}</td>
                            <td>{{ $fmt($revenue['lastBalance'] ?? 0) }}</td>
                            <td></td>
                        </tr>
                    @endforeach

                    <tr class="font-weight-bold">
                        <td>إجمالي الإيرادات</td>
                        <td>{{ $fmt($totalRevenues ?? 0) }}</td>
                        <td></td>
                    </tr>
                </tbody>

                {{-- COGS --}}
                <thead>
                    <tr class="bg-warning text-dark">
                        <th colspan="3">تكلفة البضاعة المباعة</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $cogsAccount?->account ?? '-' }}</td>
                        <td>{{ $fmt($cogsLastBalance ?? 0) }}</td>
                        <td></td>
                    </tr>

                    <tr class="bg-light font-weight-bold">
                        <td>إجمالي الأرباح</td>
                        <td>{{ $fmt($grossProfit ?? 0) }}</td>
                        <td></td>
                    </tr>
                </tbody>

                {{-- OPEX --}}
                <thead>
                    <tr class="bg-danger text-white">
                        <th colspan="3">المصروفات التشغيلية</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $opexAccount?->account ?? '-' }}</td>
                        <td>{{ $fmt($totalOpex ?? 0) }}</td>
                        <td></td>
                    </tr>

                    <tr class="bg-light font-weight-bold">
                        <td>الدخل قبل المصروفات غير التشغيلية</td>
                        <td>{{ $fmt($incomeBeforeNonOpEx ?? 0) }}</td>
                        <td></td>
                    </tr>
                </tbody>

                {{-- Non OpEx --}}
                <thead>
                    <tr class="bg-secondary text-white">
                        <th colspan="3">المصروفات غير التشغيلية</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $nonOpExAccount?->account ?? '-' }}</td>
                        <td>{{ $fmt($totalNonOpEx ?? 0) }}</td>
                        <td></td>
                    </tr>

                    <tr class="bg-light font-weight-bold">
                        <td>الدخل بعد المصروفات غير التشغيلية</td>
                        <td>{{ $fmt($incomeAfterNonOpEx ?? 0) }}</td>
                        <td></td>
                    </tr>
                </tbody>

            </table>

            {{-- التوقيعات داخل التقرير --}}
    <x-report.signatures :options="$reportOptions" :showOnScreen="true" />
        </div>

    @endif

</div>

@endsection

{{-- سكربتات التقرير مرة واحدة --}}
<x-report.scripts />
