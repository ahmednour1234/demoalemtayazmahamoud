@extends('layouts.admin.app')

@section('title', \App\CPU\translate('إضافة أرصدة إفتتاحية'))

<style>
    :root{
        --c-bg:#f6f8ff; --c-line:#e9eef5; --c-soft:#fff; --rd:14px;
        --c-green:#16a34a; --c-blue:#2563eb; --c-red:#ef4444; --c-muted:#6b7280;
    }
    .page-wrap{direction:rtl}
    .ob-card{border:1px solid var(--c-line); border-radius:var(--rd); background:var(--c-soft); box-shadow:0 12px 28px -14px rgba(2,32,71,.12)}
    .ob-head{display:flex; align-items:center; justify-content:space-between; gap:12px; padding:14px 16px; border-bottom:1px solid var(--c-line); background:linear-gradient(180deg,#fff,#fafcff)}
    .ob-title{font-weight:600; font-size:18px}
    .date-chip{display:inline-flex; align-items:center; gap:8px; padding:6px 10px; border:1px dashed var(--c-line); border-radius:999px; background:#fff}
    .date-chip .dot{width:8px;height:8px;border-radius:999px;background:var(--c-blue)}
    .form-label.required::after{content:" *"; color:var(--c-red); font-weight:700; margin-right:4px}
    .hint{color:var(--c-muted); font-size:.85rem}
    .badge-soft{border:1px solid var(--c-line); background:#fff; border-radius:999px; padding:.25rem .6rem; font-weight:600}
    .input-group-text{background:#fff}
    .totals-pill{display:flex; align-items:center; gap:10px; padding:8px 12px; border:1px solid var(--c-line); border-radius:999px; background:#fff; font-weight:600}
    .totals-wrap{display:flex; flex-wrap:wrap; gap:10px}
    .btn-xs{padding:.25rem .5rem; font-size:.8rem; border-radius:8px}
</style>

@section('content')
<div class="content container-fluid page-wrap">

    <!-- Breadcrumb -->
    <x-breadcrumb :title="\App\CPU\translate('أرصدة افتتاحية')" />


    <div class="ob-card">
        <div class="ob-head">
            <div class="ob-title">{{ \App\CPU\translate('قيد الرصيد الافتتاحي') }}</div>
            <div class="date-chip">
                <span class="dot"></span>
                <span class="hint">{{ \App\CPU\translate('التاريخ') }}:</span>
                <strong id="dateChipText">{{ old('entry_date', \Carbon\Carbon::now()->format('Y') . '-01-01') }}</strong>
            </div>
        </div>

        <form action="{{ route('admin.account.store-payable') }}" method="post" id="openingBalanceForm" class="p-4" novalidate>
            @csrf

            <div class="row g-3 mb-1">
                <div class="col-lg-4">
                    <label for="entry_date" class="form-label required">{{ \App\CPU\translate('تاريخ القيد') }}</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="tio-calendar"></i></span>
                        <input type="date" name="entry_date" id="entry_date" class="form-control"
                               value="{{ old('entry_date', \Carbon\Carbon::now()->format('Y') . '-01-01') }}" required>
                    </div>
                    @error('entry_date') <small class="text-danger d-block mt-1">{{ $message }}</small> @enderror
                </div>
            </div>

            <div class="row g-4">
                {{-- رقم الحساب + اسم الحساب --}}
                <div class="col-lg-6">
                    <label for="account_code" class="form-label required">{{ \App\CPU\translate('رقم الحساب') }}</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="tio-hash"></i></span>
                        <input type="text" id="account_code" name="account_code" class="form-control"
                               list="accountsList" placeholder="{{ \App\CPU\translate('اكتب رقم الحساب') }}"
                               autocomplete="off" required value="{{ old('account_code') }}">
                        <input type="text" id="account_name_display" class="form-control"
                               placeholder="{{ \App\CPU\translate('اسم الحساب') }}" readonly tabindex="-1" style="max-width:55%">
                    </div>

                    <datalist id="accountsList">
                        @foreach ($accounts as $acc)
                            @php
                                $code = $acc['code'] ?? $acc['account_number'] ?? '';
                                $name = $acc['account'] ?? '';
                            @endphp
                            @if($code)
                                <option value="{{ $code }}">{{ $name }}</option>
                            @endif
                        @endforeach
                    </datalist>

                    <input type="hidden" name="account_id" id="account_id" value="{{ old('account_id') }}">
                    @error('account_id') <small class="text-danger d-block mt-1">{{ $message }}</small> @enderror

                    {{-- إجماليات الحساب --}}
                
                </div>

                {{-- مدين --}}
                <div class="col-lg-3">
                    <label for="debit" class="form-label">{{ \App\CPU\translate('مدين') }}</label>
                    <div class="input-group">
                        <span class="input-group-text badge-soft">{{ \App\CPU\translate('مدين') }}</span>
                        <input type="number" step="0.01" min="0" name="debit" id="debit"
                               class="form-control" placeholder="0.00" value="{{ old('debit') }}">
                    </div>
                    @error('debit') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                {{-- دائن --}}
                <div class="col-lg-3">
                    <label for="credit" class="form-label">{{ \App\CPU\translate('دائن') }}</label>
                    <div class="input-group">
                        <span class="input-group-text badge-soft">{{ \App\CPU\translate('دائن') }}</span>
                        <input type="number" step="0.01" min="0" name="credit" id="credit"
                               class="form-control" placeholder="0.00" value="{{ old('credit') }}">
                    </div>
                    @error('credit') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>
<x-form-actions
    :submitText="\App\CPU\translate('حفظ القيد')"
    :resetText="\App\CPU\translate('إلغاء')"
    align="end"
/>


        </form>
    </div>

</div>
@endsection

@php
    // ⚠️ تجهيز فهرس الحسابات في PHP ثم تحويله لـ JSON (بدون أي "const" داخل PHP)
    $accIndex = [];
    foreach ($accounts as $a) {
        $key = $a['code'] ?? ($a['account_number'] ?? null);
        if ($key) {
            $accIndex[$key] = [
                'id'   => $a['id'] ?? null,
                'name' => $a['account'] ?? ($a['name'] ?? ''),
            ];
        }
    }
@endphp

<script>
window.addEventListener('DOMContentLoaded', function () {
    // ✅ JSON جاهز من PHP
    const ACC_INDEX = @json($accIndex);

    const inputCode   = document.getElementById('account_code');
    const hiddenId    = document.getElementById('account_id');
    const nameDisplay = document.getElementById('account_name_display');
    const debitInput  = document.getElementById('debit');
    const creditInput = document.getElementById('credit');
    const form        = document.getElementById('openingBalanceForm');
    const entryDate   = document.getElementById('entry_date');
    const dateChip    = document.getElementById('dateChipText');

    const totalInEl   = document.getElementById('totalInValue');
    const totalOutEl  = document.getElementById('totalOutValue');
    const netEl       = document.getElementById('netValue');
    const btnToDebit  = document.getElementById('btnCopyToDebit');
    const btnToCredit = document.getElementById('btnCopyToCredit');
    const btnNetSide  = document.getElementById('btnNetToSide');

    if (entryDate && dateChip) {
        entryDate.addEventListener('input', () => dateChip.textContent = entryDate.value || '');
    }

    function format(n){
        const v = parseFloat(n || 0);
        return Number.isFinite(v) ? v.toFixed(2) : '0.00';
    }

    function setTotals({total_in=0,total_out=0}={}){
        const tin  = parseFloat(total_in)  || 0;
        const tout = parseFloat(total_out) || 0;
        totalInEl.textContent  = format(tin);
        totalOutEl.textContent = format(tout);
        netEl.textContent      = format(tin - tout);
    }

    async function fetchTotals(accountId){
        if(!accountId){ setTotals({total_in:0,total_out:0}); return; }
        try{
            const url = "{{ route('admin.accounts.totals') }}" + "?id=" + encodeURIComponent(accountId);
            const res = await fetch(url, {headers:{'Accept':'application/json'}});
            if(!res.ok) throw new Error('HTTP '+res.status);
            const data = await res.json();
            if (data && data.success) {
                setTotals({total_in: data.total_in, total_out: data.total_out});
            } else {
                setTotals({total_in:0,total_out:0});
            }
        }catch(e){
            console.warn('Totals fetch error:', e);
            setTotals({total_in:0,total_out:0});
        }
    }

    function updateAccountFields() {
        const code = (inputCode.value || '').trim();
        const acc  = ACC_INDEX[code] || null;
        if (acc) {
            hiddenId.value    = acc.id || '';
            nameDisplay.value = acc.name || '';
            fetchTotals(acc.id);
        } else {
            hiddenId.value    = '';
            nameDisplay.value = '';
            setTotals({total_in:0,total_out:0});
        }
    }

    ['input','change','blur','keyup'].forEach(evt => {
        inputCode.addEventListener(evt, updateAccountFields);
    });

    // أزرار النسخ
    btnToDebit?.addEventListener('click', () => {
        debitInput.value = totalInEl.textContent.replace(/,/g,'');
        creditInput.value = '';
    });
    btnToCredit?.addEventListener('click', () => {
        creditInput.value = totalOutEl.textContent.replace(/,/g,'');
        debitInput.value = '';
    });
    btnNetSide?.addEventListener('click', () => {
        const net = parseFloat(netEl.textContent || 0);
        if (net > 0) {
            debitInput.value = net.toFixed(2); creditInput.value = '';
        } else if (net < 0) {
            creditInput.value = Math.abs(net).toFixed(2); debitInput.value = '';
        } else {
            debitInput.value = ''; creditInput.value = '';
        }
    });

    // السماح بحقل واحد فقط
    debitInput.addEventListener('input', function () { if (parseFloat(this.value || 0) > 0) creditInput.value = '' });
    creditInput.addEventListener('input', function () { if (parseFloat(this.value || 0) > 0) debitInput.value = '' });

    // تحقق قبل الإرسال
    form.addEventListener('submit', function (e) {
        const debit  = parseFloat(debitInput.value  || 0);
        const credit = parseFloat(creditInput.value || 0);

        if (!hiddenId.value) {
            e.preventDefault();
            alert('من فضلك اختر رقم حساب صحيح من القائمة.');
            return;
        }
        if (!entryDate.value) {
            e.preventDefault();
            alert('من فضلك اختر تاريخ القيد.');
            return;
        }
       
    });

    // تعبئة أولية لو فيه قيمة قديمة
    updateAccountFields();
});
</script>
