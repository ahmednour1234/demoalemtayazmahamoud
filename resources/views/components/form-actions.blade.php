@props([
    'submitText' => \App\CPU\translate('حفظ'),
    'resetText'  => \App\CPU\translate('الغاء'),
    'submitClass' => 'btn btn-primary px-4 py-2',
    'resetClass'  => 'btn btn-danger px-4 py-2',
    'align'       => 'end', // start | center | end
])

@php
    $justifyClass = match($align){
        'start'  => 'justify-content-start',
        'center' => 'justify-content-center',
        default  => 'justify-content-end',
    };
@endphp

<div class="row mt-4 g-2 {{ $justifyClass }}">
    <div class="col-auto">
        <button type="submit" class="{{ $submitClass }}">
            {{ $submitText }}
        </button>
    </div>

    <div class="col-auto">
        <button type="reset" class="{{ $resetClass }}">
            {{ $resetText }}
        </button>
    </div>
</div>
