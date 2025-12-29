@props([
    'options' => [],
])

@php
    $enabled = function (array $keys) use ($options) {
        foreach ($keys as $key) {
            $v = data_get($options, $key);

            if (is_bool($v) && $v) return true;
            if (is_numeric($v) && (int)$v === 1) return true;

            $s = strtolower(trim((string)$v));
            if (in_array($s, ['1','true','on','yes'], true)) return true;
        }
        return false;
    };

    $cols = [];

    if ($enabled(['sig_gm','sig_general_manager','sig_gm_manager'])) $cols[] = 'المدير العام';
    if ($enabled(['sig_fm','sig_finance_manager'])) $cols[] = 'المدير المالي';
    if ($enabled(['sig_auditor','sig_financial_auditor'])) $cols[] = 'المراجع المالي';
    if ($enabled(['sig_accountant'])) $cols[] = 'المحاسب';
@endphp

@if(count($cols))
    {{-- ✅ print-only فقط --}}
    <div class="mt-4 print-only">
        <table class="table table-bordered" style="width:100%;background:#fff">
            <tr>
                @foreach($cols as $label)
                    <td style="height:90px;vertical-align:bottom;font-weight:600">
                        {{ $label }}
                    </td>
                @endforeach
            </tr>
        </table>
    </div>
@endif
