<style>
.account-tree-card {
    background:#fff; border:1px solid #ccc; padding:0; border-radius:6px;
    max-height:600px; overflow-y:auto; position:relative;
}
.account-tree-header-fixed {
    position:sticky; top:0; background:#fff; padding:10px; border-bottom:1px solid #eee; z-index:10;
}
.account-tree-header-buttons { display:flex; gap:10px; margin-bottom:8px; flex-wrap:wrap }
.account-tree-header-buttons a {
    padding:4px 10px; background:#f3f3f3; border-radius:6px; text-decoration:none; font-size:14px; color:#333;
    border:1px solid #e5e7eb
}
.account-tree-header-buttons a:hover { background:#eef2ff }
.account-tree-header-buttons a.disabled { opacity:.5; pointer-events:none }
.account-tree-header-buttons a.danger { background:#fee2e2; color:#991b1b; border-color:#fecaca }
.account-tree-header-buttons a.danger:hover { background:#fecaca }
.search-input {
    width:100%; padding:6px 10px; padding-top:4px; margin-top:10px; margin-bottom:10px;
    border:1px solid #ddd; border-radius:4px;
}
.account-header {
    font-weight:300; padding:10px; cursor:pointer; background:#f7f7f7; border-top:1px solid #eee;
    display:flex; justify-content:space-between; align-items:center;
}
.account-list { list-style:none; padding-left:20px; margin:0; }
.account-list li { padding:6px 10px; cursor:pointer; transition:.3s; }
.account-list li.selected { font-weight:bold; background:#f8fafc; border-radius:4px }
.toggle-btn { font-weight:bold; margin-left:8px; cursor:pointer; }

.search-tree { padding:10px; border-bottom:1px solid #eee; }
.account-list { list-style:none; margin:0; padding-right:0; position:relative; }
.account-list li {
    padding:6px 20px 6px 8px; margin:2px 0; position:relative; border-radius:4px; text-align:right; font-size:12px;
}
.account-list li::before {
    content:""; position:absolute; top:0; bottom:0; right:10px; width:.5px; background-color:#000;
}
.toggle-btn { cursor:pointer; float:right; font-weight:bold; }
.text-muted { color:#999; padding:10px; font-style:italic; }
</style>

<div class="account-tree-card">
    <div class="account-tree-header-fixed">
        <div class="account-tree-header-buttons">
            <a href="#" id="addAccountBtn">➕ إضافة</a>
            <a href="#" id="editAccountBtn" class="disabled">✏️ تعديل</a>
            <a href="#" id="deleteAccountBtn" class="danger disabled">🗑️ حذف</a>
            <a href="#" onclick="location.reload()">🔄 تحديث</a>
        </div>

        <input type="text" id="accountSearchInput" class="search-input" placeholder="🔍 ابحث باسم الحساب...">
    </div>

    <div id="searchTree" class="search-tree" style="display:none;"></div>

    @foreach ($accountTypes as $type)
        <div class="account-header" onclick="toggleAccounts('{{ $type }}')">
            <span>
                @switch($type)
                    @case('asset') الأصول @break
                    @case('liability') خصوم @break
                    @case('equity') حقوق الملكية @break
                    
                                        @case('expense') المصروفات @break
                    @case('revenue') الإيرادات @break
                    @default أخرى
                @endswitch
            </span>
            <span id="toggle-{{ $type }}" class="toggle-btn">+</span>
        </div>
        <ul class="account-list" id="list-{{ $type }}"></ul>
    @endforeach
</div>

{{-- فورم الحذف المخفي --}}
<form id="deleteAccountForm" action="{{ route('admin.account.destroy', ['id' => '__ID__']) }}" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
</form>

@push('script')
<script>
let selectedAccount = null;

// تمكين/تعطيل أزرار حسب الاختيار
function updateToolbarState() {
    const editBtn   = document.getElementById('editAccountBtn');
    const delBtn    = document.getElementById('deleteAccountBtn');

    if (selectedAccount && selectedAccount.id) {
        editBtn.classList.remove('disabled');
        delBtn.classList.remove('disabled');
    } else {
        editBtn.classList.add('disabled');
        delBtn.classList.add('disabled');
    }
}

// تمييز العنصر المحدد
function highlightSelected(clickedLi) {
    document.querySelectorAll('.account-list li.selected').forEach(el => el.classList.remove('selected'));
    if (clickedLi) clickedLi.classList.add('selected');
    updateToolbarState();
}

// تحميل حسابات النوع/الأبناء
function toggleAccounts(key, isParent = false) {
    const listId  = 'list-' + key;
    const toggleId= 'toggle-' + key;
    const list    = document.getElementById(listId);
    const toggle  = document.getElementById(toggleId);
    const url     = "{{ route('chart.accounts.fetch') }}" + "?" + (isParent ? 'parent_id' : 'type') + "=" + key;

    if (!list || !toggle) return;

    if (list.style.display === 'block') {
        list.style.display = 'none';
        toggle.textContent = '+';
        return;
    }

    fetch(url)
      .then(res => res.json())
      .then(data => {
          list.innerHTML = '';

          if (!Array.isArray(data) || data.length === 0) {
              list.innerHTML = `<li class="text-muted">لا يوجد حسابات.</li>`;
          } else {
              data.forEach(account => {
                  const li = document.createElement('li');

                  const textSpan = document.createElement('span');
                  textSpan.textContent = `${account.account} (${account.code ?? '-'})`;
                  textSpan.style.cursor = 'pointer';
                  textSpan.addEventListener('click', function (e) {
                      e.stopPropagation();
                      selectedAccount = account; // يتضمن default_cost_center_id إن وجد
                      highlightSelected(li);
                  });

                  const toggleSpan = document.createElement('span');
                  toggleSpan.id = `toggle-${account.id}`;
                  toggleSpan.className = 'toggle-btn';
                  toggleSpan.textContent = '+';
                  toggleSpan.style.float = 'left';
                  toggleSpan.addEventListener('click', function (e) {
                      e.stopPropagation();
                      toggleAccounts(account.id, true);
                  });

                  const childList = document.createElement('ul');
                  childList.id = `list-${account.id}`;
                  childList.className = 'account-list';
                  childList.style.display = 'none';

                  li.appendChild(textSpan);
                  li.appendChild(toggleSpan);
                  li.appendChild(childList);
                  list.appendChild(li);
              });
          }

          list.style.display = 'block';
          toggle.textContent = '-';
      })
      .catch(err => console.error(err));
}

// البحث بالاسم
document.getElementById('accountSearchInput').addEventListener('input', function () {
    const term = this.value.trim();
    const treeBox = document.getElementById('searchTree');

    if (!term) {
        treeBox.innerHTML = '';
        treeBox.style.display = 'none';
        return;
    }
    if (term.length < 2) return;

    fetch(`{{ route('chart.accounts.search') }}?name=${encodeURIComponent(term)}`)
      .then(res => res.json())
      .then(data => {
          treeBox.innerHTML = '';
          const ul = document.createElement('ul');
          ul.classList.add('account-list');
          ul.style.display = 'block';

          if (!Array.isArray(data) || data.length === 0) {
              treeBox.innerHTML = '<p class="text-muted">لا يوجد نتائج.</p>';
          } else {
              data.forEach(account => {
                  const li = document.createElement('li');
                  li.textContent = `${account.account} (${account.account_number ?? '-'})`;
                  li.style.cursor = 'pointer';
                  li.addEventListener('click', () => {
                      selectedAccount = account;
                      highlightSelected(li);
                  });
                  ul.appendChild(li);
              });
              treeBox.appendChild(ul);
          }

          treeBox.style.display = 'block';
      })
      .catch(err => console.error(err));
});

// زر إضافة (يملأ فورم الإضافة بقيم الحساب المختار)
document.getElementById('addAccountBtn').addEventListener('click', function (e) {
    e.preventDefault();
    if (!selectedAccount) { alert("يرجى اختيار حساب أولاً."); return; }

    const idInput       = document.getElementById('add_parent_id');
    const storageInput  = document.getElementById('storage_id');
    const typeInput     = document.getElementById('account_type');
    const nameSpan      = document.getElementById('addParentName');
    const selectedName  = document.getElementById('selectedAccountName');
    const formContainer = document.getElementById('subAccountFormContainer');
    const editContainer = document.getElementById('editAccountFormContainer');

    if (idInput)      idInput.value      = selectedAccount.id;
    if (storageInput) storageInput.value = selectedAccount.storage_id || '';
    if (typeInput)    typeInput.value    = selectedAccount.account_type || '';

    if (nameSpan)     nameSpan.textContent     = `${selectedAccount.account} (${selectedAccount.code ?? '-'})`;
    if (selectedName) selectedName.textContent = `الحساب المختار: ${selectedAccount.account} (${selectedAccount.code ?? '-'})`;

    // وراثة مركز التكلفة الافتراضي
    const parentDefaultCC = selectedAccount.default_cost_center_id ?? null;
    const addCB   = document.getElementById('add_useCostCenter');
    const addWrap = document.getElementById('add_costCenterSelectWrap');
    const addHid  = document.getElementById('add_use_cost_center_hidden');
    const addSel  = document.getElementById('add_default_cost_center_id');

    if (addCB && addWrap && addHid && addSel) {
        const on = !!parentDefaultCC;
        addCB.checked = on;
        addHid.value = on ? 1 : 0;
        addWrap.style.display = on ? 'block' : 'none';
        addSel.value = on ? String(parentDefaultCC) : '';
        addCB.addEventListener('change', () => {
            const state = addCB.checked;
            addHid.value = state ? 1 : 0;
            addWrap.style.display = state ? 'block' : 'none';
            if (!state) addSel.value = '';
        }, { once: true });
    }

    if (formContainer) {
        formContainer.style.display = 'block';
        formContainer.scrollIntoView({ behavior: 'smooth' });
    }
    if (editContainer) editContainer.style.display = 'none';
});

// زر تعديل (يملأ فورم التعديل)
document.getElementById('editAccountBtn').addEventListener('click', function (e) {
    e.preventDefault();
    if (!selectedAccount) { alert("يرجى اختيار حساب أولاً."); return; }

    const idInput       = document.getElementById('edit_account_id');
    const nameInput     = document.getElementById('edit_account');
    const codeInput     = document.getElementById('edit_account_number');
    const descInput     = document.getElementById('edit_description');
    const formContainer = document.getElementById('editAccountFormContainer');
    const addContainer  = document.getElementById('subAccountFormContainer');
    const selectedName  = document.getElementById('selectedAccountName');
    const editForm      = document.getElementById('editAccountForm');

    if (editForm) {
        let templateAction = editForm.getAttribute('action'); // يحتوي __ID__ أو PLACEHOLDER_ID
        templateAction = templateAction.replace('__ID__', selectedAccount.id).replace('PLACEHOLDER_ID', selectedAccount.id);
        editForm.setAttribute('action', templateAction);
    }

    if (idInput)   idInput.value   = selectedAccount.id;
    if (nameInput) nameInput.value = selectedAccount.account;
    if (codeInput) codeInput.value = selectedAccount.account_number ?? '';
    if (descInput) descInput.value = selectedAccount.description ?? '';

    if (selectedName) selectedName.textContent = `الحساب المختار: ${selectedAccount.account} (${selectedAccount.account_code ?? '-'})`;

    const hasDefaultCC = !!selectedAccount.default_cost_center_id;
    const cb   = document.getElementById('edit_useCostCenter');
    const wrap = document.getElementById('edit_costCenterSelectWrap');
    const hid  = document.getElementById('edit_use_cost_center_hidden');
    const sel  = document.getElementById('edit_default_cost_center_id');

    if (cb && wrap && hid && sel) {
        cb.checked = hasDefaultCC;
        hid.value  = hasDefaultCC ? 1 : 0;
        wrap.style.display = hasDefaultCC ? 'block' : 'none';
        sel.value  = hasDefaultCC ? String(selectedAccount.default_cost_center_id) : '';
        cb.addEventListener('change', () => {
            const state = cb.checked;
            hid.value = state ? 1 : 0;
            wrap.style.display = state ? 'block' : 'none';
            if (!state) sel.value = '';
        }, { once: true });
    }

    if (formContainer) {
        formContainer.style.display = 'block';
        formContainer.scrollIntoView({ behavior: 'smooth' });
    }
    if (addContainer) addContainer.style.display = 'none';
});

// زر الحذف
document.getElementById('deleteAccountBtn').addEventListener('click', function (e) {
    e.preventDefault();
    if (!selectedAccount) { alert("يرجى اختيار حساب أولاً."); return; }

    // تأكيد المستخدم
    const name = selectedAccount.account || '';
    const code = selectedAccount.code || selectedAccount.account_number || '';
    const ok = confirm(`هل أنت متأكد من حذف الحساب:\n${name} (${code}) ؟\nسيتم رفض الحذف إذا كان للحساب أبناء أو عليه قيود/حركات.`);
    if (!ok) return;

    // تجهيز وإرسال فورم الحذف
    const form = document.getElementById('deleteAccountForm');
    let action = form.getAttribute('action'); // يحتوي __ID__
    action = action.replace('__ID__', selectedAccount.id);
    form.setAttribute('action', action);
    form.submit();
});
</script>
@endpush
