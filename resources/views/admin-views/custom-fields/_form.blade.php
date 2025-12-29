

@php
  // حدد هنا الموديلات المسموح تضيف لها حقول
  $modelChoices = $modelChoices ?? [
    \App\Models\Lead::class        => 'Lead (العملاء المحتملين)',
    \App\Models\CallLog::class     => 'CallLog (سجلات المكالمات)',
    \App\Models\CallOutcome::class => 'CallOutcome (نتائج المكالمات)',
    \App\Models\Admin::class       => 'Admin (المسؤولون)',
        \App\Models\LeadNote::class       => 'LeadNote (ملاحظات عملاء محتملين)',
        \App\Models\Customer::class       => 'Customers ( عملاء)',

  ];
  $types = $types ?? \App\Models\CustomField::types();
  $currentType = old('type', $field->type ?? 'text');
  $currentModel = old('applies_to', $field->applies_to ?? '');
@endphp

<div class="card border-0 shadow-sm rounded-4">
  <div class="card-body">
    <div class="row g-3">

      {{-- الاسم --}}
      <div class="col-md-6">
        <label class="form-label">الاسم <span class="text-danger">*</span></label>
        <input type="text" name="name" id="cf_name" value="{{ old('name', $field->name ?? '') }}" class="form-control" required>
        @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
      </div>

      {{-- المفتاح --}}
      <div class="col-md-6">
        <label class="form-label">المفتاح (key) <span class="text-danger">*</span></label>
        <div class="input-group">
          <span class="input-group-text">key</span>
          <input type="text" name="key" id="cf_key" value="{{ old('key', $field->key ?? '') }}" class="form-control" placeholder="مثال: source" required>
        </div>
        <div class="form-text">سيُستخدم في الكود (snake_case). سيتم اقتراحه تلقائيًا من الاسم ويمكنك تعديله.</div>
        @error('key') <div class="text-danger small">{{ $message }}</div> @enderror
      </div>

      {{-- النوع --}}
      <div class="col-md-4">
        <label class="form-label">النوع <span class="text-danger">*</span></label>
        <select name="type" id="cf_type" class="form-select" required>
          @foreach($types as $t)
            <option value="{{ $t }}" @selected($currentType===$t)>{{ $t }}</option>
          @endforeach
        </select>
        @error('type') <div class="text-danger small">{{ $message }}</div> @enderror
      </div>

      {{-- ينطبق على (موديل) --}}
      <div class="col-md-8">
        <label class="form-label">ينطبق على (الموديل) <span class="text-danger">*</span></label>
        <select name="applies_to" id="cf_applies_to" class="form-select js-select2" data-placeholder="اختر الموديل" required>
          <option value=""></option>
          @foreach($modelChoices as $fqcn => $label)
            <option value="{{ $fqcn }}" @selected($currentModel===$fqcn)>{{ $label }} — <code>{{ $fqcn }}</code></option>
          @endforeach
        </select>
        <div class="form-text">حدّد الموديل الذي يتبع له الحقل (إنت تحدد هو تابع لإيه).</div>
        @error('applies_to') <div class="text-danger small">{{ $message }}</div> @enderror
      </div>

      {{-- المجموعة --}}
      <div class="col-md-6">
        <label class="form-label">المجموعة (اختياري)</label>
        <input type="text" name="group" value="{{ old('group', $field->group ?? '') }}" class="form-control" placeholder="مثال: معلومات إضافية">
        @error('group') <div class="text-danger small">{{ $message }}</div> @enderror
      </div>

      {{-- ترتيب --}}
      <div class="col-md-3">
        <label class="form-label">ترتيب العرض</label>
        <input type="number" name="sort_order" value="{{ old('sort_order', $field->sort_order ?? 0) }}" class="form-control" min="0">
        @error('sort_order') <div class="text-danger small">{{ $message }}</div> @enderror
      </div>

      {{-- إلزامي --}}
      <div class="col-md-3">
        <label class="form-label">إلزامي؟</label>
        <div class="form-check form-switch mt-1">
          <input class="form-check-input" type="checkbox" name="is_required" value="1" id="is_required" @checked(old('is_required', $field->is_required ?? false))>
          <label class="form-check-label" for="is_required">نعم</label>
        </div>
      </div>

      {{-- المساعدة --}}
      <div class="col-md-12">
        <label class="form-label">مساعدة (اختياري)</label>
        <input type="text" name="help_text" value="{{ old('help_text', $field->help_text ?? '') }}" class="form-control">
        @error('help_text') <div class="text-danger small">{{ $message }}</div> @enderror
      </div>

      {{-- ===== خيارات للأنواع select/multiselect ===== --}}
      <div class="col-12" id="cf_choices_wrap" style="display:none;">
        <div class="d-flex align-items-center justify-content-between mb-2">
          <label class="form-label mb-0">الاختيارات (للـ select/multiselect)</label>
          <div class="d-flex gap-2">
            <button type="button" class="btn btn-sm btn-outline-secondary" id="btn_add_choice"><i class="tio-add"></i> إضافة اختيار</button>
            <button type="button" class="btn btn-sm btn-outline-primary" id="btn_fill_sample">ملء مثال</button>
          </div>
        </div>

        <div class="table-responsive mb-2">
          <table class="table table-sm align-middle mb-0" id="choices_table">
            <thead class="table-light">
              <tr>
                <th style="width:40%">المعرف (id)</th>
                <th style="width:50%">الاسم الظاهر (name)</th>
                <th class="text-center" style="width:10%">#</th>
              </tr>
            </thead>
            <tbody><!-- filled by JS --></tbody>
          </table>
        </div>
        <div class="small text-muted">ملاحظة: سيتم تخزين الخيارات داخل <code>options.choices</code> كـ JSON.</div>
      </div>

      {{-- خيارات/إعدادات (JSON) --}}
      <div class="col-md-12">
        <label class="form-label d-flex align-items-center gap-2">
          <span>الخيارات/الإعدادات (JSON)</span>
          <span id="options_state" class="badge bg-secondary">غير مُتحقق</span>
        </label>
        <textarea name="options" id="cf_options" class="form-control" rows="4"
          placeholder='{"choices":[{"id":"hot","name":"Hot"},{"id":"cold","name":"Cold"}]}'>{{ old('options', isset($field)? json_encode($field->options, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) : '') }}</textarea>
        @error('options') <div class="text-danger small">{{ $message }}</div> @enderror
      </div>

      {{-- القيمة الافتراضية (JSON) --}}
      <div class="col-md-12">
        <label class="form-label d-flex align-items-center gap-2">
          <span>القيمة الافتراضية (JSON)</span>
          <span id="default_state" class="badge bg-secondary">غير مُتحقق</span>
        </label>
        <textarea name="default_value" id="cf_default" class="form-control" rows="3">{{ old('default_value', isset($field)? json_encode($field->default_value, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) : '') }}</textarea>
        @error('default_value') <div class="text-danger small">{{ $message }}</div> @enderror
      </div>

      {{-- مفعّل --}}
      <div class="col-md-12">
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" @checked(old('is_active', $field->is_active ?? true))>
          <label class="form-check-label" for="is_active">مفعّل</label>
        </div>
      </div>

    </div>
  </div>
