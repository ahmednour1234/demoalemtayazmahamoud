{{-- resources/views/components/custom-fields/form.blade.php --}}
@props([
    /** عنوان الكارد */
    'title' => 'الحقول الإضافية',
    /** FQCN الموديل المستهدف: App\Models\Lead مثلاً */
    'appliesTo',
    /** موديل موجود (للتعديل) أو null */
    'model' => null,
    /** اسم الحقل في الريكويست: custom_fields[...] */
    'namePrefix' => 'custom_fields',
    /** تمرير قيم قديمة/مبدئية لو محتاج */
    'initial' => [],
    /** عدد الأعمدة داخل الكارد على الشاشات الكبيرة */
    'cols' => 2,
    /** إظهار العناوين الفرعية حسب group */
    'showGroups' => true,
])

@php
    /** @var \App\Services\CustomFieldService $svc */
    $svc = app(\App\Services\CustomFieldService::class);
    $fields = $svc->fieldsFor($appliesTo);

    $existing = [];
    if ($model) {
        $existing = $svc->valuesMapFor($model);
    }

    // تجميع حسب group لو مفعّل
    $grouped = $showGroups
        ? $fields->groupBy(fn($f) => $f->group ?: '—')
        : collect(['' => $fields]);

    // Laravel errors تستخدم dot-notation لمفاتيح المصفوفات
    $errorDot = fn(string $key) => $namePrefix . '.' . $key;
@endphp

