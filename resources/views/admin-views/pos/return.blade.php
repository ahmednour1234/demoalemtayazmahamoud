@extends('layouts.admin.app')
@section('content')
<div class="container">
           <div class="mb-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-white  rounded shadow-sm">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}" class="text-secondary">
                    <i class="tio-home-outlined"></i> {{ \App\CPU\translate('الرئيسية') }}
                </a>
            </li>
        
               <li class="breadcrumb-item">
                <a href="#" class="text-primary">
                    {{ \App\CPU\translate('المرتجعات') }}
                </a>
            </li>
        </ol>
    </nav>
</div>
{{-- صندوق إدخال رقم الفاتورة (ثابت ومتمركز) --}}
@if(!session()->has('orderDetails'))
  <div class="row justify-content-center mt-5 pt-5">
    <div class="col-12 col-md-8 col-lg-6">
      <div class="card mb-4 shadow-sm">
        <div class="card-header text-black text-center">
          ادخل رقم الفاتورة للمرتجع
        </div>
        <div class="card-body">
          <form id="returnForm" method="POST"
                action="{{ session('order_type') === 'service' ? route('admin.pos.processReturn_service') : route('admin.pos.processReturn') }}">
            @csrf
            <label for="invoice_number" class="form-label">رقم الفاتورة</label>
            <div class="input-group">
              <input type="text" class="form-control" name="invoice_number" id="invoice_number" required autofocus placeholder="اكتب رقم الفاتورة...">
              <button type="submit" class="btn btn-primary">
                اعرض المنتجات
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endif


  @if(session()->has('orderDetails'))
    @php
      $total_discount = 0;
      foreach(session('orderDetails.order_products') as $product) {
          $total_discount += $product->discount_on_product * $product->quantity;
      }
      $extraDiscount = session('extra_discount') ?? 0;
      $total_tax = session('total_tax') ?? 0;
      $orderAmount = (session('order_amount') ?? 0) + $extraDiscount + $total_discount - $total_tax;
      $orderAmount = $orderAmount > 0 ? $orderAmount : 1;
      $discountRatio = ($extraDiscount / $orderAmount) * 100;
    @endphp

    {{-- بطاقة بيانات العميل والفاتورة --}}
   <div class="row mt-4">
    <!-- بيانات العميل والفاتورة -->
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-secondary text-white">بيانات العميل والفاتورة</div>
            <div class="card-body">
                <p><strong>اسم العميل:</strong> {{ session('name') }}</p>
                <p><strong>رقم الهاتف:</strong> {{ session('mobile') }}</p>
                <p><strong>السجل التجاري:</strong> {{ session('c_history') }}</p>
                <p><strong>الرقم الضريبي:</strong> {{ session('tax_number') }}</p>
                <p><strong>مديونية العميل:</strong> {{ session('credit') }}</p>
                <p><strong>اسم كاتب الفاتورة:</strong> {{ session('seller') }}</p>
                <p><strong>تاريخ إنشاء الفاتورة:</strong> {{ session('created_at') }}</p>
            </div>
        </div>
    </div>

    <!-- ملخص الفاتورة النهائية -->
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-secondary text-white">ملخص الفاتورة النهائية</div>
            <div class="card-body">
                <p><strong>الإجمالي قبل الخصم الإضافي:</strong> 
                    {{ number_format((session('order_amount') ?? 0) + $total_discount + $extraDiscount - $total_tax, 2) }}
                </p>
                <p><strong>خصم المنتجات الإجمالي:</strong> {{ number_format($total_discount, 2) }}</p>
                <p><strong>الخصم الإضافي:</strong> {{ number_format($extraDiscount, 2) }}</p>
                <p><strong>الضريبة:</strong> {{ number_format($total_tax, 2) }}</p>
                @php $netInvoice = (session('order_amount') ?? 0); @endphp
                <p><strong>الصافي:</strong> {{ number_format($netInvoice, 2) }}</p>
            </div>
        </div>
    </div>