</div>

{{-- Styles بسيطة --}}
<style>
  .breadcrumb { margin-bottom: 0; }
  .input-group-text { min-width: 52px; justify-content: center; }
  #choices_table input { height: 36px; }
  .table-sm th, .table-sm td { padding: .45rem .6rem; }
</style>

{{-- Select2 (لو متاح في layout يكفي class) --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.full.min.js"></script>

<script>
(function(){
  const $ = window.jQuery || undefined;

  // ===== Select2 للموديل =====
  if ($ && typeof $.fn.select2 === 'function') {
    $('.js-select2').select2({ dir:'rtl', width:'100%', allowClear:true, placeholder:function(){return $(this).data('placeholder')||''} });
  }

  // ===== اقتراح key من الاسم (snake_case) =====
  const $name = document.getElementById('cf_name');
  const $key  = document.getElementById('cf_key');

  function toSnake(str){
    return String(str || '')
      .trim()
      .normalize('NFKD')       // إزالة تشكيل/أحرف مركبة
      .replace(/[^\w\s-]+/g,'') // حذف رموز
      .replace(/[\s-]+/g,'_')   // مسافات/شرط لشرطة سفلية
      .toLowerCase();
  }
  let keyTouched = !!$key.value; // لو المستخدم غيّره يدويًا، لا نكتب فوقه
  $key.addEventListener('input', () => keyTouched = true);
  $name.addEventListener('input', () => { if(!keyTouched){ $key.value = toSnake($name.value); } });

  // ===== إظهار/إخفاء قسم الاختيارات حسب النوع =====
  const $type = document.getElementById('cf_type');
  const $choicesWrap = document.getElementById('cf_choices_wrap');
  const $optionsTA = document.getElementById('cf_options');
  const $defaultTA = document.getElementById('cf_default');
  const $optState = document.getElementById('options_state');
  const $defState = document.getElementById('default_state');

  function shouldShowChoices(t){
    return t === 'select' || t === 'multiselect';
  }

  function parseJSONSafe(txt){
    if(!txt || !txt.trim()) return null;
    try { return JSON.parse(txt); } catch(e){ return false; }
  }

  function setBadge($el, ok){
    $el.className = 'badge ' + (ok === true ? 'bg-success' : ok === false ? 'bg-danger' : 'bg-secondary');
    $el.textContent = ok === true ? 'صحيح' : ok === false ? 'JSON غير صالح' : 'غير مُتحقق';
  }

  // ===== Choices Builder =====
  const $choicesTable = document.getElementById('choices_table').querySelector('tbody');
  const $btnAdd = document.getElementById('btn_add_choice');
  const $btnSample = document.getElementById('btn_fill_sample');

  function readChoicesFromOptions(){
    const data = parseJSONSafe($optionsTA.value);
    if (data && data.choices && Array.isArray(data.choices)) {
      return data.choices.map(c => ({id: String(c.id ?? ''), name: String(c.name ?? '')}));
    }
    return [];
  }

  function syncOptionsFromBuilder(){
    const rows = [...$choicesTable.querySelectorAll('tr')];
    const choices = rows.map(tr => {
      return {
        id: tr.querySelector('input[data-col="id"]').value.trim(),
        name: tr.querySelector('input[data-col="name"]').value.trim()
      }
    }).filter(x => x.id || x.name);
    const obj = { choices: choices };
    $optionsTA.value = JSON.stringify(obj, null, 2);
    validateTextareas(); // تحديث حالة الشارات
  }

  function addChoiceRow(idVal = '', nameVal = ''){
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td><input type="text" class="form-control form-control-sm" data-col="id"   value="${idVal}"></td>
      <td><input type="text" class="form-control form-control-sm" data-col="name" value="${nameVal}"></td>
      <td class="text-center">
        <button type="button" class="btn btn-sm btn-light btn-del-choice" title="حذف"><i class="tio-clear"></i></button>
      </td>
    `;
    $choicesTable.appendChild(tr);
  }

  function fillBuilderFromOptions(){
    $choicesTable.innerHTML = '';
    const choices = readChoicesFromOptions();
    choices.forEach(c => addChoiceRow(c.id, c.name));
  }

  function ensureSample(){
    const data = parseJSONSafe($optionsTA.value);
    if (!data || !Array.isArray(data.choices) || !data.choices.length) {
      $optionsTA.value = JSON.stringify({
        choices: [
          {id: 'hot',  name: 'Hot'},
          {id: 'cold', name: 'Cold'}
        ]
      }, null, 2);
    }
  }

  function toggleChoicesUI(){
    const show = shouldShowChoices($type.value);
    $choicesWrap.style.display = show ? '' : 'none';
    if(show){
      ensureSample();
      fillBuilderFromOptions();
    }
  }

  // ===== تحقق JSON لحظي =====
  function validateTextareas(){
    const opt = $optionsTA.value.trim();
    const def = $defaultTA.value.trim();

    // options
    if(!opt){ setBadge($optState, null); }
    else { setBadge($optState, parseJSONSafe(opt) !== false); }

    // default_value
    if(!def){ setBadge($defState, null); }
    else { setBadge($defState, parseJSONSafe(def) !== false); }
  }

  // Events
  $type.addEventListener('change', toggleChoicesUI);
  $optionsTA.addEventListener('input', () => { validateTextareas(); fillBuilderFromOptions(); });
  $defaultTA.addEventListener('input', validateTextareas);

  $btnAdd?.addEventListener('click', () => { addChoiceRow(); });
  $btnSample?.addEventListener('click', () => { ensureSample(); fillBuilderFromOptions(); validateTextareas(); });

  $choicesTable.addEventListener('input', (e) => {
    if(e.target.matches('input[data-col="id"], input[data-col="name"]')){
      syncOptionsFromBuilder();
    }
  });
  $choicesTable.addEventListener('click', (e) => {
    if(e.target.closest('.btn-del-choice')){
      e.target.closest('tr').remove();
      syncOptionsFromBuilder();
    }
  });

  // أول تحميل
  toggleChoicesUI();
  validateTextareas();
})();
</script>
