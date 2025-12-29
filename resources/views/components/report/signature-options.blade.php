@props(['options' => []])

@php
    $s = $options['signatures'] ?? [];
@endphp

<div class="border rounded p-3 mb-3">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <strong>عرض التوقيع</strong>
    </div>

    <div class="row">
        <div class="col-md-6 d-flex flex-column gap-2">
            <label class="d-flex align-items-center gap-2">
                <input type="checkbox" name="sig_general_manager" value="1" {{ ($s['general_manager'] ?? request()->boolean('sig_general_manager')) ? 'checked':'' }}>
                <span>المدير العام</span>
            </label>

            <label class="d-flex align-items-center gap-2">
                <input type="checkbox" name="sig_finance_manager" value="1" {{ ($s['finance_manager'] ?? request()->boolean('sig_finance_manager')) ? 'checked':'' }}>
                <span>المدير المالي</span>
            </label>
        </div>

        <div class="col-md-6 d-flex flex-column gap-2">
            <label class="d-flex align-items-center gap-2">
                <input type="checkbox" name="sig_financial_auditor" value="1" {{ ($s['financial_auditor'] ?? request()->boolean('sig_financial_auditor')) ? 'checked':'' }}>
                <span>المراجع المالي</span>
            </label>

            <label class="d-flex align-items-center gap-2">
                <input type="checkbox" name="sig_accountant" value="1" {{ ($s['accountant'] ?? request()->boolean('sig_accountant')) ? 'checked':'' }}>
                <span>المحاسب</span>
            </label>
        </div>
    </div>
</div>
