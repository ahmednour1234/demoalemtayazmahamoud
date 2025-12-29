{{-- resources/views/admin/leads/_form.blade.php --}}
@php
  /** @var \App\Models\Lead|null $lead */
  $isEdit = isset($lead) && $lead?->id;

  // تحميل القيم المخصّصة إن وجدت
  if(isset($lead) && method_exists($lead,'loadMissing')){
      $lead->loadMissing('customFieldValues.customField');
  }

  // جلب تعريفات الحقول المخصّصة لهذا الموديل إن لم تُمرَّر
  $customFields = $customFields
      ?? (\App\Models\CustomField::query()
            ->where('applies_to', \App\Models\Lead::class)
            ->where('is_active', 1)
            ->orderBy('group')->orderBy('sort_order')->get());

  // خريطة key => value الحالي
  $cfValuesMap = collect($lead->customFieldValues ?? [])->mapWithKeys(function($v){
      $key = optional($v->customField)->key;
      if(!$key) return [];
      // لو في value_json نستخدمه وإلا value النصّي
      $val = !is_null($v->value_json) ? $v->value_json : $v->value;
      // تأكد من تحويل JSON string إلى array/object عند الحاجة
      if (is_string($val)) {
        $decoded = json_decode($val, true);
        if (json_last_error() === JSON_ERROR_NONE) $val = $decoded;
      }
      return [$key => $val];
  })->all();

  // مساعد: جلب قيمة الحقل (old -> من القاعدة -> default)
  $getCFValue = function($field) use ($cfValuesMap){
      $key = $field->key;
      // old()
      $old = old('custom_fields.'.$key);
      if(!is_null($old)) return $old;
      // من القاعدة
      if(array_key_exists($key, $cfValuesMap)) return $cfValuesMap[$key];
      // Default (قد تكون null/primitive/array)
      return $field->default_value ?? null;
  };

  // مساعد: خيارات select/multiselect
  $getChoices = function($field){
      $options = $field->options ?? [];
      if (is_string($options)) {
        $decoded = json_decode($options, true);
        if (json_last_error() === JSON_ERROR_NONE) $options = $decoded;
      }
      $choices = $options['choices'] ?? [];
      // كل عنصر: ['id'=>'value','name'=>'النص']
      return is_array($choices) ? $choices : [];
  };

  // تجميع حسب المجموعة
  $groupedCF = $customFields->groupBy(fn($f) => $f->group ?: 'حقول إضافية');
@endphp

