@props([
    'company' => [],
    'options' => [],
])

<div class="header-section print-only">
    <div class="right info">
        <p><strong>{{ $company['shopName'] ?? '' }}</strong></p>

        @if(!empty($options['show_address']))
            <p>{{ $company['shopAddr'] ?? '' }}</p>
        @endif

        @if(!empty($options['show_phone']))
            <p>{{ $company['shopPhone'] ?? '' }}</p>
        @endif

        @if(!empty($options['show_email']))
            <p>{{ $company['shopEmail'] ?? '' }}</p>
        @endif

        @if(!empty($company['vatRegNo']))
            <p>VAT: {{ $company['vatRegNo'] }}</p>
        @endif

        @if(!empty($company['taxNo']))
            <p>Tax No: {{ $company['taxNo'] }}</p>
        @endif
    </div>

    <div class="logo">
        @if(!empty($options['show_company_logo']) && !empty($company['shopLogo']))
            <img class="logo-img" src="{{ asset('storage/app/public/business/'.$company['shopLogo']) }}" alt="logo">
        @endif
    </div>

    <div class="left info">
        {{ $slot }}
    </div>
    
</div>
