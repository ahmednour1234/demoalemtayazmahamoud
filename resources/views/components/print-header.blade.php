@props([
    'options' => null, // reportOptions
])

@php
    $rc = $reportCompany ?? [];
    $company = $options['company'] ?? [];

    $showLogo    = $company['logo']    ?? true;
    $showCR      = $company['cr']      ?? true;
    $showTax     = $company['tax']     ?? true;
    $showEmail   = $company['email']   ?? true;
    $showAddr    = $company['address'] ?? true;
    $showPhone   = $company['phone']   ?? true;
    $showFax     = $company['fax']     ?? false;

    $shopName  = $rc['shopName']  ?? '';
    $vatRegNo  = $rc['vatRegNo']  ?? '';
    $taxNo     = $rc['taxNo']     ?? '';
    $shopEmail = $rc['shopEmail'] ?? '';
    $shopLogo  = $rc['shopLogo']  ?? '';
    $shopAddr  = $rc['shopAddr']  ?? '';
    $shopPhone = $rc['shopPhone'] ?? '';
@endphp

<div class="header-section print-only">
    <table style="width:100%;border:none;">
        <tr>
            <td style="width:33%;text-align:right;border:none;">
                <div class="info">
                    <p>{{ $shopName }}</p>

                    @if($showCR)
                        <p><strong>رقم السجل التجاري:</strong> {{ $vatRegNo }}</p>
                    @endif

                    @if($showTax)
                        <p><strong>الرقم الضريبي:</strong> {{ $taxNo }}</p>
                    @endif
                </div>
            </td>

            <td style="width:33%;text-align:center;border:none;">
                @if($showLogo && $shopLogo)
                    <img class="logo-img"
                         src="{{ asset('storage/app/public/shop/' . $shopLogo) }}"
                         style="max-width:200px;max-height:200px;"
                         alt="شعار المؤسسة">
                @endif
            </td>

            <td style="width:33%;text-align:left;border:none;">
                <div class="info">
                    @if($showAddr)
                        <p><strong>العنوان:</strong> {{ $shopAddr }}</p>
                    @endif

                    @if($showPhone)
                        <p><strong>رقم الجوال:</strong> {{ $shopPhone }}</p>
                    @endif

                    @if($showEmail)
                        <p><strong>البريد الإلكتروني:</strong> {{ $shopEmail }}</p>
                    @endif

                    @if($showFax)
                        <p><strong>فاكس:</strong> —</p>
                    @endif
                </div>
            </td>
        </tr>
    </table>
</div>