<div class="crm-form">

  {{-- القسم 1: بيانات أساسية --}}
  <div class="card crm-section mb-3">
    <div class="card-header d-flex align-items-center gap-2 py-2">
      <i class="tio-user"></i>
      <strong>البيانات الأساسية</strong>
      <span class="text-muted small ms-auto">الحقول المعلّمة مطلوبة</span>
    </div>
    <div class="card-body">
      <div class="row g-3">

        {{-- الشركة --}}
        <div class="col-md-4">
          <label class="form-label required">الشركة</label>
          <input name="company_name"
                 class="form-control @error('company_name') is-invalid @enderror"
                 value="{{ old('company_name', $lead->company_name ?? '') }}"
                 placeholder="مثال: Smart Vision"
                 autocomplete="organization">
          @error('company_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- الاسم --}}
        <div class="col-md-4">
          <label class="form-label required">الاسم</label>
          <input name="contact_name"
                 class="form-control @error('contact_name') is-invalid @enderror"
                 value="{{ old('contact_name', $lead->contact_name ?? '') }}"
                 placeholder="اسم الشخص المسؤول"
                 autocomplete="name">
          @error('contact_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- الإيميل --}}
        <div class="col-md-4">
          <label class="form-label">الإيميل</label>
          <input name="email" type="email" dir="ltr"
                 class="form-control @error('email') is-invalid @enderror"
                 value="{{ old('email', $lead->email ?? '') }}"
                 placeholder="name@company.com"
                 autocomplete="email">
          @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- كود الدولة + الهاتف --}}
        <div class="col-md-2">
          <label class="form-label required">كود الدولة</label>
          <input name="country_code" dir="ltr"
                 class="form-control @error('country_code') is-invalid @enderror"
                 value="{{ old('country_code', $lead->country_code ?? '+966') }}"
                 placeholder="+966" required>
          @error('country_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-3">
          <label class="form-label required">الهاتف</label>
          <input name="phone" dir="ltr" inputmode="tel"
                 class="form-control @error('phone') is-invalid @enderror"
                 value="{{ old('phone', $lead->phone ?? '') }}"
                 placeholder="5xxxxxxxx" required>
          @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
          <small class="text-muted">اكتب الرقم بدون صفر البداية عند استخدام كود الدولة.</small>
        </div>

        {{-- واتساب مع خيار نسخ من الهاتف --}}
        <div class="col-md-3">
          <label class="form-label d-flex align-items-center justify-content-between">
            <span>واتساب</span>
            <button type="button" class="btn btn-link p-0 small" id="copyPhoneToWhatsapp">
              نسخ من الهاتف
            </button>
          </label>
          <input name="whatsapp" dir="ltr" inputmode="tel"
                 class="form-control @error('whatsapp') is-invalid @enderror"
                 value="{{ old('whatsapp', $lead->whatsapp ?? '') }}"
                 placeholder="5xxxxxxxx">
          @error('whatsapp') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- القيمة المحتملة --}}
        <div class="col-md-2">
          <label class="form-label">القيمة المحتملة</label>
          <input name="potential_value" type="number" step="0.01" min="0"
                 class="form-control @error('potential_value') is-invalid @enderror"
                 value="{{ old('potential_value', $lead->potential_value ?? '') }}"
                 placeholder="0.00">
          @error('potential_value') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- العملة --}}
        <div class="col-md-2">
          <label class="form-label">العملة</label>
          <input name="currency"
                 class="form-control text-uppercase @error('currency') is-invalid @enderror"
                 value="{{ old('currency', $lead->currency ?? 'SAR') }}"
                 placeholder="SAR" maxlength="4">
          @error('currency') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

      </div>
    </div>
  </div>

  {{-- القسم 2: تفاصيل التصنيف والمتابعة --}}
  <div class="card crm-section mb-3">
    <div class="card-header d-flex align-items-center gap-2 py-2">
      <i class="tio-category-outlined"></i>
      <strong>تفاصيل التصنيف والمتابعة</strong>
    </div>
    <div class="card-body">
      <div class="row g-3">
        {{-- الحالة --}}
        <div class="col-md-3">
          <label class="form-label">الحالة</label>
          <select name="status_id"
                  class="form-select js-select2 @error('status_id') is-invalid @enderror"
                  data-placeholder="— اختر الحالة —">
            <option value=""></option>
            @foreach($statuses as $st)
              <option value="{{ $st->id }}" @selected(old('status_id', $lead->status_id ?? '')==$st->id)>{{ $st->name }}</option>
            @endforeach
          </select>
          @error('status_id') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>

        {{-- المصدر --}}
        <div class="col-md-3">
          <label class="form-label">المصدر</label>
          <select name="source_id"
                  class="form-select js-select2 @error('source_id') is-invalid @enderror"
                  data-placeholder="— اختر المصدر —">
            <option value=""></option>
            @foreach($sources as $so)
              <option value="{{ $so->id }}" @selected(old('source_id', $lead->source_id ?? '')==$so->id)>{{ $so->name }}</option>
            @endforeach
          </select>
          @error('source_id') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>

        {{-- المسؤول --}}
        <div class="col-md-3">
          <label class="form-label">المسؤول</label>
          <select name="owner_id"
                  class="form-select js-select2 @error('owner_id') is-invalid @enderror"
                  data-placeholder="— اختر المسؤول —">
            <option value=""></option>
            @foreach($admins as $ad)
              <option value="{{ $ad->id }}" @selected(old('owner_id', $lead->owner_id ?? '')==$ad->id)>{{ $ad->email }}</option>
            @endforeach
          </select>
          @error('owner_id') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>

        {{-- التقييم --}}
        <div class="col-md-3">
          <label class="form-label">التقييم</label>
          <input name="rating" type="number" min="1" max="5"
                 class="form-control @error('rating') is-invalid @enderror"
                 value="{{ old('rating', $lead->rating ?? '') }}"
                 placeholder="1 إلى 5" list="rating-list">
          <datalist id="rating-list"><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></datalist>
          @error('rating') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
      </div>
    </div>
  </div>

  {{-- القسم 3: الجدولة --}}
  <div class="card crm-section mb-3">
    <div class="card-header d-flex align-items-center gap-2 py-2">
      <i class="tio-time-20-s"></i>
      <strong>الجدولة</strong>
    </div>
    <div class="card-body">
      <div class="row g-3">
        <div class="col-md-3">
          <label class="form-label">آخر تواصل</label>
          <input name="last_contact_at" type="datetime-local"
                 class="form-control @error('last_contact_at') is-invalid @enderror"
                 value="{{ old('last_contact_at', optional($lead->last_contact_at ?? null)?->format('Y-m-d\TH:i')) }}">
          @error('last_contact_at') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="col-md-3">
          <label class="form-label">المهمة القادمة</label>
          <input name="next_action_at" type="datetime-local"
                 class="form-control @error('next_action_at') is-invalid @enderror"
                 value="{{ old('next_action_at', optional($lead->next_action_at ?? null)?->format('Y-m-d\TH:i')) }}">
          @error('next_action_at') <div class="invalid-feedback">{{ $message }}</div> @enderror
          <small class="text-muted">استخدمها لوضع تذكير للمتابعة.</small>
        </div>

        {{-- أرشفة --}}
        <div class="col-md-3 d-flex align-items-center">
          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" name="is_archived" value="1" id="is_archived"
                   @checked(old('is_archived', $lead->is_archived ?? false))>
            <label class="form-check-label" for="is_archived">أرشفة</label>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- القسم 4: الحقول المخصّصة --}}
  @if($customFields->count())
  <div class="card crm-section mb-3">
    <div class="card-header d-flex align-items-center gap-2 py-2">
      <i class="tio-settings-outlined"></i>
      <strong>حقول إضافية</strong>
      <span class="text-muted small ms-auto">اضبط الحقول الخاصة بنموذج Lead</span>
    </div>
    <div class="card-body">
      @foreach($groupedCF as $groupName => $fields)
        <div class="mb-3">
          <div class="fw-bold text-primary mb-2">{{ $groupName }}</div>
          <div class="row g-3">
            @foreach($fields as $field)
              @php
                $key    = $field->key;
                $type   = strtolower($field->type);
                $value  = $getCFValue($field);
                $req    = (bool)$field->is_required;
                $help   = $field->help_text;
                $errMsg = $errors->first('custom_fields.'.$key);
                $choices= $getChoices($field);
              @endphp

              {{-- text / number / date / datetime --}}
              @if(in_array($type, ['text','number','date','datetime','json']))
                <div class="col-md-4">
                  <label class="form-label {{ $req ? 'required' : '' }}">{{ $field->name }}</label>
                  @if($type==='number')
                    <input type="number" class="form-control {{ $errMsg? 'is-invalid':'' }}"
                           name="custom_fields[{{ $key }}]"
                           value="{{ is_array($value)||is_object($value) ? json_encode($value, JSON_UNESCAPED_UNICODE) : ($value ?? '') }}">
                  @elseif($type==='date')
                    <input type="date" class="form-control {{ $errMsg? 'is-invalid':'' }}"
                           name="custom_fields[{{ $key }}]"
                           value="{{ \Illuminate\Support\Str::contains((string)$value,'T') ? \Illuminate\Support\Str::before((string)$value,'T') : ($value ?? '') }}">
                  @elseif($type==='datetime')
                    <input type="datetime-local" class="form-control {{ $errMsg? 'is-invalid':'' }}"
                           name="custom_fields[{{ $key }}]"
                           value="{{ is_string($value) ? str_replace(' ', 'T', $value) : '' }}">
                  @elseif($type==='json')
                    <textarea rows="2" class="form-control {{ $errMsg? 'is-invalid':'' }}"
                              name="custom_fields[{{ $key }}]"
                              placeholder='JSON'>{{ is_string($value) ? $value : json_encode($value, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) }}</textarea>
                  @else
                    <input type="text" class="form-control {{ $errMsg? 'is-invalid':'' }}"
                           name="custom_fields[{{ $key }}]"
                           value="{{ is_array($value)||is_object($value) ? json_encode($value, JSON_UNESCAPED_UNICODE) : ($value ?? '') }}">
                  @endif
                  @if($help)<div class="form-text">{{ $help }}</div>@endif
                  @if($errMsg)<div class="invalid-feedback d-block">{{ $errMsg }}</div>@endif
                </div>

              {{-- textarea --}}
              @elseif($type==='textarea')
                <div class="col-md-6">
                  <label class="form-label {{ $req ? 'required' : '' }}">{{ $field->name }}</label>
                  <textarea rows="3" class="form-control {{ $errMsg? 'is-invalid':'' }}"
                            name="custom_fields[{{ $key }}]">{{ is_array($value)||is_object($value) ? json_encode($value, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) : ($value ?? '') }}</textarea>
                  @if($help)<div class="form-text">{{ $help }}</div>@endif
                  @if($errMsg)<div class="invalid-feedback d-block">{{ $errMsg }}</div>@endif
                </div>

              {{-- boolean (switch) --}}
              @elseif($type==='boolean')
                <div class="col-md-3 d-flex align-items-center">
                  <div class="form-check form-switch">
                    <input type="hidden" name="custom_fields[{{ $key }}]" value="0">
                    <input class="form-check-input" type="checkbox"
                           id="cf_{{ $key }}" name="custom_fields[{{ $key }}]" value="1"
                           {{ filter_var($value, FILTER_VALIDATE_BOOLEAN) ? 'checked' : '' }}>
                    <label class="form-check-label" for="cf_{{ $key }}">{{ $field->name }}</label>
                    @if($help)<div class="form-text">{{ $help }}</div>@endif
                    @if($errMsg)<div class="invalid-feedback d-block">{{ $errMsg }}</div>@endif
                  </div>
                </div>

              {{-- select --}}
              @elseif($type==='select')
                <div class="col-md-4">
                  <label class="form-label {{ $req ? 'required' : '' }}">{{ $field->name }}</label>
                  <select class="form-select js-select2 {{ $errMsg? 'is-invalid':'' }}"
                          name="custom_fields[{{ $key }}]" data-placeholder="— اختر —">
                    <option value=""></option>
                    @foreach($choices as $c)
                      @php $cid = (string)($c['id'] ?? $c['value'] ?? ''); @endphp
                      <option value="{{ $cid }}" @selected((string)$value === $cid)>{{ $c['name'] ?? $c['label'] ?? $cid }}</option>
                    @endforeach
                  </select>
                  @if($help)<div class="form-text">{{ $help }}</div>@endif
                  @if($errMsg)<div class="invalid-feedback d-block">{{ $errMsg }}</div>@endif
                </div>

              {{-- multiselect --}}
              @elseif($type==='multiselect')
                @php
                  $valArr = is_array($value) ? $value : ( (is_string($value) && json_decode($value, true)) ? json_decode($value, true) : [] );
                  $valArr = array_map('strval', $valArr ?? []);
                @endphp
                <div class="col-md-6">
                  <label class="form-label {{ $req ? 'required' : '' }}">{{ $field->name }}</label>
                  <select class="form-select js-select2 {{ $errMsg? 'is-invalid':'' }}"
                          multiple name="custom_fields[{{ $key }}][]" data-placeholder="— اختر —">
                    @foreach($choices as $c)
                      @php $cid = (string)($c['id'] ?? $c['value'] ?? ''); @endphp
                      <option value="{{ $cid }}" @selected(in_array($cid, $valArr, true))>{{ $c['name'] ?? $c['label'] ?? $cid }}</option>
                    @endforeach
                  </select>
                  @if($help)<div class="form-text">{{ $help }}</div>@endif
                  @if($errMsg)<div class="invalid-feedback d-block">{{ $errMsg }}</div>@endif
                </div>
              @endif
            @endforeach
          </div>
        </div>
      @endforeach
    </div>
  </div>
  @endif

  {{-- القسم 5: الملاحظات --}}
  <div class="card crm-section mb-3">
    <div class="card-header d-flex align-items-center gap-2 py-2">
      <i class="tio-notes"></i>
      <strong>ملاحظات</strong>
    </div>
    <div class="card-body">
      <textarea name="pipeline_notes" rows="4"
                class="form-control @error('pipeline_notes') is-invalid @enderror"
                placeholder="اكتب ملخصًا واضحًا لآخر محادثة أو المطلوب في المتابعة...">{{ old('pipeline_notes', $lead->pipeline_notes ?? '') }}</textarea>
      @error('pipeline_notes') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
  </div>

  {{-- أزرار الحفظ --}}
  <div class="mt-3 d-flex justify-content-end align-items-start flex-wrap gap-2">
    <a href="{{ route('admin.leads.index') }}" class="btn btn-light">رجوع</a>
    <button type="submit" class="btn btn-primary px-4">
      {{ $isEdit ? 'تحديث' : 'حفظ' }}
    </button>
  </div>

