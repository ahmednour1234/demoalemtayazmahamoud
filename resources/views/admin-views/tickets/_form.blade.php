@php
  // لو $admins مش متبعت من الكنترولر، هنجلبه هنا بسرعة
  $admins = $admins ?? \App\Models\Admin::select('id','name','email')->orderBy('name')->get();
@endphp

<div class="row g-3">
  <div class="col-md-3">
    <label class="form-label">الكود</label>
    <input type="text" name="code" value="{{ old('code', $ticket->code ?? '') }}" class="form-control" placeholder="اختياري">
    @error('code')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>

  <div class="col-md-9">
    <label class="form-label">العنوان</label>
    <input type="text" name="title" value="{{ old('title', $ticket->title ?? '') }}" class="form-control" required>
    @error('title')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>

  <div class="col-12">
    <label class="form-label">الوصف</label>
    <textarea name="description" rows="5" class="form-control" placeholder="تفاصيل التذكرة">{{ old('description', $ticket->description ?? '') }}</textarea>
    @error('description')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>

  <div class="col-md-4">
    <label class="form-label">تعيين إلى (اختياري)</label>
    <select name="assign_to" class="form-select">
      <option value="">— لا يوجد —</option>
      @foreach($admins as $a)
        <option value="{{ $a->id }}" @selected(old('assign_to', $ticket->currentAssignee?->admin_id ?? null)==$a->id)>
          {{ $a->name ?? $a->email }}
        </option>
      @endforeach
    </select>
    @error('assign_to')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>
</div>

<div class="mt-3 d-flex gap-2">
  <button class="btn btn-primary">{{ $submitLabel ?? 'حفظ' }}</button>
  <a href="{{ route('admin.tickets.index') }}" class="btn btn-light">رجوع</a>
</div>
