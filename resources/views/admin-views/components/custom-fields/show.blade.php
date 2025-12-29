@props([
    'model',
    'title'     => __('حقول إضافية'),
    'emptyText' => '—',
])

@php
    /** @var \App\Services\CustomFieldService $svc */
    $svc    = app(\App\Services\CustomFieldService::class);
    $fields = $svc->fieldsFor(get_class($model));
    $values = $svc->valuesMapFor($model);

    // Small helpers
    $isImage = function (?string $path): bool {
        if (!is_string($path)) return false;
        return (bool) preg_match('/\.(png|jpe?g|gif|webp|svg)$/i', parse_url($path, PHP_URL_PATH) ?? $path);
    };

    $isFile = function (?string $path): bool {
        if (!is_string($path)) return false;
        return filter_var($path, FILTER_VALIDATE_URL) || str_contains($path, '/');
    };

    $formatValue = function ($field, $val) use ($emptyText, $isImage, $isFile) {
        $type = $field->type ?? 'text';

        if ($val === null || $val === '') {
            return '<span class="text-gray-400">'.$emptyText.'</span>';
        }

        // Arrays: render as tags unless the field hints JSON
        if (is_array($val)) {
            // If associative (likely JSON), render a collapsible block
            $isAssoc = array_keys($val) !== range(0, count($val) - 1);
            if ($isAssoc) {
                $pretty = htmlentities(json_encode($val, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT), ENT_QUOTES, 'UTF-8');
                return <<<HTML
                    <details class="group">
                        <summary class="cursor-pointer text-sm text-gray-600 hover:text-gray-800 select-none">عرض التفاصيل</summary>
                        <pre class="mt-2 bg-gray-50 rounded-lg p-3 text-xs overflow-auto border">$pretty</pre>
                    </details>
                HTML;
            }
            // Otherwise as badges
            $badges = collect($val)
                ->filter(fn($item) => $item !== null && $item !== '')
                ->map(fn($item) => '<span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs leading-5 text-gray-700 bg-white">'.$item.'</span>')
                ->implode(' ');
            return $badges !== '' ? $badges : '<span class="text-gray-400">'.$emptyText.'</span>';
        }

        // Scalars by type
        switch ($type) {
            case 'boolean':
            case 'switch':
                $yes = in_array(strtolower((string)$val), ['1','true','yes','on','y','t','مفعل','نعم'], true);
                return $yes
                    ? '<span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 text-emerald-700 px-2.5 py-0.5 text-xs">
                           <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor"><path d="M16.704 5.29a1 1 0 0 1 .006 1.414l-7.5 7.6a1 1 0 0 1-1.437.012L3.29 10.83a1 1 0 1 1 1.42-1.406l3.003 3.03 6.786-6.878a1 1 0 0 1 1.205-.283"/></svg>
                           مفعل
                       </span>'
                    : '<span class="inline-flex items-center gap-1 rounded-full bg-rose-50 text-rose-700 px-2.5 py-0.5 text-xs">
                           <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor"><path d="M10 8.586 5.293 3.879A1 1 0 1 0 3.879 5.293L8.586 10l-4.707 4.707a1 1 0 1 0 1.414 1.414L10 11.414l4.707 4.707a1 1 0 1 0 1.414-1.414L11.414 10l4.707-4.707A1 1 0 0 0 14.707 3.88z"/></svg>
                           غير مفعل
                       </span>';

            case 'date':
                try {
                    $d = \Illuminate\Support\Carbon::parse($val);
                    return '<span dir="ltr">'.e($d->format('Y-m-d')).'</span>';
                } catch (\Throwable $e) { return e($val); }

            case 'datetime':
            case 'timestamp':
                try {
                    $d = \Illuminate\Support\Carbon::parse($val);
                    return '<span dir="ltr">'.e($d->format('Y-m-d H:i')).'</span>';
                } catch (\Throwable $e) { return e($val); }

            case 'number':
            case 'integer':
            case 'decimal':
                if (is_numeric($val)) {
                    // Format with thousands separators; tweak as needed
                    $formatted = number_format((float)$val, (str_contains((string)$val, '.') ? 2 : 0), '.', ',');
                    return '<span class="font-medium tabular-nums">'.e($formatted).'</span>';
                }
                return e($val);

            case 'email':
                return '<a href="mailto:'.e($val).'" class="text-blue-600 hover:underline">'.e($val).'</a>';

            case 'phone':
            case 'tel':
                $digits = preg_replace('/\s+/', '', (string)$val);
                return '<a href="tel:'.e($digits).'" class="text-blue-600 hover:underline">'.e($val).'</a>';

            case 'url':
            case 'link':
                $href = e($val);
                $label = e(str($val)->limit(48));
                return '<a href="'.$href.'" target="_blank" rel="noopener" class="inline-flex items-center gap-1 text-blue-600 hover:underline">
                            '.$label.'
                            <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor"><path d="M14 3a1 1 0 0 1 1 1v6a1 1 0 1 1-2 0V6.414l-7.293 7.293a1 1 0 0 1-1.414-1.414L11.586 5H10a1 1 0 1 1 0-2h4z"/><path d="M5 9a1 1 0 0 1 1 1v5h8v-3a1 1 0 1 1 2 0v4a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1v-6a1 1 0 0 1 1-1z"/></svg>
                        </a>';

            case 'file':
            case 'image':
                $strVal = (string) $val;
                if ($isImage($strVal)) {
                    $safe = e($strVal);
                    return <<<HTML
                        <a href="$safe" target="_blank" rel="noopener" class="group inline-flex items-center gap-2">
                            <img src="$safe" alt="image" class="h-14 w-14 rounded-lg border object-cover ring-1 ring-gray-200">
                            <span class="text-blue-600 group-hover:underline text-sm">فتح الصورة</span>
                        </a>
                    HTML;
                }
                if ($isFile($strVal)) {
                    $safe = e($strVal);
                    $name = e(basename(parse_url($strVal, PHP_URL_PATH) ?: $strVal));
                    return '<a href="'.$safe.'" target="_blank" rel="noopener" class="text-blue-600 hover:underline">'.$name.'</a>';
                }
                return e($val);

            case 'json':
                $decoded = json_decode((string)$val, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $pretty = htmlentities(json_encode($decoded, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT), ENT_QUOTES, 'UTF-8');
                    return '<pre class="bg-gray-50 rounded-lg p-3 text-xs overflow-auto border">'.$pretty.'</pre>';
                }
                return e($val);

            default:
                // Plain text with a tiny copy button
                $escaped = e((string)$val);
                $id = 'fld_'.\Illuminate\Support\Str::uuid()->toString();
                return <<<HTML
                    <span id="$id">$escaped</span>
                    <button type="button"
                            class="ml-2 inline-flex items-center rounded-md border px-2 py-0.5 text-xs text-gray-600 hover:bg-gray-50"
                            onclick="(async()=>{try{await navigator.clipboard.writeText(document.getElementById('$id').innerText);this.innerText='Copied';setTimeout(()=>this.innerText='Copy',1200);}catch(e){}}).call(this)">
                        Copy
                    </button>
                HTML;
        }
    };
@endphp

@if($fields->isNotEmpty())
    <div class="rounded-2xl border bg-white/70 backdrop-blur p-4 md:p-6 shadow-sm">
        <div class="mb-4 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <h3 class="text-base font-semibold text-gray-800">{{ $title }}</h3>
            </div>
            <span class="rounded-full bg-gray-100 px-2.5 py-0.5 text-xs text-gray-600">{{ $fields->count() }} حقل</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            @foreach($fields as $field)
                @php
                    $key   = $field->key;
                    $label = $field->name ?? $field->label ?? $key;
                    $val   = $values[$key] ?? null;
                @endphp

                <div class="group rounded-xl border bg-white p-3 hover:shadow-sm transition-shadow">
                    <div class="text-[11px] font-medium uppercase tracking-wide text-gray-500 mb-1">
                        {{ $label }}
                    </div>

                    <div class="prose prose-sm max-w-none text-gray-800">
                        {!! $formatValue($field, $val) !!}
                    </div>

                    <div class="mt-2 flex items-center justify-between">
                        @if($val !== null && $val !== '')
                    
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
