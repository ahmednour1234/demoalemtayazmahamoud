@props(['title' => '', 'items' => [], 'text' => null])

<div class="empty-state shadow-sm mb-4 non-printable">
    <h5 class="mb-2">{{ $title }}</h5>

    @if($text)
        <p class="mb-0 text-muted">{{ $text }}</p>
    @endif

    @if(!empty($items))
        <ul class="mb-0 text-muted">
            @foreach($items as $it)
                <li>{{ $it }}</li>
            @endforeach
        </ul>
    @endif
</div>
