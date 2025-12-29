@php

  $isEdit = isset($log) && $log?->id;
@endphp

<div class="call-log-form" dir="rtl">
  <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">

    <div class="card-body p-4">
      {{-- Section: Basic Info --}}
      <div class="d-flex align-items-center mb-3">
        <span class="border-start border-3 border-secondary ps-2 fw-bold text-primary">المعلومات الأساسية</span>
      </div>

      <div class="row g-3">
        {{-- Lead --}}
        <div class="col-lg-6">
          <label class="form-label">العميل المحتمل (Lead) <span class="text-danger">*</span></label>
          <select name="lead_id" class="form-select js-select2" data-placeholder="اختر Lead" required>
            <option value=""></option>
            @foreach($leads as $ld)
              <option value="{{ $ld->id }}" @selected(old('lead_id', $log->lead_id ?? '')==$ld->id)>
                {{ $ld->contact_name ?: $ld->company_name }} — {{ $ld->country_code }} {{ $ld->phone }}
              </option>
            @endforeach
          </select>
          @error('lead_id') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        {{-- Admin --}}
        <div class="col-lg-6">
          <label class="form-label">المسؤول</label>
          <select name="admin_id" class="form-select js-select2" data-placeholder="اختر المسؤول">
            <option value=""></option>
            @foreach($admins as $ad)
              <option value="{{ $ad->id }}" @selected(old('admin_id', $log->admin_id ?? ($defaultAdminId ?? ''))==$ad->id)>{{ $ad->email }}</option>
            @endforeach
          </select>
          @error('admin_id') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        {{-- Outcome --}}
        <div class="col-lg-6">
          <label class="form-label">النتيجة</label>
          <select name="outcome_id" class="form-select js-select2" data-placeholder="اختر النتيجة">
            <option value=""></option>
            @foreach($outcomes as $o)
              <option value="{{ $o->id }}" @selected(old('outcome_id', $log->outcome_id ?? '')==$o->id)>{{ $o->name }}</option>
            @endforeach
          </select>
          @error('outcome_id') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        {{-- Direction (Radio Group) --}}
        <div class="col-lg-6">
          @php $dir = old('direction', $log->direction ?? 'out'); @endphp
          <label class="form-label mb-2">الاتجاه</label>
          <div class="btn-group" role="group" aria-label="الاتجاه">
            <input type="radio" class="btn-check" name="direction" id="dir-out" value="out" @checked($dir==='out')>
            <label class="btn btn-outline-secondary" for="dir-out">صادرة</label>

            <input type="radio" class="btn-check" name="direction" id="dir-in" value="in" @checked($dir==='in')>
            <label class="btn btn-outline-secondary" for="dir-in">واردة</label>

            <input type="radio" class="btn-check" name="direction" id="dir-missed" value="missed" @checked($dir==='missed')>
            <label class="btn btn-outline-secondary" for="dir-missed">فائتة</label>
          </div>
          @error('direction') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
        </div>

        {{-- Channel (Radio Group) --}}
        <div class="col-lg-6">
          @php $ch = old('channel', $log->channel ?? 'phone'); @endphp
          <label class="form-label mb-2">القناة</label>
          <div class="btn-group" role="group" aria-label="القناة">
            <input type="radio" class="btn-check" name="channel" id="ch-phone" value="phone" @checked($ch==='phone')>
            <label class="btn btn-outline-secondary" for="ch-phone">هاتف</label>

            <input type="radio" class="btn-check" name="channel" id="ch-whatsapp" value="whatsapp" @checked($ch==='whatsapp')>
            <label class="btn btn-outline-secondary" for="ch-whatsapp">واتساب</label>

            <input type="radio" class="btn-check" name="channel" id="ch-sms" value="sms" @checked($ch==='sms')>
            <label class="btn btn-outline-secondary" for="ch-sms">SMS</label>
          </div>
          @error('channel') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
        </div>

        {{-- From phone (optional) --}}
        <div class="col-lg-6">
          <label class="form-label">الهاتف المستخدم (اختياري)</label>
          <div class="input-group">
            <span class="input-group-text">📞</span>
            <input type="text" name="phone_used" class="form-control" value="{{ old('phone_used', $log->phone_used ?? '') }}" placeholder="+20...">
          </div>
          @error('phone_used') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        {{-- Recording (optional) --}}
        <div class="col-lg-6">
          <label class="form-label">رابط التسجيل (اختياري)</label>
          <div class="input-group">
            <span class="input-group-text">🔗</span>
            <input type="url" name="recording_url" class="form-control" value="{{ old('recording_url', $log->recording_url ?? '') }}" placeholder="https://...">
          </div>
          @error('recording_url') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>
      </div>

      <hr class="my-4">

      {{-- Section: Timing & Duration --}}
      <div class="d-flex align-items-center mb-3">
        <span class="border-start border-3 border-secondary ps-2 fw-bold text-primary">التوقيت والمدة</span>
      </div>

      <div class="row g-3 align-items-end">
        {{-- Started --}}
        <div class="col-md-3">
          <label class="form-label d-flex align-items-center justify-content-between">
            <span>بداية المكالمة</span>
            <button type="button" class="btn btn-sm btn-outline-primary set-now" data-target="started_at">الآن</button>
          </label>
          <input type="datetime-local" name="started_at" id="started_at" class="form-control" value="{{ old('started_at', optional($log->started_at ?? null)?->format('Y-m-d\TH:i')) }}">
          @error('started_at') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        {{-- Ended --}}
        <div class="col-md-3">
          <label class="form-label d-flex align-items-center justify-content-between">
            <span>نهاية المكالمة</span>
            <div class="d-flex gap-2">
              <button type="button" class="btn btn-sm btn-outline-primary set-now" data-target="ended_at">الآن</button>
              <button type="button" class="btn btn-sm btn-outline-secondary copy-start-to-end" title="اجعل النهاية = البداية">= البداية</button>
            </div>
          </label>
          <input type="datetime-local" name="ended_at" id="ended_at" class="form-control" value="{{ old('ended_at', optional($log->ended_at ?? null)?->format('Y-m-d\TH:i')) }}">
          @error('ended_at') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        {{-- Duration (auto) --}}
        <div class="col-md-6">
          <label class="form-label">المدة (تُحسب تلقائيًا)</label>
          <div class="input-group">
            <span class="input-group-text">⏱️</span>
            <input class="form-control" id="duration_human" value="—" readonly>
            <span class="input-group-text" id="duration_seconds">0s</span>
          </div>
          <input type="hidden" name="duration_sec" id="duration_sec" value="{{ old('duration_sec', $log->duration_sec ?? '') }}">
          <div class="form-text" id="duration_warn"></div>
        </div>
      </div>

      <hr class="my-4">

      {{-- Section: Notes & Follow-up --}}
      <div class="d-flex align-items-center mb-3">
        <span class="border-start border-3 border-secondary ps-2 fw-bold text-primary">الملاحظات والمتابعة</span>
      </div>

      <div class="row g-3">
        <div class="col-12">
          <label class="form-label">ملاحظات</label>
          <textarea name="notes" rows="4" class="form-control" placeholder="ملخص المكالمة، الاعتراضات، نقاط الاتفاق، الخطوات التالية…">{{ old('notes', $log->notes ?? '') }}</textarea>
          @error('notes') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-4">
          <label class="form-label">المتابعة التالية</label>
          <input type="datetime-local" name="next_action_at" id="next_action_at" class="form-control" value="{{ old('next_action_at', optional($log->next_action_at ?? null)?->format('Y-m-d\TH:i')) }}">
          @error('next_action_at') <div class="text-danger small">{{ $message }}</div> @enderror
          <div class="small text-muted mt-1" id="next_action_hint"></div>
        </div>
      </div>

    </div>
  </div>
