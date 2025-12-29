@props([
    'accountText' => null,
    'rangeText' => null,
    'periodText' => null,
    'openingText' => null,
    'closingText' => null,
    'descriptionText' => null,
    'variant' => 'screen', // screen | print
])

<div class="filters-summary {{ $variant === 'screen' ? 'screen non-printable' : '' }}">
    <div class="row">
        @if($accountText)
            <div class="item"><span class="label">{{ __('الحساب') }}:</span> <span class="value">{{ $accountText }}</span></div>
        @endif

        @if($rangeText)
            <div class="item"><span class="label">{{ __('النطاق') }}:</span> <span class="value">{{ $rangeText }}</span></div>
        @endif

        @if($periodText)
            <div class="item"><span class="label">{{ __('الفترة') }}:</span> <span class="value">{{ $periodText }}</span></div>
        @endif

        @if($openingText)
            <div class="item"><span class="label">{{ __('الرصيد الافتتاحي') }}:</span> <span class="value">{{ $openingText }}</span></div>
        @endif

        @if($closingText)
            <div class="item"><span class="label">{{ __('رصيد الإقفال (صفحة)') }}:</span> <span class="value">{{ $closingText }}</span></div>
        @endif

        @if($descriptionText)
            <div class="item"><span class="label">{{ __('الوصف يحتوي') }}:</span> <span class="value">“{{ $descriptionText }}”</span></div>
        @endif
    </div>
</div>
