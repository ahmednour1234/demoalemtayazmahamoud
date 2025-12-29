<div id="editAccountFormContainer" class="mt-1" style="display: none;">
    <div class="card-header bg-white d-flex align-items-center justify-content-between">
        <div>
            <h5 class="mb-0"><i class="tio-edit"></i> تعديل الحساب</h5>
            <small id="editAccountName" class="text-muted d-block mt-1"></small>
        </div>
        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="hideEditAccountForm()">إغلاق</button>
    </div>

    <div class="card-body">
        <form action="{{ route('admin.account.update', ['id' => '__ID__']) }}"
              id="editAccountForm" method="post">
            @csrf
            @method('POST')

            <input type="hidden" id="edit_account_id" name="id" value="">
            {{-- نجعل رقم الحساب حقلًا مخفيًا لتجنّب أخطاء JS إذا لم ترغب بإظهاره --}}
            <input type="hidden" name="account_number" id="edit_account_number" value="">

            <div class="form-group">
                <label>عنوان الحساب</label>
                <input type="text" name="account" id="edit_account" class="form-control" required>
            </div>

            <div class="form-group">
                <label>وصف الحساب</label>
                <input type="text" name="description" id="edit_description" class="form-control">
            </div>

            {{-- ✅ Checkbox لتحديد cost_center --}}
            <div class="form-group mt-3">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="edit_costCenterCheckbox">
                    <label class="form-check-label" for="edit_costCenterCheckbox">يَستخدم مركز تكلفة</label>
                </div>
                <small class="text-muted d-block mt-1">عند التفعيل، سيتم إرسال cost_center = 1، وإلا 0.</small>
            </div>

            {{-- مكان عرض الأخطاء --}}
            <div id="editAccountFormErrors" class="alert alert-danger d-none mt-3" role="alert"></div>

            <div class="d-flex justify-content-end mt-5">
                <button type="submit" class="btn btn-primary px-2 py-2 fs-5 w-25" id="editAccountSubmitBtn">
                    {{ \App\CPU\translate('تحديث') }}
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const editActionTemplate = @json(route('admin.account.update', ['id' => '__ID__']));

    function showEditAccountForm() {
        document.getElementById('editAccountFormContainer').style.display = 'block';
    }
    function hideEditAccountForm() {
        document.getElementById('editAccountFormContainer').style.display = 'none';
    }

    function initEditAccountForm(account) {
        const form  = document.getElementById('editAccountForm');
        const idInp = document.getElementById('edit_account_id');

        form.action = editActionTemplate.replace('__ID__', account.id);

        idInp.value = account.id || '';
        document.getElementById('editAccountName').textContent = account.account || '';
        document.getElementById('edit_account').value = account.account || '';
        document.getElementById('edit_description').value = account.description || '';
        document.getElementById('edit_account_number').value = account.account_number || '';

        // ✅ Checkbox cost_center
        document.getElementById('edit_costCenterCheckbox').checked = Number(account.cost_center) === 1;

        showEditAccountForm();
    }

    (function () {
        const form      = document.getElementById('editAccountForm');
        const errorsBox = document.getElementById('editAccountFormErrors');
        const submitBtn = document.getElementById('editAccountSubmitBtn');
        const costCb    = document.getElementById('edit_costCenterCheckbox');

        function getCsrfToken() {
            const meta = document.querySelector('meta[name="csrf-token"]');
            if (meta && meta.content) return meta.content;
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
                submitBtn.innerHTML = 'جارٍ التحديث...';
            } else {
                if (submitBtn.dataset.oldText) {
                    submitBtn.innerHTML = submitBtn.dataset.oldText;
                    delete submitBtn.dataset.oldText;
                }
            }
        }

        function formToJSON(frm) {
            const data = Object.fromEntries(new FormData(frm).entries());
            // سنرسل دائمًا كـ PUT عبر _method
            data._method = 'POST';
            // تطبيع cost_center من الـcheckbox
            data.cost_center = costCb && costCb.checked ? 1 : 0;
            // أبقِ الحقول الأخرى كما هي
            return data;
        }

        async function updateAccount(payload, { signal } = {}) {
            const url = form.getAttribute('action');
            const res = await fetch(url, {
                method: 'POST', // سنستخدم spoofing بـ _method=PUT
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

        if (form) {
            form.addEventListener('submit', async function (e) {
                e.preventDefault();
                showErrors(null);
                const payload = formToJSON(form);

                setLoading(true);
                try {
                    const { ok, status, data } = await updateAccount(payload);

                    if (ok && data?.status) {
                        if (window.toastr) window.toastr.success(data.message || 'تم التحديث بنجاح');
                        // بث حدث لتحديث الواجهة
                        document.dispatchEvent(new CustomEvent('account:updated', { detail: data.data }));
                        hideEditAccountForm();
                    } else {
                        const msg  = data?.message || 'تعذر تحديث البيانات.';
                        const errs = data?.errors || msg;
                        showErrors(errs);
                        if (window.toastr && status !== 422) window.toastr.error(msg);
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

        // — دالة Console —
        // مثال:
        // window.updateAccountFromConsole(5, {account:'صندوق رئيسي', description:'...', account_number:'1001', cost_center:1})
        window.updateAccountFromConsole = async function (id, fields) {
            const url = editActionTemplate.replace('__ID__', id);
            const payload = {
                _token: getCsrfToken(),
                _method: 'POST',
                account: fields.account,
                account_number: fields.account_number ?? '',
                description: fields.description ?? '',
                default_cost_center_id: fields.default_cost_center_id ?? null,
                cost_center: fields.cost_center ? 1 : 0
            };
            try {
                const res = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': getCsrfToken()
                    },
                    body: JSON.stringify(payload)
                });
                const data = await res.json().catch(()=>({}));
                console.log('[updateAccountFromConsole]', res.status, data);
                if (res.ok && data?.status) {
                    if (window.toastr) window.toastr.success(data.message || 'تم التحديث بنجاح');
                    document.dispatchEvent(new CustomEvent('account:updated', { detail: data.data }));
                } else {
                    if (window.toastr) window.toastr.error(data?.message || 'تعذر التحديث');
                }
                return { ok: res.ok, status: res.status, data };
            } catch (e) {
                if (window.toastr) window.toastr.error('تعذر الاتصال بالخادم.');
                console.error(e);
                return { ok: false, error: e };
            }
        };
    })();
</script>
