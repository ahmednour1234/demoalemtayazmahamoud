@props([
    'printTarget' => 'printableArea',
    'excelTableId' => 'excel-table',
    'cancelUrl' => null,
    'showSearch' => true,
    'showPrint' => true,
    'showExcel' => true,
    'showCancel' => true,
])

@php
    $cancelUrl = $cancelUrl ?? url()->current();
@endphp

<div class="row mt-4">
    @if($showPrint)
        <div class="col-md-3 mb-2">
            <button type="button" onclick="printDiv('{{ $printTarget }}')" class="btn btn-primary w-100">
                {{ \App\CPU\translate('طباعة') }}
            </button>
        </div>
    @endif

    @if($showSearch)
        <div class="col-md-3 mb-2">
            <button type="submit" class="btn btn-success w-100">
                {{ \App\CPU\translate('بحث') }}
            </button>
        </div>
    @endif

    @if($showExcel)
        <div class="col-md-3 mb-2">
            <button type="button" onclick="exportTableToExcel('{{ $excelTableId }}')" class="btn btn-info w-100">
                {{ \App\CPU\translate('إصدار ملف أكسل') }}
            </button>
        </div>
    @endif

    @if($showCancel)
        <div class="col-md-3 mb-2">
            <a href="{{ $cancelUrl }}" class="btn btn-danger w-100">
                {{ \App\CPU\translate('إلغاء') }}
            </a>
        </div>
    @endif
</div>
