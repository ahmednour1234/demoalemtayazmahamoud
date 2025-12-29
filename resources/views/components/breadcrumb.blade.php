@props([
    'title' => '',
    'items' => [], // each: ['label' => '', 'url' => '', 'icon' => '']
    'homeUrl' => null,
])

@php
    $homeUrl = $homeUrl ?? route('admin.dashboard');
@endphp

<div class="mb-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-white px-3 py-2 rounded shadow-sm">
            <li class="breadcrumb-item">
                <a href="{{ $homeUrl }}" class="text-secondary">
                    <i class="tio-home-outlined"></i> {{ \App\CPU\translate('الرئيسية') }}
                </a>
            </li>

            @foreach($items as $item)
                <li class="breadcrumb-item">
                    <a href="{{ $item['url'] ?? '#' }}"
                       class="{{ ($loop->last && empty($title)) ? 'text-primary' : 'text-secondary' }}">
                        @if(!empty($item['icon'])) <i class="{{ $item['icon'] }}"></i> @endif
                        {{ $item['label'] ?? '' }}
                    </a>
                </li>
            @endforeach

            @if($title)
                <li class="breadcrumb-item">
                    <a href="#" class="text-primary">{{ $title }}</a>
                </li>
            @endif
        </ol>
    </nav>
</div>