<div class="rounded-2xl border border-gray-200 bg-white shadow-sm overflow-hidden">
    {{-- Header --}}
    <div class="flex items-center justify-between px-4 py-3 md:px-6 bg-gray-50/60">
        <div class="flex items-center gap-2">
            <span class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-gray-200 bg-white text-sm font-semibold">
                {{ $fields->count() }}
            </span>
            <h3 class="text-base md:text-lg font-semibold text-gray-800">{{ $title }}</h3>
        </div>
        @if($fields->isNotEmpty())
            <span class="text-xs text-gray-500 hidden md:inline">
                يمكنك تخصيص هذه البيانات حسب نوع السجل
            </span>
        @endif
    </div>

    {{-- Body --}}
    <div class="p-4 md:p-6">
        @if($fields->isEmpty())
            <div class="text-sm text-gray-500">
                لا توجد حقول إضافية مُعرفة لهذا النوع.
            </div>
        @else
            @foreach($grouped as $groupName => $groupFields)
           

                <div class="grid grid-cols-1 md:grid-cols-{{ max(1, (int)$cols) }} gap-4">
                    @foreach($groupFields as $field)
                        @php
                            $key       = $field->key;
                            $type      = $field->type;
                            $label     = $field->name;
                            $help      = $field->help_text;
                            $options   = (array) ($field->options ?? []);
                            $required  = (bool) $field->is_required;

                            $inputName = $namePrefix . '[' . $key . ']';

                            // ترتيب أولوية القيم: old() ثم existing ثم initial ثم default_value
                            $valOld = old($namePrefix . '.' . $key);
                            $val    = $valOld ?? ($existing[$key] ?? ($initial[$key] ?? ($field->default_value ?? null)));

                            $hasError = $errors->has($errorDot($key));
                        @endphp

                            <label class="block mb-1.5 font-medium text-gray-800">
                                {{ $label }}
                                @if($required)
                                    <span class="text-red-600" title="حقل إجباري">*</span>
                                @endif
                            </label>

                            @switch($type)
                                @case('text')
                                    <input
                                        type="text"
                                        name="{{ $inputName }}"
                                        class="form-input w-full rounded-lg border-gray-300 focus:border-gray-400 focus:ring-0"
                                        value="{{ is_array($val) ? '' : ($val ?? '') }}"
                                        @if($required) required @endif
                                    />
                                    @break

                                @case('textarea')
                                    <textarea
                                        name="{{ $inputName }}"
                                        class="form-textarea w-full rounded-lg border-gray-300 focus:border-gray-400 focus:ring-0"
                                        rows="3"
                                        @if($required) required @endif>{{ is_array($val) ? '' : ($val ?? '') }}</textarea>
                                    @break

                                @case('number')
                                    <input
                                        type="number"
                                        name="{{ $inputName }}"
                                        class="form-input w-full rounded-lg border-gray-300 focus:border-gray-400 focus:ring-0"
                                        value="{{ is_array($val) ? '' : ($val ?? '') }}"
                                        @if($required) required @endif
                                    />
                                    @break

                                @case('boolean')
                                    {{-- hidden لتضمن إرسال 0 لو unchecked --}}
                                    <input type="hidden" name="{{ $inputName }}" value="0" />
                                    <label class="inline-flex items-center gap-2 select-none">
                                        <input
                                            type="checkbox"
                                            name="{{ $inputName }}"
                                            value="1"
                                            class="h-4 w-4 rounded border-gray-300 focus:ring-0"
                                            @checked((bool)$val)
                                        />
                                        <span class="text-sm text-gray-700">{{ __('Yes') }}</span>
                                    </label>
                                    @break

                                @case('date')
                                    <input
                                        type="date"
                                        name="{{ $inputName }}"
                                        class="form-input w-full rounded-lg border-gray-300 focus:border-gray-400 focus:ring-0"
                                        value="{{ is_array($val) ? '' : ($val ?? '') }}"
                                        @if($required) required @endif
                                    />
                                    @break

                                @case('datetime')
                                    <input
                                        type="datetime-local"
                                        name="{{ $inputName }}"
                                        class="form-input w-full rounded-lg border-gray-300 focus:border-gray-400 focus:ring-0"
                                        value="{{ is_array($val) ? '' : ($val ?? '') }}"
                                        @if($required) required @endif
                                    />
                                    @break

                                @case('select')
                                    <select
                                        name="{{ $inputName }}"
                                        class="form-select w-full rounded-lg border-gray-300 focus:border-gray-400 focus:ring-0"
                                        @if($required) required @endif>
                                        <option value="">— اختر —</option>
                                        @foreach($options as $opt)
                                            <option value="{{ $opt }}" @selected($val == $opt)>{{ $opt }}</option>
                                        @endforeach
                                    </select>
                                    @break

                                @case('multiselect')
                                    @php $valArr = is_array($val) ? $val : (array)$val; @endphp
                                    <select
                                        name="{{ $inputName }}[]"
                                        class="form-multiselect w-full rounded-lg border-gray-300 focus:border-gray-400 focus:ring-0"
                                        multiple
                                        @if($required) required @endif>
                                        @foreach($options as $opt)
                                            <option value="{{ $opt }}" @selected(in_array($opt, $valArr, true))>{{ $opt }}</option>
                                        @endforeach
                                    </select>
                                    @break

                                @case('json')
                                    {{-- ملاحظة: الخدمة تتوقع Array؛ لو هتدخل JSON خام ارفعه كما هو وسيتم حفظه في value_json كمصفوفة --}}
                                    <textarea
                                        name="{{ $inputName }}[json]"
                                        class="form-textarea w-full rounded-lg border-gray-300 focus:border-gray-400 focus:ring-0 font-mono text-xs"
                                        rows="5"
                                        placeholder='{"key":"value"}'>{{ $val ? (is_array($val) ? json_encode($val, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) : (string)$val) : '' }}</textarea>
                                    <div class="mt-1 text-[11px] text-gray-500">اكتب JSON صالح ليتم تخزينه كمصفوفة.</div>
                                    @break
                            @endswitch

                            @if($help)
                                <div class="mt-2 text-xs text-gray-500">{{ $help }}</div>
                            @endif

                            @error($errorDot($key))
                                <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                            @enderror
                    @endforeach
                </div>
            @endforeach
        @endif
    </div>
</div>