</div>


    {{-- بطاقة تفاصيل الفاتورة للمرتجع --}}
    <div class="card mt-4">
      <div class="card-header bg-secondary text-white">
        تفاصيل الفاتورة رقم: {{ session('orderDetails.order_id') }}
      </div>
      <div class="card-body">
        {{-- فورم المرتجع (مع ملاحظات + صورة) --}}
        <form id="returnInvoiceForm" method="POST" action="{{ route('admin.pos.processConfirmedReturn') }}" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="order_id" value="{{ session('orderDetails.order_id') }}">

          @php $isService = (session('order_type') ?? '') == "service"; @endphp

          <table class="table table-bordered">
            <thead>
              <tr>
                <th>اسم المنتج</th>
                <th>سعر الشراء / السعر الحالي</th>
                <th>سعر الوحدة (أساسي)</th>
                <th>خصم الوحدة</th>
                <th>الخصم الإضافي للمنتج</th>
                <th>الضريبة</th>
                <th>السعر النهائي للوحدة</th>
                <th>الكمية</th>
                <th>الإجمالي النهائي</th>
                @if(!$isService)
                  <th>الوحدة</th>
                @endif
                <th>كمية المرتجع</th>
              </tr>
            </thead>
            <tbody>
              @foreach(session('orderDetails.order_products') as $product)
                @php
                  $discountToEachProduct = $product->price * ($discountRatio / 100);
                  $finalUnitPrice = $product->price - $product->discount_on_product - $discountToEachProduct + $product->tax_amount;
                  $productFinalTotal = $finalUnitPrice * $product->quantity;
                  $productDetails = json_decode($product->product_details);
                  $unitValue = $productDetails->unit_value ?? 1;
                  $computedPurchasePrice = $product->product->purchase_price;

                  // السعر الحالي: لو الوحدة صغرى = سعر الوحدة * قيمة الوحدة
                  $currentPrice = $product->unit == 0 ? $product->price * $unitValue : $product->price;

                  // لو سعر الشراء أكبر من السعر الحالي نحط تنبيه لوني على الصف
                  $rowClass = $computedPurchasePrice > $currentPrice ? 'table-danger' : '';
                @endphp
                <tr class="{{ $rowClass }}" data-purchase-price="{{ $computedPurchasePrice }}" data-current-price="{{ $currentPrice }}">
                  <td>{{ $product->product->name }}</td>
                  <td>
                    <span class="text-primary">شراء: {{ number_format($computedPurchasePrice, 2) }}</span><br>
                    <span class="text-success">حالي: {{ number_format($currentPrice, 2) }}</span>
                  </td>
                  <td data-base-price="{{ $product->price }}">{{ number_format($product->price, 3) }}</td>
                  <td data-discount="{{ $product->discount_on_product }}">{{ number_format($product->discount_on_product, 3) }}</td>
                  <td data-extra-discount="{{ ($discountRatio/100) * $product->price }}">{{ number_format(($discountRatio/100) * $product->price, 3) }}</td>
                  <td data-tax="{{ $product->tax_amount }}">{{ number_format($product->tax_amount, 3) }}</td>
                  <td data-final-unit="{{ $finalUnitPrice }}">{{ $finalUnitPrice }}</td>
                  <td>{{ $product->quantity }}</td>
                  <td>{{ $productFinalTotal }}</td>

                  @if(!$isService)
                  <td>
                    @if($product->unit == 1)
                      {{-- لو الوحدة كبري نسمح بالتبديل لصغري --}}
                      <select name="return_unit[{{ $product->product_id }}]" id="return_unit_{{ $product->product_id }}" class="form-control"
                              onchange="updateHiddenUnit(this, '{{ $product->product_id }}'); setReturnQuantityMax(this, '{{ $product->product_id }}', {{ $unitValue }}, {{ $product->quantity }})">
                        <option value="1" selected>كبري</option>
                        <option value="0">صغري</option>
                      </select>
                      <input type="hidden" name="return_unit_hidden[{{ $product->product_id }}]" id="hidden_return_unit_{{ $product->product_id }}" value="1">
                    @else
                      <input type="hidden" name="return_unit[{{ $product->product_id }}]" value="{{ $product->unit }}">
                      <input type="hidden" name="return_unit_hidden[{{ $product->product_id }}]" value="{{ $product->unit }}">
                      <span>صغري</span>
                    @endif
                  </td>
                  @endif

                  <td>
                    <input type="number" id="return_quantity_{{ $product->product_id }}"
                           name="return_quantities[{{ $product->product_id }}]"
                           class="form-control return-qty"
                           value="0" min="0" step="1"
                           data-final-unit-price="{{ $finalUnitPrice }}"
                           data-unit-value="{{ $unitValue }}"
                           data-return-unit="1"
                           oninput="updateHiddenQuantity(this); validateReturnQuantity(this); updateReturnSummary();"
                           onkeyup="updateReturnSummary();"
                           onchange="updateReturnSummary();">
                    <input type="hidden" name="return_quantities_hidden[{{ $product->product_id }}]" id="hidden_return_quantity_{{ $product->product_id }}" value="0">
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>

          {{-- ملاحظات وصورة مرفقة (اختياري) --}}
          <div class="row g-3">
            <div class="col-12 col-md-8">
              <label for="return_note" class="form-label">ملاحظات على المرتجع (اختياري)</label>
              <textarea name="note" id="return_note" class="form-control" rows="3" placeholder="اكتب أي ملاحظات مهمة..."></textarea>
            </div>
            <div class="col-12 col-md-4">
              <label for="return_attachment" class="form-label">صورة مرفقة (اختياري)</label>
              <input type="file" name="attachment" id="return_attachment" class="form-control" accept="image/*" onchange="previewAttachment(this)">
              <small class="text-muted d-block mt-1">يسمح برفع صورة واحدة (PNG/JPG/JPEG).</small>
              <div id="attachment_preview" class="mt-2" style="display:none">
                <img src="" alt="Preview" class="img-thumbnail" style="max-height:160px">
              </div>
            </div>
          </div>

          {{-- أزرار التأكيد والتراجع --}}
{{-- شريط الأزرار الثلاثة (تأكيد / تراجع / تنفيذ) --}}
<div class="mt-3">
  <div class="action-bar d-flex align-items-center" style="gap:8px">
    <button type="button" id="confirmBtn" class="btn btn-secondary btn-eq" onclick="confirmForm()">تأكيد</button>
            <button type="button" id="undoBtn" class="btn btn-danger" onclick="undoConfirm()" style="display:none;">تراجع</button>
    <button type="submit" id="submitReturn" class="btn btn-primary btn-eq" disabled>تنفيذ المرتجع</button>
  </div>
