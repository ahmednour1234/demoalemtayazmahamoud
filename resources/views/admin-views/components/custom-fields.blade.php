{{-- resources/views/admin-views/components/custom-fields.blade.php --}}
@props([
  'model' => null,                 /* كائن الموديل (ممكن يكون null في create) */
  'appliesTo' => null,             /* FQCN زي \App\Models\Lead أو \App\Models\CallLog */
  'namePrefix' => 'custom_fields', /* بادئة أسماء الحقول في الـ request */
])

@php
  use App\Models\CustomField;
  use Illuminate\Support\Str;

  // حدّد الكيان الهدف (FQCN) من appliesTo أو من كلاس الموديل لو متوفر
  $applies = $appliesTo ?: ($model ? get_class($model) : null);

  // تعريفات الحقول المخصّصة المفعّلة
  $defs = $applies
    ? CustomField::query()
        ->where('applies_to', $applies)
        ->where('is_active', 1)
        ->orderBy('group')
        ->orderBy('sort_order')
        ->get()
    : collect();

  // قيم الموديل (لو الموديل موجود فعلًا)
  $vals = ($model && method_exists($model, 'customFieldValues') && $model->exists)
    ? $model->customFieldValues()->get()->keyBy('custom_field_id')
    : collect();

  // نجمع حسب المجموعة
  $grouped = $defs->groupBy(fn($f) => $f->group ?: 'حقول إضافية');
@endphp

@if($defs->isNotEmpty())
  <div class="row g-3">
    @foreach($grouped as $groupName => $fields)
      <div class="col-12">
        <div class="fw-bold text-primary mb-2">{{ $groupName }}</div>
      </div>

      @foreach($fields as $def)
        @php
          $valRow   = $vals[$def->id] ?? null;
          $value    = $valRow?->value_json ?? $valRow?->value ?? $def->default_value;

          // جرّب نفك JSON لو القيمة نص
          if (is_string($value)) {
            $decoded = json_decode($value, true);
            if (json_last_error() === JSON_ERROR_NONE) $value = $decoded;
          }

          $name     = $namePrefix.'['.$def->key.']';
          $help     = $def->help_text;
          $required = (bool)$def->is_required;
          $type     = strtolower((string)$def->type);

          // خيارات select/multiselect
          $optsArr  = is_array($def->options) ? $def->options : (json_decode((string)$def->options, true) ?? []);
          $choices  = data_get($optsArr, 'choices', []);
          // old() مع fallback
          $oldVal   = old($namePrefix.'.'.$def->key, $value);
        @endphp

        <div class="col-md-6">
          <label class="form-label {{ $required ? 'required' : '' }}">{{ $def->name }}</label>

          @switch($type)
            @case('textarea')
              <textarea class="form-control"
                        name="{{ $name }}"
                        rows="3"
                        @required($required)>{{ is_string($oldVal) ? $oldVal : (is_array($oldVal)||is_object($oldVal) ? json_encode($oldVal, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) : '') }}</textarea>
            @break

            @case('number')
              <input type="number"
                     class="form-control"
                     name="{{ $name }}"
                     value="{{ is_numeric($oldVal) ? $oldVal : '' }}"
                     @required($required)>
            @break

            @case('boolean')
              <div class="form-check form-switch">
                <input type="hidden" name="{{ $name }}" value="0">
                <input class="form-check-input"
                       type="checkbox"
                       name="{{ $name }}"
                       value="1"
                       {{ filter_var($oldVal, FILTER_VALIDATE_BOOLEAN) ? 'checked' : '' }}>
              </div>
            @break

            @case('date')
              @php
                $dateStr = is_string($oldVal)
                  ? Str::before($oldVal, 'T')
                  : (is_array($oldVal)||is_object($oldVal) ? '' : (string)$oldVal);
              @endphp
              <input type="date"
                     class="form-control"
                     name="{{ $name }}"
                     value="{{ $dateStr }}"
                     @required($required)>
            @break

            @case('datetime')
              @php
                $dtStr = is_string($oldVal)
                  ? str_replace(' ', 'T', $oldVal)
                  : (is_array($oldVal)||is_object($oldVal) ? '' : (string)$oldVal);
              @endphp
              <input type="datetime-local"
                     class="form-control"
                     name="{{ $name }}"
                     value="{{ $dtStr }}"
                     @required($required)>
            @break

            @case('select')
              @php $cur = is_scalar($oldVal) ? (string)$oldVal : ''; @endphp
              <select class="form-select js-select2"
                      name="{{ $name }}"
                      data-placeholder="— اختر —"
                      @required($required)>
                <option value=""></option>
                @foreach($choices as $ch)
                  @php
                    $cid  = (string)($ch['id'] ?? $ch['value'] ?? '');
                    $clbl = (string)($ch['name'] ?? $ch['label'] ?? $cid);
                  @endphp
                  <option value="{{ $cid }}" @selected($cur === $cid)>{{ $clbl }}</option>
                @endforeach
              </select>
            @break

            @case('multiselect')
              @php
                $arr = is_array($oldVal) ? $oldVal : (is_string($oldVal) && json_decode($oldVal, true) ? json_decode($oldVal, true) : []);
                $cur = collect($arr)->map(fn($v)=>(string)$v)->all();
              @endphp
              <select class="form-select js-select2"
                      name="{{ $name }}[]"
                      multiple
                      data-placeholder="— اختر —"
                      @required($required)>
                @foreach($choices as $ch)
                  @php
                    $cid  = (string)($ch['id'] ?? $ch['value'] ?? '');
                    $clbl = (string)($ch['name'] ?? $ch['label'] ?? $cid);
                  @endphp
                  <option value="{{ $cid }}" @selected(in_array($cid, $cur, true))>{{ $clbl }}</option>
                @endforeach
              </select>
            @break

            @case('json')
              <textarea class="form-control"
                        name="{{ $name }}"
                        rows="3"
                        placeholder="JSON">{{ is_string($oldVal) ? $oldVal : json_encode($oldVal, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) }}</textarea>
            @break

            @default
              <input type="text"
                     class="form-control"
                     name="{{ $name }}"
                     value="{{ is_scalar($oldVal) ? (string)$oldVal : (is_array($oldVal)||is_object($oldVal) ? json_encode($oldVal, JSON_UNESCAPED_UNICODE) : '') }}"
                     @required($required)>
          @endswitch

          @if($help)<div class="form-text">{{ $help }}</div>@endif

          @error($namePrefix . '.' . $def->key)
            <div class="invalid-feedback d-block">{{ $message }}</div>
          @enderror
        </div>
      @endforeach
    @endforeach
  </div>
@endif

{{-- لمسة بسيطة لتمييز required --}}
<style>
  .form-label.required::after{ content:" *"; color:#d6336c; font-weight:600; }
</style>
