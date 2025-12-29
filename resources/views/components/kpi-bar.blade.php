@props([
  'openingBalance' => 0,
  'pageDebit' => 0,
  'pageCredit' => 0,
  'netMovement' => 0,
  'closingBalance' => 0,
  'formatMoney' => null, // callable
  'sideLabel' => null,   // callable
])

@php
  $fmt = $formatMoney ?: fn($n)=> number_format((float)$n,2);
  $side = $sideLabel ?: function($v){ return $v>0?__('مدين'):($v<0?__('دائن'):__('متزن')); };
@endphp

<div class="toolbar non-printable">
    <div class="kpi">
        <div class="item">
            <div class="title">{{ __('الرصيد الافتتاحي') }} ({{ $side($openingBalance) }})</div>
            <div class="value {{ $openingBalance>=0 ? 'dr':'cr' }}">{{ $fmt(abs($openingBalance)) }}</div>
        </div>
        <div class="item">
            <div class="title">{{ __('إجمالي مدين (الصفحة)') }}</div>
            <div class="value dr">{{ $fmt($pageDebit) }}</div>
        </div>
        <div class="item">
            <div class="title">{{ __('إجمالي دائن (الصفحة)') }}</div>
            <div class="value cr">{{ $fmt($pageCredit) }}</div>
        </div>
        <div class="item">
            <div class="title">{{ __('صافي الحركة (الصفحة)') }} ({{ $side($netMovement) }})</div>
            <div class="value {{ $netMovement>=0 ? 'dr':'cr' }}">{{ $fmt(abs($netMovement)) }}</div>
        </div>
        <div class="item">
            <div class="title">{{ __('رصيد الإقفال (افتتاحي + حركة الصفحة)') }} ({{ $side($closingBalance) }})</div>
            <div class="value {{ $closingBalance>=0 ? 'dr':'cr' }}">{{ $fmt(abs($closingBalance)) }}</div>
        </div>
    </div>
</div>