</div>

        </form>
      </div>
    </div>

    {{-- مودال تحذير --}}
    <div class="modal fade" id="warningModal" tabindex="-1" role="dialog" aria-labelledby="warningModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header bg-danger text-white">
            <h5 class="modal-title" id="warningModalLabel">تحذير</h5>
          </div>
          <div class="modal-body">
            سعر الشراء اتغير وبقي أكبر من سعر المنتج الذي سيتم إرجاعه!
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">حسناً</button>
          </div>
        </div>
      </div>
    </div>

    {{-- بطاقة ملخص المرتجع --}}
    <div class="card mt-4" id="returnSummaryCard">
      <div class="card-header bg-secondary text-white">ملخص المرتجع</div>
      <div class="card-body">
        <p>إجمالي اسعار المرتجع: <span id="returnTotalProduct">0.00</span></p>
        <p>إجمالي خصم علي المرتجع: <span id="returnTotalDiscount">0.00</span></p>
        <p>إجمالي الخصم الإضافي: <span id="returnTotalExtraDiscount">0.00</span></p>
        <p>إجمالي الضريبة علي المرتجع: <span id="returnTotalTax">0.00</span></p>
        <p><strong>إجمالي المرتجع:</strong> <span id="returnTotalOverall">0.00</span></p>
      </div>
    </div>
  @endif
</div>
@endsection

