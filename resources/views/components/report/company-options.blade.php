@props(['options' => []])

@php
    $c = $options['company'] ?? [];
@endphp

<div class="border rounded p-3 mb-3">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <strong>ملف الشركة</strong>
    </div>

    <div class="row">
        <div class="col-md-6 d-flex flex-column gap-2">
            <label class="d-flex align-items-center gap-2">
                <input type="checkbox" name="company_logo" value="1" {{ ($c['logo'] ?? request()->boolean('company_logo')) ? 'checked':'' }}>
                <span>شعار الشركة</span>
            </label>

            <label class="d-flex align-items-center gap-2">
                <input type="checkbox" name="company_address" value="1" {{ ($c['address'] ?? request()->boolean('company_address')) ? 'checked':'' }}>
                <span>العنوان</span>
            </label>

              <label class="d-flex align-items-center gap-2">
                <input type="checkbox" name="company_cr" value="1" {{ ($c['cr'] ?? request()->boolean('company_cr')) ? 'checked':'' }}>
                <span>رقم التسجيل التجاري</span>
            </label>
        </div>

        <div class="col-md-6 d-flex flex-column gap-2">
   

            <label class="d-flex align-items-center gap-2">
                <input type="checkbox" name="company_email" value="1" {{ ($c['email'] ?? request()->boolean('company_email')) ? 'checked':'' }}>
                <span>البريد الإلكتروني</span>
            </label>

            <label class="d-flex align-items-center gap-2">
                <input type="checkbox" name="company_phone" value="1" {{ ($c['phone'] ?? request()->boolean('company_phone')) ? 'checked':'' }}>
                <span>رقم الاتصال</span>
            </label>

            <label class="d-flex align-items-center gap-2">
                <input type="checkbox" name="company_tax" value="1" {{ ($c['tax'] ?? request()->boolean('company_tax')) ? 'checked':'' }}>
                <span>الرقم الضريبي</span>
            </label>
        </div>
    </div>
</div>