@include('admin-views.components.custom-fields', [
  'model' => $log ?? null,
  'appliesTo' => \App\Models\CallLog::class,
])

  {{-- Sticky Action Bar --}}
  <div class="sticky-actions d-flex justify-content-end align-items-center gap-2">
    <a href="{{ route('admin.call-logs.index') }}" class="btn btn-light btn-lg px-4">رجوع</a>
    <button class="btn btn-primary btn-lg px-4">{{ $isEdit ? 'تحديث' : 'حفظ' }}</button>
  </div>
</div>

{{-- Assets --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
<style>
  .select2-container{ width:100%!important }
  .sticky-actions{ position:sticky; bottom:0; padding:12px 0; background:linear-gradient(180deg, rgba(255,255,255,0), #fff 45%); z-index:9; border-top:1px solid rgba(0,0,0,.075); }
  .form-label{ font-weight:600 }
  .input-group-text{ min-width:52px; justify-content:center }
  #duration_warn{ color:#b35c00 }

  /* Selected option becomes primary regardless of base class */
  .btn-check:checked + .btn,
  .btn-check:active + .btn,
  .btn.active {
    color:#fff; background-color: var(--bs-primary); border-color: var(--bs-primary);
  }
  /* Focus ring */
  .btn-check:focus + .btn,
  .btn:focus { outline: 0; box-shadow: 0 0 0 .2rem gray, .25); }
  /* Smooth transition */
  .btn { transition: all .15s ease-in-out; }
  .btn-check:checked + .btn, .btn-check:active + .btn, .btn.active {
    color: #fff;
    background-color:gray;
    border-color: var(--bs-primary);
}
</style>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.full.min.js"></script>
<script>
  (function(){
    const $ = window.jQuery;

    // Select2 (RTL + Bootstrap theme)
    $('.js-select2').each(function(){
      const $el = $(this);
      $el.select2({ dir:'rtl', width:'100%', theme:'bootstrap-5', allowClear:true, placeholder:$el.data('placeholder')||'' });
    });

    const $start = $('#started_at'), $end = $('#ended_at');
    const $sec   = $('#duration_sec'), $human = $('#duration_human'), $secTxt = $('#duration_seconds'), $warn = $('#duration_warn');
    const $dir   = $('input[name="direction"]');
    const $nextAt= $('#next_action_at'), $nextHint = $('#next_action_hint');

    function toDate(v){ if(!v) return null; return new Date(v); }
    function pad(n){ return String(n).padStart(2,'0'); }
    function fmtHMS(s){ s=Math.max(0,Math.floor(s)); const h=Math.floor(s/3600), m=Math.floor((s%3600)/60), ss=s%60; return (h?h+':':'')+pad(m)+':'+pad(ss); }

    function calcDuration(){
      const ds = toDate($start.val()), de = toDate($end.val());
      $warn.text('');
      if(!ds || !de){ $human.val('—'); $secTxt.text('0s'); $sec.val(''); return; }
      const diff = (de - ds)/1000; // seconds
      if(diff < 0){ $warn.text('تحذير: النهاية قبل البداية'); }
      const sec = Math.max(0, Math.floor(diff));
      $human.val(fmtHMS(sec));
      $secTxt.text(sec+'s');
      $sec.val(sec);
      // sanity check
      const dirVal = $('input[name="direction"]:checked').val();
      if(sec===0 && dirVal !== 'missed'){
        $warn.text('مدة 0 ثانية — هل هذه مكالمة فائتة؟ غيّر "الاتجاه" إلى فائتة لو لزم.');
      } else if(sec>8*3600){
        $warn.text('تحذير: مدة أطول من 8 ساعات تبدو غير طبيعية.');
      }
      if(ds){ $end.attr('min', $start.val()); }
    }

    function setNow(targetId){
      const now = new Date();
      const v = now.getFullYear()+"-"+pad(now.getMonth()+1)+"-"+pad(now.getDate())+"T"+pad(now.getHours())+":"+pad(now.getMinutes());
      $('#'+targetId).val(v).trigger('input').trigger('change');
    }

    // Buttons "now"
    $(document).on('click','.set-now', function(){ setNow($(this).data('target')); });
    // Copy start -> end
    $('.copy-start-to-end').on('click', function(){ $end.val($start.val()).trigger('input').trigger('change'); });

    // Recalculate on changes
    $start.on('change input', calcDuration);
    $end.on('change input',   calcDuration);
    $dir.on('change',         calcDuration);
    calcDuration();

    // Next action human hint
    function updateNextHint(){
      const v = $nextAt.val();
      if(!v){ $nextHint.text(''); return; }
      const dt = new Date(v), now = new Date();
      const diffMs = dt - now; const diffMin = Math.round(diffMs/60000);
      if(Number.isNaN(diffMin)) { $nextHint.text(''); return; }
      const abs = Math.abs(diffMin), h = Math.floor(abs/60), m = abs%60;
      const phr = (h? h+' ساعة ':'') + (m? m+' دقيقة':'');
      $nextHint.text(diffMin>=0 ? ('بعد '+phr) : ('منذ '+phr));
    }
    $nextAt.on('change input', updateNextHint);
    updateNextHint();
  })();
</script>
