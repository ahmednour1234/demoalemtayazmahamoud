<div id="subAccountFormContainer" class="mt-1" style="display: none;">
    <div class="card-header">
        <h5 class="mb-0">إضافة حساب فرعي</h5>
        <small id="selectedAccountName" class="text-muted d-block mt-1"></small>
    </div>

    <div class="card-body">
        <form id="addSubAccountForm" method="POST" action="{{ route('admin.account.store') }}">
            @csrf

            <input type="hidden" name="storage_id" id="storage_id">
            <input type="hidden" name="parent_id" id="add_parent_id">
            <input type="hidden" name="account_type" id="account_type">
            <input type="hidden" name="balance" value="0">

            <div class="form-group">
                <label>عنوان الحساب</label>
                <input type="text" name="account" class="form-control" required value="{{ old('account') }}">
            </div>

            <div class="form-group">
                <label>وصف الحساب</label>
                <input type="text" name="description" class="form-control" value="{{ old('description') }}">
            </div>

            {{-- إظهار/إخفاء للمندوب (افتراضي 0) --}}
            <div class="form-group d-none" id="type_toggle">
                <label class="me-3">
                    <input type="radio" name="type" value="0" {{ old('type', '0') === '0' ? 'checked' : '' }}>
                    يظهر للمندوب
                </label>
                <label>
                    <input type="radio" name="type" value="1" {{ old('type') === '1' ? 'checked' : '' }}>
                    لا يظهر للمندوب
                </label>
            </div>

            {{-- ✅ تفعيل/تعطيل مركز تكلفة فقط --}}
            <div class="form-group mt-3">
                <div class="form-check">
                    <input type="checkbox"
                           class="form-check-input"
                           id="useCostCenter"
                           {{ old('cost_center') ? 'checked' : '' }}>
                    <label class="form-check-label" for="useCostCenter">
                        يستخدم مركز تكلفة
                    </label>
                </div>
                {{-- الحقل الحقيقي الذي يُرسل (1/0) --}}
                <input type="hidden" name="cost_center" id="cost_center_hidden" value="{{ old('cost_center', 0) }}">
            </div>

            {{-- مكان عرض الأخطاء --}}
            <div id="subAccountFormErrors" class="alert alert-danger d-none mt-3" role="alert"></div>

            <div class="d-flex justify-content-end mt-5">
                <button type="submit" class="btn btn-primary px-2 py-2 fs-5 w-25" id="subAccountSubmitBtn">
                    {{ \App\CPU\translate('حفظ') }}
                </button>
            </div>
        </form>
    </div>
</div>