{{-- JavaScript --}}
<script>
  // مزامنة اختيار الوحدة مع الحقل المخفي
  function updateHiddenUnit(selectElem, productId) {
    document.getElementById('hidden_return_unit_' + productId).value = selectElem.value;
  }
  // مزامنة كمية المرتجع مع الحقل المخفي
  function updateHiddenQuantity(inputElem) {
    var productId = inputElem.name.match(/\[(.*?)\]/)[1];
    document.getElementById('hidden_return_quantity_' + productId).value = inputElem.value;
  }

  // معاينة الصورة
  function previewAttachment(input){
    var previewWrap = document.getElementById('attachment_preview');
    var img = previewWrap.querySelector('img');
    if(input.files && input.files[0]){
      const file = input.files[0];
      img.src = URL.createObjectURL(file);
      previewWrap.style.display = 'block';
    }else{
      img.src = '';
      previewWrap.style.display = 'none';
    }
  }

  $(document).ready(function () {
    updateReturnSummary();

    // فحص الأسعار لكل صف
    $('tr[data-purchase-price]').each(function(){
      var purchasePrice = parseFloat($(this).data('purchase-price'));
      var currentPrice  = parseFloat($(this).data('current-price'));
      if (purchasePrice > currentPrice) {
        $('#warningModal').modal('show');
        return false;
      }
    });

    // تحديث الملخص عند التغيير
    $('select[name^="return_unit"]').on('change', updateReturnSummary);
    $('.return-qty').on('input change', updateReturnSummary);

    // إرسال المرتجع بـ AJAX مع ملف (FormData)
    $('#returnInvoiceForm').on('submit', function(e) {
      e.preventDefault();

      // لازم يكون تمّ التأكيد الأول
      if ($('#submitReturn').prop('disabled')) {
        toastr.warning('اضغط "تمام" لتأكيد القيم قبل التنفيذ.');
        return;
      }

      var formEl = this;
      var formData = new FormData(formEl); // يحتوي على _token + كل الحقول + الملف

      $.ajax({
        url: $(formEl).attr('action'),
        method: 'POST',
        data: formData,
        processData: false, // مهم للملفات
        contentType: false, // مهم للملفات
        success: function(response) {
          toastr.success(response.message || 'تم تنفيذ المرتجع بنجاح!');
          // خيار: إعادة تحميل أو تفريغ الحقول
          // location.reload();
        },
        error: function(xhr) {
          let msg = 'حدث خطأ أثناء تنفيذ المرتجع!';
          if (xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
          toastr.error(msg);
        }
      });
    });
  });

  // تغيير حد الكمية بناءً على الوحدة المختارة
  function setReturnQuantityMax(selectElem, productId, unitValue, originalQuantity) {
    var qtyInput = document.getElementById("return_quantity_" + productId);
    if (selectElem.value == "0") {
      qtyInput.dataset.returnUnit = "0"; // صغرى
      var newMax = originalQuantity * unitValue;
      qtyInput.setAttribute('max', newMax);
      if (parseFloat(qtyInput.value) > newMax) {
        qtyInput.value = newMax;
        updateHiddenQuantity(qtyInput);
      }
    } else {
      qtyInput.dataset.returnUnit = "1"; // كبرى
      qtyInput.value = "";
      qtyInput.setAttribute('max', originalQuantity);
      updateHiddenQuantity(qtyInput);
    }
    updateReturnSummary();
  }

  // التحقق من الحد الأقصى
  function validateReturnQuantity(inputElem) {
    var maxAllowed = parseFloat(inputElem.getAttribute('max'));
    var val = parseFloat(inputElem.value);
    if (val > maxAllowed) {
      inputElem.value = maxAllowed;
      updateHiddenQuantity(inputElem);
    }
    updateReturnSummary();
  }

  // تحديث ملخص المرتجع
  function updateReturnSummary() {
    var totalProduct = 0, totalDiscount = 0, totalExtraDiscount = 0, totalTax = 0, totalOverall = 0;
    var inputs = document.querySelectorAll('.return-qty');
    inputs.forEach(function(input) {
      var qty = parseFloat(input.value) || 0;
      var unitValue = parseFloat(input.getAttribute('data-unit-value')) || 1;
      var productPrice = parseFloat(input.closest('tr').querySelector('[data-base-price]').getAttribute('data-base-price')) || 0;
      var discountPerUnit = parseFloat(input.closest('tr').querySelector('[data-discount]').getAttribute('data-discount')) || 0;
      var extraDiscountPerUnit = parseFloat(input.closest('tr').querySelector('[data-extra-discount]').getAttribute('data-extra-discount')) || 0;
      var taxPerUnit = parseFloat(input.closest('tr').querySelector('[data-tax]').getAttribute('data-tax')) || 0;
      var returnUnit = input.dataset.returnUnit; // "1" كبري، "0" صغري

      if (returnUnit === "0") {
        productPrice       = productPrice / unitValue;
        discountPerUnit    = discountPerUnit / unitValue;
        extraDiscountPerUnit = extraDiscountPerUnit / unitValue;
        taxPerUnit         = taxPerUnit / unitValue;
      }

      var effectiveFinalUnit = productPrice - discountPerUnit - extraDiscountPerUnit + taxPerUnit;

      totalProduct   += qty * productPrice;
      totalDiscount  += qty * discountPerUnit;
      totalExtraDiscount += qty * extraDiscountPerUnit;
      totalTax       += qty * taxPerUnit;
      totalOverall   += qty * effectiveFinalUnit;
    });

    document.getElementById('returnTotalProduct').textContent       = totalProduct.toFixed(2);
    document.getElementById('returnTotalDiscount').textContent      = totalDiscount.toFixed(2);
    document.getElementById('returnTotalExtraDiscount').textContent = totalExtraDiscount.toFixed(2);
    document.getElementById('returnTotalTax').textContent           = totalTax.toFixed(2);
    document.getElementById('returnTotalOverall').textContent       = totalOverall.toFixed(2);
  }

  // تأكيد/تراجع: نقفل أرقام وكومبو فقط ونسيب الملاحظات/الصورة متاحة
  function confirmForm() {
    var formElements = document.querySelectorAll('#returnInvoiceForm input[type="number"], #returnInvoiceForm select');
    formElements.forEach(function(elem) { elem.disabled = true; });
    document.getElementById('confirmBtn').style.display = 'none';
    document.getElementById('undoBtn').style.display = 'inline-block';
    document.getElementById('submitReturn').disabled = false;
  }
  function undoConfirm() {
    var formElements = document.querySelectorAll('#returnInvoiceForm input[type="number"], #returnInvoiceForm select');
    formElements.forEach(function(elem) { elem.disabled = false; });
    document.getElementById('undoBtn').style.display = 'none';
    document.getElementById('confirmBtn').style.display = 'inline-block';
    document.getElementById('submitReturn').disabled = true;
  }
</script>
