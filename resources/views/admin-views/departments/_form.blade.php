@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $err) <li>{{ $err }}</li> @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ $action }}">
    @csrf
    @if(($method ?? 'POST') !== 'POST') @method($method) @endif

    <div class="row g-3">
        <div class="col-md-4">
            <label class="form-label">الاسم</label>
            <input type="text" name="name" class="form-control"
                   value="{{ old('name', $department->name ?? '') }}" required maxlength="191" placeholder="اسم القسم">
        </div>

        <div class="col-md-4">
            <label class="form-label">الكود</label>
            <input type="text" name="code" class="form-control"
                   value="{{ old('code', $department->code ?? '') }}" required maxlength="64" placeholder="كود مختصر">
        </div>

        <div class="col-md-4">
            <label class="form-label">الحالة</label>
            <select name="active" class="form-select js-select2" required data-placeholder="اختر الحالة">
                <option value="1" @selected(old('active', $department->active ?? 1)==1)>نشط</option>
                <option value="0" @selected(old('active', $department->active ?? 1)==0)>متوقف</option>
            </select>
        </div>

        <div class="col-md-6">
            <label class="form-label">القسم الأب</label>
            <select name="parent_id" class="form-select js-select2" data-allow-clear="true" data-placeholder="— بدون —">
                <option value="">— بدون —</option>
                @foreach($parents as $p)
                    <option value="{{ $p->id }}" @selected(old('parent_id', $department->parent_id ?? null)==$p->id)>
                        {{ str_repeat('— ', $p->level) }} {{ $p->name }}
                    </option>
                @endforeach
            </select>
            <small class="text-muted">اتركه فارغًا لإنشاء قسم رئيسي.</small>
        </div>
    </div>

    <div class="mt-3 d-flex gap-2 text-start">
        <button class="btn btn-primary action-btn">حفظ</button>
        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary action-btn">إلغاء</a>
    </div>
</form>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.full.min.js"></script>
    <script>
        $(function () {
            $('.js-select2').each(function () {
                $(this).select2({
                    dir: 'rtl',
                    width: '100%',
                    allowClear: $(this).data('allow-clear') === true || $(this).data('allow-clear') === 'true',
                    placeholder: $(this).data('placeholder') || ''
                });
            });
        });
    </script>