<script>
(function () {
    const form      = document.getElementById('addSubAccountForm');
    const cb        = document.getElementById('useCostCenter');
    const hid       = document.getElementById('cost_center_hidden');
    const errorsBox = document.getElementById('subAccountFormErrors');
    const submitBtn = document.getElementById('subAccountSubmitBtn');

    // -- مزامنة cost_center مع الـcheckbox --
    function syncCostCenter() {
        if (!cb || !hid) return;
        hid.value = cb.checked ? 1 : 0;
    }
    if (cb) {
        cb.addEventListener('change', syncCostCenter);
        syncCostCenter();
    }

    // -- أدوات مساعدة --
    function getCsrfToken() {
        const meta = document.querySelector('meta[name="csrf-token"]');
        if (meta && meta.content) return meta.content;
        // fallback: خده من الانبوت المخفي بتاع الفورم
        const inp = form.querySelector('input[name="_token"]');
        return inp ? inp.value : '';
    }

    function showErrors(errs) {
        if (!errorsBox) return;
        if (!errs) {
            errorsBox.classList.add('d-none');
            errorsBox.innerHTML = '';
            return;
        }
        let html = '';
        if (typeof errs === 'string') {
            html = `<div>${errs}</div>`;
        } else if (Array.isArray(errs)) {
            html = errs.map(e => `<div>${e}</div>`).join('');
        } else {
            // errs كائن {field: [msgs]}
            for (const [field, msgs] of Object.entries(errs)) {
                if (Array.isArray(msgs)) {
                    msgs.forEach(m => html += `<div>• ${m}</div>`);
                } else if (typeof msgs === 'string') {
                    html += `<div>• ${msgs}</div>`;
                }
            }
        }
        errorsBox.innerHTML = html || 'حدث خطأ غير متوقع.';
        errorsBox.classList.remove('d-none');
    }

    function setLoading(loading) {
        if (!submitBtn) return;
        submitBtn.disabled = !!loading;
        if (loading) {
            submitBtn.dataset.oldText = submitBtn.innerHTML;
            submitBtn.innerHTML = 'جارٍ الحفظ...';
        } else {
            if (submitBtn.dataset.oldText) {
                submitBtn.innerHTML = submitBtn.dataset.oldText;
                delete submitBtn.dataset.oldText;
            }
        }
    }

    function formToJSON(frm) {
        const data = Object.fromEntries(new FormData(frm).entries());
        // تطبيع القيم
        data.balance      = Number(data.balance ?? 0);
        data.parent_id    = data.parent_id ? Number(data.parent_id) : null;
        data.type         = (data.type === undefined || data.type === '') ? 0 : Number(data.type);
        data.cost_center  = Number(data.cost_center ?? 0);
        data.storage_id   = data.storage_id ? Number(data.storage_id) : null;
        // لو account_type مخفي تأكد أنه موجود
        // data.account_type لازم تكون واحدة من: asset, liability, equity, revenue, expense, other
        return data;
    }

    async function createAccount(payload, { signal } = {}) {
        const url = form.getAttribute('action');
        const res = await fetch(url, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken()
            },
            body: JSON.stringify(payload),
            signal
        });
        const data = await res.json().catch(() => ({}));
        return { ok: res.ok, status: res.status, data };
    }

    // -- إرسال AJAX --
    if (form) {
        form.addEventListener('submit', async function (e) {
            e.preventDefault();
            showErrors(null);

            const payload = formToJSON(form);

            setLoading(true);
            try {
                const { ok, status, data } = await createAccount(payload);

                if (ok && (status === 201 || status === 200) && data?.status) {
                    // نجاح
                    if (window.toastr) {
                        window.toastr.success(data.message || 'تم الحفظ بنجاح');
                    }
                    // بث حدث لتحديث شجرة الحسابات/القائمة بدون إعادة تحميل الصفحة
                    document.dispatchEvent(new CustomEvent('account:created', { detail: data.data }));

                    // إعادة ضبط الحقول النصية فقط
                    form.querySelector('input[name="account"]').value = '';
                    form.querySelector('input[name="description"]').value = '';

                    // ممكن تغلق النموذج لو عايز:
                    // document.getElementById('subAccountFormContainer').style.display = 'none';
                } else {
                    // فشل (422 فاليديشن أو 403 صلاحيات أو غيره)
                    const msg = data?.message || 'تعذر حفظ البيانات.';
                    const errs = data?.errors || msg;
                    showErrors(errs);
                    if (window.toastr && status !== 422) {
                        window.toastr.error(msg);
                    }
                }
            } catch (err) {
                showErrors('تعذر الاتصال بالخادم. حاول مجددًا.');
                if (window.toastr) window.toastr.error('تعذر الاتصال بالخادم.');
                console.error(err);
            } finally {
                setLoading(false);
            }
        });
    }

    // -- دالة جاهزة للاستخدام من الكونسول --
    // مثال:
    // window.createSubAccountFromConsole({ account: 'حساب خزنة', account_type: 'asset', parent_id: 12, cost_center: 1, type: 0, balance: 0 });
    window.createSubAccountFromConsole = async function (payload) {
        try {
            const { ok, status, data } = await createAccount(payload);
            console.log('[createSubAccountFromConsole]', { ok, status, data });
            if (ok && data?.status) {
                if (window.toastr) window.toastr.success(data.message || 'تم الحفظ بنجاح');
                document.dispatchEvent(new CustomEvent('account:created', { detail: data.data }));
            } else {
                if (window.toastr) window.toastr.error(data?.message || 'تعذر الحفظ');
            }
            return { ok, status, data };
        } catch (e) {
            if (window.toastr) window.toastr.error('تعذر الاتصال بالخادم.');
            console.error(e);
            return { ok: false, error: e };
        }
    };
})();
</script>