</div>

{{-- Select2 Assets + Compact Styling --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
  .crm-section{ border:0; border-radius:1rem; box-shadow:0 6px 18px rgba(0,0,0,.06); }
  .form-label.required::after{ content:" *"; color:#d6336c; font-weight:600; }
  .text-uppercase { text-transform: uppercase; }
  .crm-form .form-control, .crm-form .form-select{ border-color:#e6e8eb; border-radius:.6rem; }
  .crm-form .form-control:focus, .crm-form .form-select:focus{
    box-shadow:0 0 0 .15rem rgba(13,110,253,.08); border-color:#b6c8ff;
  }
  .select2-container{ width:100%!important; }
  .select2-compact.select2-container--default .select2-selection--single{
    min-height: 36px; border-color:#e6e8eb; border-radius:.6rem;
  }
  .select2-compact .select2-selection__rendered{ line-height:34px!important; font-size:.925rem; padding-inline: .5rem .75rem; }
  .select2-compact .select2-selection__arrow{ height:36px!important; }
  .select2-compact .select2-dropdown{ border-radius:.6rem; }
  .select2-compact .select2-results__options{ max-height:240px; font-size:.925rem; }
  .select2-compact .select2-results__option{ padding:6px 10px; }
  .select2-compact .select2-search--dropdown{ padding:4px 6px; }
</style>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.full.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function(){
    // زر "نسخ من الهاتف"
    const btn = document.getElementById('copyPhoneToWhatsapp');
    if(btn){
      btn.addEventListener('click', function(){
        const phone = document.querySelector('input[name="phone"]');
        const wa    = document.querySelector('input[name="whatsapp"]');
        if(phone && wa){ wa.value = phone.value || ''; wa.focus(); }
      });
    }

    // تهيئة Select2 للكل (single/multiple)
    if (window.jQuery && jQuery().select2) {
      $('.js-select2, .crm-form select').each(function(){
        const $el = $(this);
        // متسيّبش multiple من غير placeholder
        $el.attr('data-placeholder', $el.data('placeholder') || ($el.prop('multiple') ? '— اختر —' : $el.attr('data-placeholder')));
        $el.select2({
          dir: 'rtl',
          width: '100%',
          placeholder: $el.data('placeholder') || '',
          allowClear: !$el.prop('multiple'),
          dropdownAutoWidth: false,
          minimumResultsForSearch: 7,
          dropdownCssClass: 'select2-compact',
          selectionCssClass: 'select2-compact'
        });
      });
    } else {
      console.warn('Select2 أو jQuery غير محملين.');
    }
  });
</script>
