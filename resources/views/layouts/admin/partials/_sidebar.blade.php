<style>
 .aside-back {
    background: #00296B !important;
    color: #fff;
    font-size: 12px;
}

.nav-sub {
    background-color:#00509d !important;
}
.navbar .active > .nav-link, .navbar .nav-link.active, .navbar .nav-link.show, .navbar .show > .nav-link {
    color: #fff;
    background-color:#00509d  ;
}
.navbar .nav-link:hover {
    color: #F8C01C;
}
.nav-subtitle {
    display: block;
    color: #4F5B67;
        background-color:#00509d  ;

    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .03125rem;
}
h1{
        font-size:22px;

}
.navbar-vertical .nav-link:hover .nav-indicator-icon {
    color: #003f88; /* موف عند التمرير إذا لم يكن نشطًا */
}

.text-truncate:hover{
    color:#F8C01C;
}
.navbar-vertical .active .nav-link:hover .nav-indicator-icon {
    color: #fff !important; /* أبيض عند التمرير إذا كان العنصر نشطًا */
}

.nav-icon{
        color: #fff;

}
.nav-icon:hover,
.nav-icon:focus,
.nav-icon:active {
    color: #fff;
}

.nav-brand-back {
    background: #00296B !important;
    color: white;
}
.nav-indicator-icon {
    color: #ffffff;
    font-size: 6px;
    -ms-flex: 0 0 1rem;
    flex: 0 0 1rem;
}
.direction-toggle {
    background: #161853;
    color: #ffffff;
    padding: 8px 0;
    -webkit-padding-end: 18px;
    padding-inline-end: 18px;
    -webkit-padding-start: 10px;
    padding-inline-start: 10px;
    cursor: pointer;
    position: fixed;
    top: 30%;
    border-radius: 5px;
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    transition: all ease 0.3s;
    white-space: nowrap;
    inset-inline-start: 100%;
    transform: translateX(calc(-100% + 3px));
}
::-webkit-scrollbar-thumb:hover {
    background: #ffffff;
}
.i{
    color:white;
        font-weight: normal;

}
@font-face {
    font-family: 'Bahij';
    src: url("{{ asset('public/assets/admin/css/fonts/Bahij_TheSansArabic-Plain.ttf') }}") format('truetype');
    font-weight: normal;
    font-style: normal;
}

body {
    font-family: 'Bahij', sans-serif;
    font-weight: 150;
    color: black;
    background:rgba(173, 216, 230, 0.2);
}
.navbar-vertical:not([class*=container]) .navbar-nav .nav-link {
    padding: .8rem 1.75rem;
}
.navbar-vertical .navbar-nav.nav-tabs .nav-item:not(:last-child) {
    margin: 0;
    background-color: #003f88;
}
.nav-link.active .nav-icon {
    color: #fff !important;
}
.paginate_button{
    display: none;
}
.dataTables_length{
     display: none;
   
}
.navbar-vertical .active .nav-indicator-icon, .navbar-vertical .nav-link:hover .nav-indicator-icon, .navbar-vertical .show > .nav-link > .nav-indicator-icon {
    color: #fdc500;
}
.navbar-vertical .active .nav-indicator-icon, .navbar-vertical .nav-link:hover .nav-indicator-icon, .navbar-vertical .show > .nav-link > .text-truncate {
    color: #fdc500;
}
input[type="search"][aria-controls="DataTables_Table_0"] {
    display: none;
}
label:has(input[type="search"][aria-controls="DataTables_Table_0"]) {
    display: none;
}
label:has(input[type="search"][aria-controls="DataTables_Table_1"]) {
    display: none;
}
label:has(input[type="search"][aria-controls="DataTables_Table_2"]) {
    display: none;
}
label:has(input[type="search"][aria-controls="DataTables_Table_3"]) {
    display: none;
}
label:has(input[type="search"][aria-controls="DataTables_Table_4"]) {
    display: none;
}
label:has(input[type="search"][aria-controls="DataTables_Table_5"]) {
    display: none;
}
#DataTables_Table_0_info{
        display: none;

}
#DataTables_Table_1_info{
            display: none;

}
#DataTables_Table_2_info{
            display: none;

}
#DataTables_Table_3_info{
            display: none;

}
#DataTables_Table_4_info{
            display: none;

}
#DataTables_Table_5_info{
            display: none;

}
#links{
    display: block;
}
.navbar-vertical-aside-has-menu.active {
    background-color: #00509d; /* لون داكن عند الفتح */
}

.navbar-vertical-aside .navbar-brand-wrapper {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-align: center;
    align-items: center;
    height: 6rem;
    font-size: 1.5rem;
    padding-inline-end: 1.75rem;
    padding-inline-start: 1.75rem;
}
.text-logo{
        font-size: 1rem;

}
.ss{
    color: #fdc500;
    padding-right: 5px;
}
.navbar-vertical-aside-has-menu .nav-sub .nav-item {
    background-color: #003f88;
}
.nav-item.active > .nav-link > .tio-circle >.i {
    color: #fdc500 ;
}
.badge-koyod {
    background-color: #708D81; /* لون أخضر رمادي أنيق */
    color: #fff;               /* النص أبيض */
    padding: 5px 5px;         /* مسافات داخلية متناسقة */
    border-radius: 5px;       /* زوايا دائرية ناعمة */
    font-size: 0.65rem;        /* حجم خط مناسب للبادج */
    font-weight: 400;          /* خط متوسط الوضوح */
    display: inline-block;     /* للتأكد من العرض الصحيح */
    opacity: 0.8;
}
.btn-info.focus, .btn-info:focus {
    color: #fff;
    background-color: #F4D58D;
    border-color: #F4D58D;
}
.bg-secondary {
    width: 100%;
    margin-bottom: 1rem;
        background-color: #EDF2F4 !important;  
        color:black !important;

}

</style>
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>



<div id="sidebarMain" class="d-none">
    <aside class="aside-back js-navbar-vertical-aside navbar navbar-vertical-aside navbar-vertical navbar-vertical-fixed navbar-expand-xl navbar-bordered pb-4">
        <div class="navbar-vertical-container text-capitalize">
            <div class="navbar-vertical-footer-offset">
                <div class="navbar-brand-wrapper justify-content-between nav-brand-back side-logo">
                    <!-- Logo -->
                    @php($shop_logo=\App\Models\BusinessSetting::where(['key'=>'shop_name'])->first()->value)
                    <a class="navbar-brand " href="{{route('admin.dashboard')}}" aria-label="Front">
                     <h1 class="pt-1 ps-5 text-white text-logo" style="font-size:2rem;">نظام <span class="ss">Novoo</span></h1>
                    </a>
                    <!-- End Logo -->
                    <!-- Navbar Vertical Toggle -->
                    <button type="button"
                            class="js-navbar-vertical-aside-toggle-invoker navbar-vertical-aside-toggle btn btn-icon btn-xs text-white">
                        <i class="tio-clear tio-lg"></i>
                    </button>
                    <!-- End Navbar Vertical Toggle -->
                </div>

                <!-- Content -->
                <div class="navbar-vertical-content">
                    <ul class="navbar-nav navbar-nav-lg nav-tabs">
                        <!-- Dashboards -->

 <li class="navbar-vertical-aside-has-menu {{ Request::is('admin/dashboard') ? 'show' : '' }}">
    <a class="js-navbar-vertical-aside-menu-link nav-link {{ Request::is('admin/dashboard') ? 'active' : '' }}"
       href="{{ route('admin.dashboard') }}"
       title="{{ \App\CPU\translate('dashboards') }}">
        <i class="tio-home-vs-1-outlined nav-icon"></i>
        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate ">
            {{ \App\CPU\translate('الرئيسية') }}
        </span>
    </a>
</li>
                        <li class="navbar-vertical-aside-has-menu">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:"
                            >
<i class="fa-solid fa-lock nav-icon"></i>                                <span
                                    class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{\App\CPU\translate('الإعدادات الشاملة')}}</span>
                            </a>
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub {{Request::is('admin/admin/add')||Request::is('admin/admin/list')|| Request::is('admin/admin/edit*')||Request::is('admin/shift/add')||Request::is('admin/shift/list')|| Request::is('admin/shift/edit*')|| Request::is('admin/branch/add')||Request::is('admin/tax/list')||Request::is('admin/business-settings/shop-setup')||Request::is('admin/roles')||Request::is('admin/custom-fields*')|| Request::is('admin/departments*')?'d-block':''}}">
                                <li class="nav-item {{Request::is('admin/admin/add')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.admin.add')}}"
                                       title="{{\App\CPU\translate('add_new_admin')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate i">{{\App\CPU\translate('اضافه مستخدم')}}</span>
                                    </a>
                                </li>

                                <li class="nav-item {{Request::is('admin/admin/list')|| Request::is('admin/admin/edit*')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.admin.list')}}"
                                       title="{{\App\CPU\translate('list_of_admin')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate i">{{\App\CPU\translate('قائمة المستخدمين')}}</span>
                                    </a>
                                </li>
                                    <li class="nav-item {{Request::is('admin/roles')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.role.index')}}"
                                    >
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span
                                            class="text-truncate i">{{\App\CPU\translate('الصلاحيات')}}</span>
                                    </a>
                                </li>
                                
                                <li class="nav-item {{Request::is('admin/departments/list')|| Request::is('admin/departments/edit*')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.departments.index')}}"
                                       title="{{\App\CPU\translate('list_of_admin')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate i">{{\App\CPU\translate('الأقسام')}}</span>
                                    </a>
                                </li>
                                  <li class="nav-item {{Request::is('admin/shift/add')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.shift.add')}}"
                                       title="{{\App\CPU\translate('add_new_admin')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate i">{{\App\CPU\translate('اضافة مواعيد عمل')}}</span>
                                    </a>
                                </li>

                                <li class="nav-item {{Request::is('admin/shift/list')|| Request::is('admin/shift/edit*')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.shift.list')}}"
                                       title="{{\App\CPU\translate('list_of_admin')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate i">{{\App\CPU\translate('قائمة مواعيد العمل')}}</span>
                                    </a>
                                </li>
                                <li class="nav-item  {{ Request::is('admin/branch/add') ? 'active' : '' }}">

                                    <a class="nav-link " href="{{route('admin.branch.add')}}"
                                       title="{{\App\CPU\translate('add_new_category')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate i">{{\App\CPU\translate('الفروع')}}</span>
                                    </a>
                                </li>
                                    <li class="nav-item {{Request::is('admin/tax/list')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
href="{{ route('admin.taxe.list') }}"
                            >
                                        <span class="tio-circle nav-indicator-icon"></span>

<span class="text-truncate i">                                    {{\App\CPU\translate('انواع الضرايب')}}
                                </span>
                            </a>
                        </li>
                                            <li class="nav-item {{Request::is('admin/custom-fields*')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.custom-fields.index')}}"
                                    >
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span
                                            class="text-truncate i">{{\App\CPU\translate('الحقول المخصصة')}}</span>
                                    </a>
                                </li>
                         <li class="nav-item {{Request::is('admin/business-settings/shop-setup')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.business-settings.shop-setup')}}"
                                    >
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span
                                            class="text-truncate i">{{\App\CPU\translate('الاعدادات')}}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

 <!--<li class="navbar-vertical-aside-has-menu {{ Request::is('admin/admin/notifications') ? 'active' : '' }}">-->

 <!--           <a class="nav-link" href="{{route('admin.admin.notifications.listItems')}}"-->
 <!--              title="{{\App\CPU\translate('list_stock')}}">-->
 <!--       <i class="tio-notifications nav-icon"></i>-->
 <!--               <span class="text-truncate">{{\App\CPU\translate('الإشعارات')}}</span>@if(\App\Models\Order::where('notification', 1)->get()->count() > 0)-->
 <!--               <span class="badge badge-pill badge-danger ml-3" style="font-size:12px">{{ \App\Models\Order::where('notification', 1)->get()->count() +\App\Models\ReserveProduct::where('notification', 1)->get()->count() +\App\Models\TransactionSeller::get()->count() +\App\Models\HistoryInstallment::where('notification', 1)->get()->count()}}</span>-->
 <!--           @endif-->
 <!--           </a>-->
 <!--           </li>-->


<li class="navbar-vertical-aside-has-menu 
    {{ Request::is('admin/account*') || Request::is('admin/storages*') || Request::is('admin/tax*') || 
       Request::is('admin/reports*') || Request::is('admin/costcenter*') || 
       Request::is('admin/assets*') || Request::is('admin/maintenance_logs*') || 
       Request::is('admin/depreciation') || Request::is('admin/vouchers*')||  Request::is('admin/journal-entries*') || Request::is('admin/account/statement*')||Request::is('admin/reports/costcenters/transactions') || Request::is('admin/reportss/costcenters/totals'||Request::is('admin/regions/list') ||Request::is('admin/regions/edit*') || Request::is('admin/installments*')||Request::is('admin/guarantors*') ||Request::is('admin/customer*') ) 
       ? 'show' : '' }}">
       
    <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:">
        <i class="tio-wallet nav-icon"></i>
        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
            {{ \App\CPU\translate('المحاسبة المالية') }}
        </span>
    </a>

    <ul class="js-navbar-vertical-aside-submenu nav nav-sub" 
        style="{{ Request::is('admin/account*') || Request::is('admin/storages*') || Request::is('admin/tax*') || 
                 Request::is('admin/reports*') || Request::is('admin/costcenter*') || 
                 Request::is('admin/assets*') || Request::is('admin/maintenance_logs*') ||Request::is('admin/regions/list') ||Request::is('admin/regions/edit*')||Request::is('admin/guarantors*') ||Request::is('admin/customer*') ||
                 Request::is('admin/depreciation') 
                 ? 'display: block;' : '' }}">
        {{-- 🟦 القائمة الأساسية --}}
 <li class="navbar-vertical-aside-has-menu {{ 
        Request::is('admin/storages*') || 
        Request::is('admin/costcenter*') || 
        Request::is('admin/account/add') 
        ? 'show' : '' }}">
    <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:">
        <i class="tio-menu-vs nav-icon"></i>
        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
            {{ \App\CPU\translate('القائمة الأساسية') }}
        </span>
    </a>

    <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
        style="{{ Request::is('admin/storages*')  || Request::is('admin/account/add') ? 'display:block;' : '' }}">
 
        <li class="nav-item {{ Request::is('admin/storages/indextree') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.storage.indextree') }}">{{ \App\CPU\translate('شجرة الحسابات') }}</a>
        </li>
          <li class="nav-item {{ Request::is('admin/account/add-payable') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.account.add-payable') }}">{{ \App\CPU\translate('أرصدة افتتاحية') }}</a>
        </li>
        <!--<li class="nav-item {{ Request::is('admin/account/add') ? 'active' : '' }}">-->
        <!--    <a class="nav-link" href="{{ route('admin.account.add') }}">{{ \App\CPU\translate('إضافة دليل محاسبي') }}</a>-->
        <!--</li>-->
    </ul>
</li>

  {{-- 🟧 العمليات --}}
<li class="navbar-vertical-aside-has-menu {{ Request::is('admin/account/add*') || Request::is('admin/assets*') || Request::is('admin/depreciation') || Request::is('admin/maintenance_logs*') || Request::is('admin/account/listkoyod-transection') ? 'show' : '' }}">
    <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:">
        <i class="tio-receipt-outlined nav-icon"></i>
        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{ \App\CPU\translate('العمليات') }}</span>
    </a>
    <ul class="js-navbar-vertical-aside-submenu nav nav-sub" style="{{ Request::is('admin/account/add*') || Request::is('admin/assets*') || Request::is('admin/depreciation') || Request::is('admin/maintenance_logs*') || Request::is('admin/account/listkoyod-transection') ? 'display: block;' : '' }}">
        <!--<li class="nav-item {{ Request::is('admin/account/listkoyod-transection') ? 'active' : '' }}">-->
        <!--    <a class="nav-link" href="{{ route('admin.account.listkoyod-transection') }}">{{ \App\CPU\translate('القيود اليومية') }}</a>-->
        <!--</li>-->
      
        <li class="nav-item {{ Request::is('admin/account/add-expense/100') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.account.add-expense', ['type' => '100']) }}">{{ \App\CPU\translate('إضافة سند صرف') }}</a>
        </li>
        <li class="nav-item {{ Request::is('admin/account/add-expense/200') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.account.add-expense', ['type' => '200']) }}">{{ \App\CPU\translate('إضافة سند قبض') }}</a>
        </li>
        <li class="nav-item {{ Request::is('admin/account/add-transfer') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.account.add-transfer') }}">{{ \App\CPU\translate('إضافة قيد يومي') }}</a>
        </li>
    
        <li class="nav-item {{ Request::is('admin/account/add-expense/2') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.account.add-expense', ['type' => '2']) }}">{{ \App\CPU\translate('إضافة أصل ثابت') }}</a>
        </li>
        <li class="nav-item {{ Request::is('admin/depreciation') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.depreciation.show') }}">{{ \App\CPU\translate('إهلاك أصل ثابت') }}</a>
        </li>
        <li class="nav-item {{ Request::is('admin/maintenance_logs/create') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.maintenance_logs.create') }}">{{ \App\CPU\translate('جدولة صيانة أصل ثابت') }}</a>
        </li>
        <li class="nav-item {{ Request::is('admin/maintenance_logs') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.maintenance_logs.index') }}">{{ \App\CPU\translate('صيانة أصل ثابت') }}</a>
        </li>
    </ul>
</li>

{{-- 🟩 التقارير --}}
<li class="navbar-vertical-aside-has-menu {{ Request::is('admin/reports*') || Request::is('admin/account/list-expense*') || Request::is('admin/account/list-transfer') || Request::is('admin/account/list-transection') ||  Request::is('admin/journal-entries*') ? 'show' : '' }}">
    <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:">
        <i class="tio-chart-bar-1 nav-icon"></i>
        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{ \App\CPU\translate('التقارير') }}</span>
    </a>
    <ul class="js-navbar-vertical-aside-submenu nav nav-sub" style="{{ Request::is('admin/reports*') || Request::is('admin/assets') || Request::is('admin/account/list-expense*') || Request::is('admin/account/list-transfer') || Request::is('admin/account/list-transection') ||  Request::is('admin/vouchers*') || Request::is('admin/account/statement*') ? 'display: block;' : '' }}">
          <li class="nav-item {{ Request::is('admin/assets') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.depreciation.index') }}">{{ \App\CPU\translate('الأصول الثابتة') }}</a>
        </li>
        <li class="nav-item {{ Request::is('admin/vouchers/payment') ? 'active' : '' }}">
<a class="nav-link" href="{{ route('admin.vouchers.index', ['type' => 'payment']) }}">
    {{ \App\CPU\translate('تقرير سندات صرف') }}
</a>
        </li>
        <li class="nav-item {{ Request::is('admin/vouchers/receipt') ? 'active' : '' }}">
<a class="nav-link" href="{{ route('admin.vouchers.index', ['type' => 'receipt']) }}">
    {{ \App\CPU\translate('تقرير سندات قبض') }}
</a>
        </li>
        <li class="nav-item {{ Request::is('admin/journal-entries*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.journal-entries.index') }}">{{ \App\CPU\translate('تقرير القيود اليومية') }}</a>
        </li>
        <li class="nav-item {{ Request::is('admin/reports/balance-sheet') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.balance-sheet') }}">{{ \App\CPU\translate('تقرير الميزانية العمومية') }}</a>
        </li>
        <li class="nav-item {{ Request::is('admin/reports/indexOperating') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.indexOperating') }}">{{ \App\CPU\translate('تقرير التدفقات النقدية') }}</a>
        </li>
        <li class="nav-item {{ Request::is('admin/reports/indexTrialBalance') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.indexTrialBalance') }}">{{ \App\CPU\translate('تقرير ميزان المراجعة') }}</a>
        </li>
        <li class="nav-item {{ Request::is('admin/reports/IncomeStatement') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.IncomeStatement') }}">{{ \App\CPU\translate('تقرير قائمة الدخل') }}</a>
        </li>
        <li class="nav-item {{ Request::is('admin/reports/ageing-receivables') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.AgeingReceivables') }}">{{ \App\CPU\translate('تقرير إعمار ديون العملاء') }}</a>
        </li>
        <li class="nav-item {{ Request::is('admin/reports/ageing-receivables-suppliers') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.suppliersIndex') }}">{{ \App\CPU\translate('تقرير إعمار ديون الموردين') }}</a>
        </li>

        <li class="nav-item {{ Request::is('admin/account/statement') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.account.statement') }}">{{ \App\CPU\translate('كشف حساب') }}</a>
        </li>
    </ul>
</li>
<li class="navbar-vertical-aside-has-menu {{ Request::is('admin/reportss/costcenters/transactions') || Request::is('admin/reports/scostcenters/totals')|| Request::is('admin/costcenter*') ? 'show' : '' }}">
    <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:">
        <i class="tio-chart-bar-1 nav-icon"></i>
        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{ \App\CPU\translate('مراكز التكلفة') }}</span>
    </a>
    <ul class="js-navbar-vertical-aside-submenu nav nav-sub" style="{{ Request::is('admin/reportss/costcenters/transactions') || Request::is('admin/reportss/costcenters/totals')|| Request::is('admin/costcenter*') ? 'display: block;' : '' }}">
                <li class="nav-item {{ Request::is('admin/costcenter*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.costcenter.add') }}">{{ \App\CPU\translate('مراكز التكلفة') }}</a>
        </li>
        <li class="nav-item {{ Request::is('admin/reportss/costcenters/transactions') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.costcenters.transactions') }}">{{ \App\CPU\translate('تقرير حركات مراكز التكلفة') }}</a>
        </li>
                <li class="nav-item {{ Request::is('admin/reportss/costcenters/totals') || Request::is('admin/reportss/costcenters/totals*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.costcenters.totals') }}">{{ \App\CPU\translate('إجماليات مراكز التكلفة') }}</a>
        </li>
    
    </ul>
</li>
<li class="navbar-vertical-aside-has-menu {{ Request::is('admin/reportss/costcenters/transactions') || Request::is('admin/reports/scostcenters/totals')|| Request::is('admin/costcenter*') ? 'show' : '' }}">
    <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:">
        <i class="tio-chart-bar-1 nav-icon"></i>
        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{ \App\CPU\translate('العملاء') }}</span>
    </a>
    <ul class="js-navbar-vertical-aside-submenu nav nav-sub" style="{{ Request::is('admin/regions/list') ||Request::is('admin/regions/edit*') ||Request::is('admin/guarantors*') ? 'active':''}}">

                                    <a class="nav-link " href="{{route('admin.regions.list')}}"
                                       title="{{\App\CPU\translate('regions')}}">
                                                                                <span class="tio-circle nav-indicator-icon"></span>

                                        <span class="text-truncate i">{{\App\CPU\translate('المناطق')}}</span>
                                    </a>
                                </li>
         <li class="nav-item {{Request::is('admin/customer/add')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.customer.add')}}"
                                       title="{{\App\CPU\translate('add_new_customer')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate i">{{\App\CPU\translate('اضافة عميل')}}</span>
                                    </a>
                                </li>

                                <li class="nav-item {{Request::is('admin/customer/list')||Request::is('/admin/customer/transaction-list/*')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.customer.list')}}"
                                       title="{{\App\CPU\translate('list_of_customers')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate i">{{\App\CPU\translate('قائمة العملاء')}}</span>
                                    </a>
                                </li>
                                <li class="navbar-vertical-aside-has-menu {{Request::is('admin/special*')||Request::is('admin/category/edit*')?'active':''}}">
                                <li class="nav-item {{Request::is('admin/category/add-special-category')||Request::is('admin/category/edit*')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.category.indexspecial')}}"
                                       title="{{\App\CPU\translate('add_new_category')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate i">{{\App\CPU\translate('تخصصات العملاء')}}</span>
                                    </a>
             </li>
                   <li class="nav-item {{Request::is('admin/guarantors/create')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.guarantors.create')}}"
                                       title="{{\App\CPU\translate('guarantors')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate i">{{\App\CPU\translate('اضافة ضامن')}}</span>
                                    </a>
                                </li>

                                <li class="nav-item {{Request::is('admin/guarantors/index')||Request::is('/admin/guarantors*')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.guarantors.index')}}"
                                       title="{{\App\CPU\translate('list_of_guarantors')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate i">{{\App\CPU\translate('قائمة الضمناء')}}</span>
                                    </a>
                                </li>
    
    
    </ul>
</li>


    </ul>
</li>
                                                   {{--<li class="navbar-vertical-aside-has-menu">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:">
            <i class="tio-report nav-icon"></i>
            <span  class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{ \App\CPU\translate('نظام المقاولات') }}</span>
        </a>
<ul class="js-navbar-vertical-aside-submenu nav nav-sub {{Request::is('admin/clients*')||Request::is('admin/contracts*')?'d-block':''}}">    


              
                                   <li class="nav-item {{Request::is('admin/clients/index')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.clients.index')}}"
                                       title="{{\App\CPU\translate('clients')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate i">{{\App\CPU\translate('قائمة العملاء')}}</span>
                                    </a>
                                </li>
<li class="nav-item {{ Request::is('admin/clients/create') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.clients.create') }}" title="{{ \App\CPU\translate('clients') }}">
                             <span class="tio-circle nav-indicator-icon"></span>

                <span class="text-truncate i">{{ \App\CPU\translate('إضافة عميل') }}</span>
            </a>
        </li>
        <li class="nav-item {{Request::is('admin/contracts/index')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.contracts.index')}}"
                                       title="{{\App\CPU\translate('contracts')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate i">{{\App\CPU\translate('قائمة العقود')}}</span>
                                    </a>
                                </li>
                                     <li class="nav-item {{Request::is('admin/contracts/create')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.contracts.create')}}"
                                       title="{{\App\CPU\translate('contracts')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate i">{{\App\CPU\translate('إضافة عقد')}}</span>
                                    </a>
                                </li>
        
    </ul>
</li>

<li class="navbar-vertical-aside-has-menu ">
    <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:" >
        <i class="tio-settings nav-icon"></i>
        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
            {{ \App\CPU\translate('الإنتاج') }}
        </span>
    </a>
        <ul class="js-navbar-vertical-aside-submenu nav nav-sub {{  Request::is('admin/boms*') ||  Request::is('admin/bomcomponents*') ||  Request::is('admin/workcenters*') || Request::is('admin/routings*') || Request::is('admin/routing-operations*') || Request::is('admin/production-orders*')   ? 'd-block' : '' }}">

             <li class="nav-item {{ Request::is('admin/boms*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.boms.index')}}" title="{{ \App\CPU\translate('cashier') }}">
                <span class="tio-circle nav-indicator-icon"></span>
                <span class="text-truncate i">{{ \App\CPU\translate('قائمة المواد') }}</span>
            </a>
        </li> 
           <li class="nav-item {{ Request::is('admin.boms.create') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.boms.create') }}" title="{{ \App\CPU\translate('cashier') }}">
                <span class="tio-circle nav-indicator-icon"></span>
                <span class="text-truncate i">{{ \App\CPU\translate('إضافة مواد') }}</span>
            </a>
        </li> 
              <li class="nav-item {{ Request::is('admin/bomcomponents*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.bomcomponents.index')}}" title="{{ \App\CPU\translate('cashier') }}">
                <span class="tio-circle nav-indicator-icon"></span>
                <span class="text-truncate i">{{ \App\CPU\translate('قائمة مكونات المواد') }}</span>
            </a>
        </li> 
           <li class="nav-item {{ Request::is('admin/bomcomponents/create') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.bomcomponents.create')}}" title="{{ \App\CPU\translate('cashier') }}">
                <span class="tio-circle nav-indicator-icon"></span>
                <span class="text-truncate i">{{ \App\CPU\translate('إضافة مكونات المواد') }}</span>
            </a>
        </li> 
      
        <li class="nav-item {{ Request::is('admin/workcenters*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.work-centers.index')}}" title="{{ \App\CPU\translate('cashier') }}">
                <span class="tio-circle nav-indicator-icon"></span>
                <span class="text-truncate i">{{ \App\CPU\translate('قائمة مراكز الأعمال ') }}</span>
            </a>
        </li> 
           <li class="nav-item {{ Request::is('admin/workcenters/create') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.work-centers.create')}}" title="{{ \App\CPU\translate('cashier') }}">
                <span class="tio-circle nav-indicator-icon"></span>
                <span class="text-truncate i">{{ \App\CPU\translate('إضافة مركز أعمال') }}</span>
            </a>
        </li> 
          <li class="nav-item {{ Request::is('admin/routings*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.routings.index')}}" title="{{ \App\CPU\translate('cashier') }}">
                <span class="tio-circle nav-indicator-icon"></span>
                <span class="text-truncate i">{{ \App\CPU\translate('قائمة المسارات ') }}</span>
            </a>
        </li> 
           <li class="nav-item {{ Request::is('admin/routings/create') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.routings.create')}}" title="{{ \App\CPU\translate('cashier') }}">
                <span class="tio-circle nav-indicator-icon"></span>
                <span class="text-truncate i">{{ \App\CPU\translate('إضافة  مسار') }}</span>
            </a>
        </li>   
        <li class="nav-item {{ Request::is('admin/routing-operations*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.routing-operations.index')}}" title="{{ \App\CPU\translate('cashier') }}">
                <span class="tio-circle nav-indicator-icon"></span>
                <span class="text-truncate i">{{ \App\CPU\translate('قائمة خطوات التشغيل ') }}</span>
            </a>
        </li> 
           <li class="nav-item {{ Request::is('admin/routing-operations/create') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.routing-operations.create')}}" title="{{ \App\CPU\translate('cashier') }}">
                <span class="tio-circle nav-indicator-icon"></span>
                <span class="text-truncate i">{{ \App\CPU\translate('إضافة  خطوات التشغيل') }}</span>
            </a>
        </li> 
          <li class="nav-item {{ Request::is('admin/production-orders*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.production-orders.index')}}" title="{{ \App\CPU\translate('cashier') }}">
                <span class="tio-circle nav-indicator-icon"></span>
                <span class="text-truncate i">{{ \App\CPU\translate('قائمة  أوامر الإنتاج ') }}</span>
            </a>
        </li> 
           <li class="nav-item {{ Request::is('admin/production-orders/create') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.production-orders.create')}}" title="{{ \App\CPU\translate('cashier') }}">
                <span class="tio-circle nav-indicator-icon"></span>
                <span class="text-truncate i">{{ \App\CPU\translate('إضافة  أمر إنتاج') }}</span>
            </a>
        </li> 
      
    </ul>
</li>
--}}
<li class="navbar-vertical-aside-has-menu">
  <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:">
    <i class="tio-settings nav-icon"></i>
    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
      {{ \App\CPU\translate('إدارة العملاء المحتملين') }}
    </span>
  </a>

  <ul class="js-navbar-vertical-aside-submenu nav nav-sub
      {{ Request::is('admin/lead-statuses*')
        || Request::is('admin/lead-sources*')
        || Request::is('admin/leads*')
        || Request::is('admin/call-outcomes*')
        || Request::is('admin/call-logs*')||Request::is('admin/lead-notes*') 
          ? 'd-block' : '' }}">

    {{-- حالات العملاء المحتملين --}}
    <li class="nav-item {{ Request::is('admin/lead-statuses*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('admin.lead-statuses.index') }}" title="{{ \App\CPU\translate('lead-statuses') }}">
        <span class="tio-circle nav-indicator-icon"></span>
        <span class="text-truncate i">{{ \App\CPU\translate('الحالات') }}</span>
      </a>
    </li>

    {{-- مصادر العملاء المحتملين --}}
    <li class="nav-item {{ Request::is('admin/lead-sources*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('admin.lead-sources.index') }}" title="{{ \App\CPU\translate('lead-sources') }}">
        <span class="tio-circle nav-indicator-icon"></span>
        <span class="text-truncate i">{{ \App\CPU\translate('المصادر') }}</span>
      </a>
    </li>

    {{-- العملاء المحتملون --}}
    <li class="nav-item {{ Request::is('admin/leads*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('admin.leads.index') }}" title="{{ \App\CPU\translate('leads') }}">
        <span class="tio-circle nav-indicator-icon"></span>
        <span class="text-truncate i">{{ \App\CPU\translate('العملاء المحتملين') }}</span>
      </a>
    </li>

    {{-- نتائج المكالمات --}}
    <li class="nav-item {{ Request::is('admin/call-outcomes*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('admin.call-outcomes.index') }}" title="{{ \App\CPU\translate('call-outcomes') }}">
        <span class="tio-circle nav-indicator-icon"></span>
        <span class="text-truncate i">{{ \App\CPU\translate('نتائج المكالمات') }}</span>
      </a>
    </li>

    {{-- سجلات المكالمات --}}
    <li class="nav-item {{ Request::is('admin/call-logs*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('admin.call-logs.index') }}" title="{{ \App\CPU\translate('call-logs') }}">
        <span class="tio-circle nav-indicator-icon"></span>
        <span class="text-truncate i">{{ \App\CPU\translate('سجلات المكالمات') }}</span>
      </a>
    </li>
<li class="nav-item {{ Request::is('admin/lead-notes*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('admin.lead-notes.index') }}" title="{{ \App\CPU\translate('lead-notes') }}">
        <span class="tio-circle nav-indicator-icon"></span>
        <span class="text-truncate i">{{ \App\CPU\translate('ملاحظات عملاء ') }}</span>
      </a>
    </li>

  </ul>
</li>
<!--<li class="navbar-vertical-aside-has-menu">-->
<!--    <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:">-->
<!--        <i class="fa-solid fa-list-check nav-icon"></i>-->
<!--        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">-->
<!--            {{ \App\CPU\translate('المهام والمشروعات') }}-->
<!--        </span>-->
<!--    </a>-->

<!--    <ul class="js-navbar-vertical-aside-submenu nav nav-sub-->
<!--        {{ Request::is('admin/projects*') || Request::is('admin/tasks*') || Request::is('admin/status*')? 'd-block' : '' }}">-->
<!--     <li class="nav-item {{ Request::is('admin/status*') ? 'active' : '' }}">-->
<!--            <a class="nav-link" href="{{ route('admin.status.index') }}"-->
<!--               title="{{ \App\CPU\translate('الحالات') }}">-->
<!--                <span class="tio-circle nav-indicator-icon"></span>-->
<!--                <span class="text-truncate i">{{ \App\CPU\translate('الحالات') }}</span>-->
<!--            </a>-->
<!--        </li>-->
<!--        {{-- المشروعات --}}-->
<!--        <li class="nav-item {{ Request::is('admin/projects*') ? 'active' : '' }}">-->
<!--            <a class="nav-link" href="{{ route('admin.projects.index') }}"-->
<!--               title="{{ \App\CPU\translate('المشروعات') }}">-->
<!--                <span class="tio-circle nav-indicator-icon"></span>-->
<!--                <span class="text-truncate i">{{ \App\CPU\translate('المشروعات') }}</span>-->
<!--            </a>-->
<!--        </li>-->

<!--        {{-- المهام --}}-->
<!--        <li class="nav-item {{ Request::is('admin/tasks*') ? 'active' : '' }}">-->
<!--            <a class="nav-link" href="{{ route('admin.tasks.index') }}"-->
<!--               title="{{ \App\CPU\translate('المهام') }}">-->
<!--                <span class="tio-circle nav-indicator-icon"></span>-->
<!--                <span class="text-truncate i">{{ \App\CPU\translate('المهام') }}</span>-->
<!--            </a>-->
<!--        </li>-->
<!--    </ul>-->
<!--</li>-->


<li class="navbar-vertical-aside-has-menu {{  Request::is('admin/pos/pos/7') ||Request::is('admin.installments*')? 'd-block' : '' }}">
    <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:" data-bs-toggle="collapse" data-bs-target="#salesDropdownContent" aria-expanded="{{ Request::is('admin/admin/pos*') ? 'true' : 'false' }}">
        <i class="tio-shopping nav-icon"></i>
        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
            {{ \App\CPU\translate('نظام نقاط البيع') }}
        </span>
    </a>

    <ul class="js-navbar-vertical-aside-submenu nav nav-sub collapse {{ Request::is('admin/pos/pos/7')||    Request::is('admin/pos/orders')||
        Request::is('admin/pos/refunds') || Request::is('admin/customer*')||Request::is('admin/category/add-special-category')||Request::is('admin/category/edit*')||Request::is('/admin/customer/transaction-list/*')|| Request::is('admin/pos/installments') || Request::is('admin/quotations/create') || Request::is('admin/quotations*')||Request::is('admin/sells*') ||Request::is('admin/installments*') || Request::is('admin/quotations/create_type') ? 'd-block' : '' }}" id="salesDropdownContent">
          
        <li class="nav-item {{ Request::is('admin/sells*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.sells.create_type') }}" title="{{ \App\CPU\translate('list_stock') }}">
                <span class="tio-circle nav-indicator-icon"></span>
                <span class="text-truncate i">{{ \App\CPU\translate('مبيعات') }}</span>
            </a>
        </li>
          <li class="nav-item {{ Request::is('admin/sells/drafts') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.sells.drafts') }}" title="{{ \App\CPU\translate('quotations') }}">
                <span class="tio-circle nav-indicator-icon"></span>
                <span class="text-truncate i">{{ \App\CPU\translate('مسودات فواتير بيع') }}</span>
            </a>
        </li>
        <li class="nav-item {{ Request::is('admin/pos/pos/7') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.pos.index', ['type' => 7]) }}" title="{{ \App\CPU\translate('list_stock') }}">
                <span class="tio-circle nav-indicator-icon"></span>
                <span class="text-truncate i">{{ \App\CPU\translate('مرتجع مبيعات') }}</span>
            </a>
        </li>
              <li class="nav-item {{ Request::is('admin/quotations/create') || Request::is('admin/quotations/create_type')  ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.quotations.create_type') }}" title="{{ \App\CPU\translate('quotations') }}">
                <span class="tio-circle nav-indicator-icon"></span>
                <span class="text-truncate i">{{ \App\CPU\translate('إنشاء عرض سعر') }}</span>
            </a>
        </li>
           <li class="nav-item {{ Request::is('admin/quotations/drafts') || Request::is('admin/quotations*')? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.quotations.drafts') }}" title="{{ \App\CPU\translate('quotations') }}">
                <span class="tio-circle nav-indicator-icon"></span>
                <span class="text-truncate i">{{ \App\CPU\translate('مسودات عرض سعر') }}</span>
            </a>
        </li>
        <!--    <li class="nav-item {{ Request::is('admin/admin/pos*') && request('type') == 12 ? 'active' : '' }}">-->
        <!--    <a class="nav-link" href="{{ route('admin.pos.index', ['type' => 12]) }}" title="{{ \App\CPU\translate('list_stock') }}">-->
        <!--        <span class="tio-circle nav-indicator-icon"></span>-->
        <!--        <span class="text-truncate i">{{ \App\CPU\translate('مشتريات') }}</span>-->
        <!--    </a>-->
        <!--</li>-->
    
           <li class="nav-item {{Request::is('admin/installments*')?'active':''}}">
            <a class="nav-link " href="{{route('admin.installments.index')}}"
               title="{{\App\CPU\translate('refunds')}}">
                <span class="tio-circle nav-indicator-icon"></span>
                <span class="text-truncate i">{{\App\CPU\translate('الأقساط')}}
                    <span class="badge badge-success ml-2"></span>
                </span>
            </a>
        </li>
              
      
    </ul>
</li>
{{--<li class="navbar-vertical-aside-has-menu ">
    <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:" >
        <i class="tio-shopping nav-icon"></i>
        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
            {{ \App\CPU\translate('الكاشير') }}
        </span>
    </a>
        <ul class="js-navbar-vertical-aside-submenu nav nav-sub {{  Request::is('admin/pos/1')||Request::is('/admin/session/all')|| Request::is('admin/session/orders')|| Request::is('admin/session/returns') ? 'd-block' : '' }}">

             <li class="nav-item {{ Request::is('admin/pos/1') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.pos.index', ['type' => 1]) }}" title="{{ \App\CPU\translate('cashier') }}">
                <span class="tio-circle nav-indicator-icon"></span>
                <span class="text-truncate i">{{ \App\CPU\translate('كاشير') }}</span>
            </a>
        </li> 
           <li class="nav-item {{ Request::is('/admin/session/all') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.pos.session.index') }}" title="{{ \App\CPU\translate('cashier') }}">
                <span class="tio-circle nav-indicator-icon"></span>
                <span class="text-truncate i">{{ \App\CPU\translate('الجلسات الحالية') }}</span>
            </a>
        </li> 
             <li class="nav-item {{ Request::is('admin/session/orders') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.session.orders') }}" title="{{ \App\CPU\translate('cashier') }}">
                <span class="tio-circle nav-indicator-icon"></span>
                <span class="text-truncate i">{{ \App\CPU\translate('مبيعات الكاشير') }}</span>
            </a>
        </li> 
              <li class="nav-item {{ Request::is('admin/session/returns') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.session.returns') }}" title="{{ \App\CPU\translate('cashier') }}">
                <span class="tio-circle nav-indicator-icon"></span>
                <span class="text-truncate i">{{ \App\CPU\translate('مرتجعات الكاشير') }}</span>
            </a>
        </li> 
       
      
    </ul>
</li>--}}

                        <!-- Pos Pages -->
                             <li class="navbar-vertical-aside-has-menu">
    <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:">
        <i class="fa-solid fa-file-invoice nav-icon"></i> 
        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{\App\CPU\translate('نظام المشتريات')}}</span>
    </a>
    <ul class="js-navbar-vertical-aside-submenu nav nav-sub {{
 
        Request::is('admin/admin/TransactionSeller') || 
        Request::is('admin/supplier*')||
        Request::is('admin/pos/sample') || 
        Request::is('admin/pos/donations') ||
        Request::is('admin/purchase_invoice/create')|| 
        Request::is('admin/pos/pos/24')||
        Request::is('admin/pos/reservations/4/all') || 
        Request::is('admin/pos/reservations/7/all') || 
        
        Request::is('admin/pos/stocks') 
        ? 'd-block' 
        : '' 
    }}">
              <li class="nav-item {{ Request::is('admin/purchase_invoice/create') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.purchase_invoice.create') }}" title="{{ \App\CPU\translate('list_stock') }}">
                <span class="tio-circle nav-indicator-icon"></span>
                <span class="text-truncate i">{{ \App\CPU\translate('مشتريات') }}</span>
            </a>
        </li>
            <li class="nav-item {{ Request::is('admin/pos/pos/24') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.pos.index', ['type' => 24]) }}" title="{{ \App\CPU\translate('list_stock') }}">
                <span class="tio-circle nav-indicator-icon"></span>
                <span class="text-truncate i">{{ \App\CPU\translate('مرتجع مشتريات') }}</span>
            </a>
        </li>
        <!--<li class="nav-item {{Request::is('admin/admin/TransactionSeller')?'active':''}}">-->
        <!--    <a class="nav-link " href="{{route('admin.TransactionSeller.index')}}"-->
        <!--       title="{{\App\CPU\translate('list_of_admin')}}">-->
        <!--        <span class="tio-circle nav-indicator-icon"></span>-->
        <!--        <span class="text-truncate i">{{\App\CPU\translate('تحويلات المناديب')}}</span>-->
        <!--        <span class="badge badge-success ml-2">{{\App\Models\TransactionSeller::get()->count()}} </span>-->
        <!--    </a>-->
        <!--</li>-->
      
        <li class="nav-item {{Request::is('admin/pos/sample')?'active':''}}">
            <a class="nav-link " href="{{route('admin.pos.sample')}}"
               title="{{\App\CPU\translate('sample')}}">
                <span class="tio-circle nav-indicator-icon"></span>
                <span class="text-truncate i">{{\App\CPU\translate('فواتير مشتريات')}}
                    <span class="badge badge-success ml-2">{{\App\Models\Order::where('type', 12)->get()->count()}}</span>
                </span>
            </a>
        </li>
        <li class="nav-item {{Request::is('admin/pos/donations')?'active':''}}">
            <a class="nav-link " href="{{route('admin.pos.donations')}}"
               title="{{\App\CPU\translate('donations')}}">
                <span class="tio-circle nav-indicator-icon"></span>
                <span class="text-truncate i">{{\App\CPU\translate('فواتير مرتجعات')}}
                    <span class="badge badge-success ml-2">{{\App\Models\Order::where('type', 24)->get()->count()}}</span>
                </span>
            </a>
        </li>
              <li class="nav-item {{Request::is('admin/supplier/add')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.supplier.add')}}"
                                       title="{{\App\CPU\translate('add_new_supplier')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate i">{{\App\CPU\translate('اضافة مورد')}}</span>
                                    </a>
                                </li>

                                <li class="nav-item {{Request::is('admin/supplier/list')||Request::is('admin/supplier*')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.supplier.list')}}"
                                       title="{{\App\CPU\translate('list_of_suppliers')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate i">{{\App\CPU\translate('قائمة الموردين')}}</span>
                                    </a>
                                </li>
   
        <!--<li class="nav-item {{Request::is('admin/pos/reservations/4/all')?'active':''}}">-->
        <!--    <a class="nav-link" href="{{ route('admin.pos.reservations', ['type' => 4, 'active' => 'all']) }}" title="{{ \App\CPU\translate('reservations') }}">-->
        <!--        <span class="tio-circle nav-indicator-icon"></span>-->
        <!--        <span class="text-truncate">{{ \App\CPU\translate('الحجوزات') }}-->
        <!--            <span class="badge badge-success ml-2">{{ \App\Models\ReserveProduct::where('type', 4)->count() }}</span>-->
        <!--        </span>-->
        <!--    </a>-->
        <!--</li>-->
        <!--<li class="nav-item {{ Request::is('admin/pos/reservations/7/all') ? 'active' : '' }}">-->
        <!--    <a class="nav-link" href="{{ route('admin.pos.reservations', ['type' => 7, 'active' => 'all']) }}" title="{{ \App\CPU\translate('reservations') }}">-->
        <!--        <span class="tio-circle nav-indicator-icon"></span>-->
        <!--        <span class="text-truncate">{{ \App\CPU\translate('رد الحجوزات') }}-->
        <!--            <span class="badge badge-success ml-2">{{ \App\Models\ReserveProduct::where('type', 7)->count() }}</span>-->
        <!--        </span>-->
        <!--    </a>-->
        <!--</li>-->
        <!--<li class="nav-item {{Request::is('admin/pos/stocks')?'active':''}}">-->
        <!--    <a class="nav-link " href="{{route('admin.pos.stocks')}}"-->
        <!--       title="{{\App\CPU\translate('stock_travels')}}">-->
        <!--        <span class="tio-circle nav-indicator-icon"></span>-->
        <!--        <span class="text-truncate">{{\App\CPU\translate('رحلات العربيات')}}-->
        <!--            <span class="badge badge-success ml-2">{{\App\Models\StockOrder::count()}}</span>-->
        <!--        </span>-->
        <!--    </a>-->
        <!--</li>-->
    </ul>
</li>


      
      
                        <li class="navbar-vertical-aside-has-menu">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:">
                                <i class="tio-shopping nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{\App\CPU\translate('نظام إدارة المخزون')}}</span>
                            </a>
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub {{Request::is('admin/transfer*')||Request::is('admin/vehicle-stock*')||Request::is('admin/vehicle-stock/create')||Request::is('admin/stockbatch')||Request::is('/admin/transfer')||Request::is('admin/unit*')|| Request::is('admin/category/add')||Request::is('admin/product/list') ||Request::is('admin/product/add')||Request::is('admin/product/addexpire')||Request::is('admin/product/edit*')||Request::is('admin/product/barcode-generate*')||Request::is('admin/inventory_adjustments/create')||Request::is('admin/inventory_adjustments')||Request::is('admin/product/product_type')?'d-block':''}}">
                                         <li class="navbar-vertical-aside-has-menu {{ Request::is('admin/category/add')||Request::is('admin/inventory_adjustments/create')||Request::is('admin/inventory_adjustments*')||Request::is('admin/inventory_adjustments/edit*')||Request::is('admin/product/product_type') ? 'active' : '' }}">
                                    <li class="nav-item {{Request::is('admin/category/add')?'active':''}}">

                                    <a class="js-navbar-vertical-aside-menu-link nav-link" href="{{route('admin.category.add')}}"
                                       title="{{\App\CPU\translate('add_new_category')}}">
                <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate i">{{\App\CPU\translate('الاقسام')}}</span>
                                    </a>
                                </li>
                                    <li class="nav-item {{Request::is('admin/unit/index/2')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
href="{{ route('admin.unit.index', ['units' => 2]) }}"
                            >
                <span class="tio-circle nav-indicator-icon"></span>
<span class="text-truncate i">                                    {{\App\CPU\translate(' وحدات قياس الكبري')}}
                                </span>
                            </a>
                        </li>
                         <li class="nav-item {{Request::is('admin/unit/index/1')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
href="{{ route('admin.unit.index', ['units' => 1]) }}"
                            >
                <span class="tio-circle nav-indicator-icon"></span>
<span class="text-truncate i">                                    {{\App\CPU\translate(' وحدات قياس الصغري')}}
                                </span>
                            </a>
                        </li>
                            <li class="nav-item {{Request::is('admin/product/add')||Request::is('admin/product/product_type')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.product.product_type')}}"
                                       title="{{\App\CPU\translate('add_new_product')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate i">{{\App\CPU\translate('اضافة منتج')}}</span>
                                    </a>
                                </li>

                                <li class="nav-item {{Request::is('admin/product/list')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.product.list')}}"
                                       title="{{\App\CPU\translate('list_of_products')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate i">{{\App\CPU\translate('قائمة المنتجات')}}</span>
                                    </a>
                                </li>
                                  <li class="nav-item {{Request::is('admin/product/addexpire')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.product.addexpire')}}"
                                       title="{{\App\CPU\translate('add_new_product')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate i">{{\App\CPU\translate('اضافة منتج هالك')}}</span>
                                    </a>
                                </li>
    <li class="nav-item {{Request::is('admin/transfer/create')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.transfer.create')}}"
                                       title="{{\App\CPU\translate('add_stock')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate i">{{\App\CPU\translate('امر تحويل مخزني')}}</span>
                                    </a>
                                </li>

                                   <li class="nav-item {{Request::is('admin/transfer')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.transfer.index')}}"
                                       title="{{\App\CPU\translate('list_stock')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate i">{{\App\CPU\translate('قائمة التحويلات')}}</span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('admin/stockbatch')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.stockbatch.index')}}"
                                       title="{{\App\CPU\translate('list_stock')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate i">{{\App\CPU\translate(' المنتجات داخل المخازن')}}</span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('admin/inventory_adjustments/create')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.inventory_adjustments.create')}}"
                                       title="{{\App\CPU\translate('add_stock')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate i">{{\App\CPU\translate('امر جرد مخزني')}}</span>
                                    </a>
                                </li>
      <li class="nav-item {{Request::is('admin/inventory_adjustments')||Request::is('admin/inventory_adjustments/edit*')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.inventory_adjustments.index')}}"
                                       title="{{\App\CPU\translate('list_stock')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate i">{{\App\CPU\translate('قائمة الجرد')}}</span>
                                    </a>
                                </li>
                            
                       
                        </li>

                            </ul>
                        {{--<li class="navbar-vertical-aside-has-menu ">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:"
                            >
<i class="fa-solid fa-truck-fast nav-icon"></i>
<span
                                    class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{\App\CPU\translate('تطبيق المناديب')}}</span>
                            </a>
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub {{Request::is('admin/seller*')||Request::is('admin/seller/prices')|| Request::is('admin/admin/showmap')||Request::is('admin/visitors') ||Request::is('admin/stores*')||Request::is('admin/vehicle-stock*')||Request::is('admin/vehicle-stock/create')||Request::is('admin/pos/reservations_notification/4/1')||Request::is('admin/pos/reservations_notification/7/1')||Request::is('admin/pos/reservations_notification/3/2')||Request::is('admin/visitors/create')?'d-block':''}}">
                                  <li class="nav-item {{Request::is('admin/stores')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.stores.index')}}"
                                       title="{{\App\CPU\translate('list_stock')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate i">{{\App\CPU\translate('قائمة السيارات')}}</span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('admin/seller/add')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.seller.add')}}"
                                       title="{{\App\CPU\translate('add_new_seller')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate i">{{\App\CPU\translate('اضافة مندوب')}}</span>
                                    </a>
                                </li>

                                <li class="nav-item {{Request::is('admin/seller/list') ||Request::is('admin/seller/prices*')||Request::is('admin/seller/edit*') || Request::is('admin/seller/prices/edit*')  ?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.seller.list')}}"
                                       title="{{\App\CPU\translate('list_of_seller')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate i">{{\App\CPU\translate('قائمة مناديب')}}</span>
                                    </a>
                                </li>
                                 <li class="nav-item {{Request::is('admin/visitors/create')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.visitor.create')}}"
                                       title="{{\App\CPU\translate('add_stock')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate i">{{\App\CPU\translate('تسجيل زيارات الشهر')}}</span>
                                    </a>
                                </li>
                                   <li class="nav-item {{Request::is('admin/visitors')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.visitor.index')}}"
                                       title="{{\App\CPU\translate('list_stock')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate i">{{\App\CPU\translate('قائمة الزيارات الشهر ')}}</span>
                                    </a>
                                </li>
                               
                                     <li class="nav-item {{Request::is('admin/admin/showmap')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.admin.showmap')}}"
                                       title="{{\App\CPU\translate('list_of_admin')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate i">{{\App\CPU\translate('خريطة المناديب')}}</span>
                                    </a>
                                </li>
                                   <li class="nav-item {{Request::is('admin/vehicle-stock/create')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.stock.create')}}"
                                       title="{{\App\CPU\translate('add_stock')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate i">{{\App\CPU\translate('امر صرف مخزني')}}</span>
                                    </a>
                                </li>
                                        <li class="nav-item {{ Request::is('admin/pos/reservations_notification/4/1') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.pos.reservation_list_notification', ['type' => 4, 'active' => 1]) }}"
               title="{{ \App\CPU\translate('list_stock') }}">
                <span class="tio-circle nav-indicator-icon"></span>
                <span class="text-truncate i">{{ \App\CPU\translate('امر توريد بضاعة') }}</span>
                <span class="badge badge-success ml-2">{{ \App\Models\ReserveProduct::where('type', 4)->where('active',1)->count() }}</span>
            </a>
        </li>
        <li class="nav-item {{ Request::is('admin/pos/reservations_notification/7/1') ? 'active' : '' }}">
<a class="nav-link" href="{{ route('admin.pos.reservation_list_notification', ['type' => 7, 'active' => 1]) }}">
                <span class="tio-circle nav-indicator-icon"></span>
                <span class="text-truncate i">{{ \App\CPU\translate('امر مرتجع بضاعة') }}</span>
                <span class="badge badge-success ml-2">{{ \App\Models\ReserveProduct::where('type', 7)->where('active',1)->count() }}</span>
            </a>
        </li>
         <li class="nav-item {{ Request::is('admin/pos/reservations_notification/3/2') ? 'active' : '' }}">
<a class="nav-link" href="{{ route('admin.pos.reservation_list_notification', ['type' => 3, 'active' => 2]) }}">
                <span class="tio-circle nav-indicator-icon"></span>
                <span class="text-truncate i">{{ \App\CPU\translate('اوامر الصرف بضاعة') }}</span>
                <span class="badge badge-success ml-2">{{ \App\Models\ReserveProduct::where('type', 3)->where('active',2)->count() }}</span>
            </a>
        </li>
                <li class="nav-item {{Request::is('admin/vehicle-stock')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.stock.index')}}"
                                       title="{{\App\CPU\translate('list_stock')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate i">{{\App\CPU\translate(' المنتجات داخل السيارات')}}</span>
                                    </a>
                                </li>
                                              <li class="nav-item {{Request::is('admin/pos/installments')?'active':''}}">
            <a class="nav-link " href="{{route('admin.pos.installments')}}"
               title="{{\App\CPU\translate('installments')}}">
                <span class="tio-circle nav-indicator-icon"></span>
                <span class="text-truncate i">{{\App\CPU\translate('التحصيلات')}}
                    <span class="badge badge-success ml-2">{{\App\Models\Installment::get()->count()}}</span>
                </span>
            </a>
        </li>
                            </ul>
                        </li>--}}

                         <li class="navbar-vertical-aside-has-menu">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:">
                                <i class="tio-poi-user nav-icon"></i>
                                <span
                                    class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{\App\CPU\translate('الموارد البشرية')}}<span class="hr" style="font-size:20px;"></span></span>
                            </a>
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub {{Request::is('admin/staff/add')|| Request::is('admin/staff/list')|| Request::is('admin/staff/edit*')|| Request::is('admin/admin/salaries/createrating')||Request::is('admin/admin/developsellers*')||Request::is('admin/coursesellers/create')||Request::is('admin/coursesellers/list')||Request::is('admin/job_applicants/create')||Request::is('admin/coursesellers')||Request::is('admin/job_applicants*')||Request::is('admin/interview-evaluations*')||Request::is('admin/attendance*')||Request::is('admin/admin/salaries/create')||Request::is('admin/admin/salaries')?'d-block':''}}">
 <li class="nav-item {{Request::is('admin/staff/add')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.staff.add')}}"
                                       title="{{\App\CPU\translate('add_new_seller')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate i">{{\App\CPU\translate('اضافة موظف')}}</span>
                                    </a>
                                </li>
                                 <li class="nav-item {{Request::is('admin/job_applicants/create')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.job_applicants.create')}}"
                                       title="{{\App\CPU\translate('add_new_seller')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate i">{{\App\CPU\translate('اضافة طلب توظيف')}}</span>
                                    </a>
                                </li>
                                    <li class="nav-item {{Request::is('admin/job_applicants*')||Request::is('admin/interview-evaluations*') ?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.job_applicants.index')}}"
                                       title="{{\App\CPU\translate('add_new_seller')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate i">{{\App\CPU\translate('قائمة طلبات توظيف')}}</span>
                                    </a>
                                </li>


                                <li class="nav-item {{Request::is('admin/staff/list')||Request::is('admin/staff/edit*') ?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.staff.list')}}"
                                       title="{{\App\CPU\translate('list_of_seller')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate i">{{\App\CPU\translate('قائمة موظفين')}}</span>
                                    </a>
                                </li>
                                  <li class="nav-item {{Request::is('admin/attendance') ?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.attendance.index')}}"
                                       title="{{\App\CPU\translate('list_of_seller')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate i">{{\App\CPU\translate('سجلات الحضور والانصراف ')}}</span>
                                    </a>
                                </li>
                                    <li class="nav-item {{Request::is('admin/admin/salaries/attendance')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.salaries.createrating')}}"
                                       title="{{\App\CPU\translate('list_of_admin')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate i">{{\App\CPU\translate('تقييم موظف')}}</span>
                                    </a>
                                </li>
                                
                                   <li class="nav-item {{Request::is('admin/admin/developsellers/0')||Request::is('admin/admin/developsellers/create/0')?'active':''}}">
<a class="nav-link" href="{{ route('admin.developsellers.index', ['type' => 0]) }}" title="{{\App\CPU\translate('list_of_admin')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate i">{{\App\CPU\translate('تطوير موظف')}}</span>
                                    </a>
                                </li>
                                    <li class="nav-item {{Request::is('admin/coursesellers*')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.coursesellers.index')}}"
                                       title="{{\App\CPU\translate('list_of_admin')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate i">{{\App\CPU\translate('كورسات موظف')}}</span>
                                    </a>
                                </li>
                                    <li class="nav-item {{Request::is('admin/admin/developsellers/1')?'active':''}}">
<a class="nav-link" href="{{ route('admin.developsellers.index', ['type' => 1]) }}" title="{{\App\CPU\translate('list_of_admin')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate i">{{\App\CPU\translate('طلبات موظف')}}</span>
                                    </a>
                                </li>
                                   <li class="nav-item {{Request::is('admin/admin/developsellers/2')?'active':''}}">
<a class="nav-link" href="{{ route('admin.developsellers.index', ['type' => 2]) }}" title="{{\App\CPU\translate('list_of_admin')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate i">{{\App\CPU\translate('طلبات اجازة')}}</span>
                                    </a>
                                </li>
                                 <li class="nav-item {{Request::is('admin/admin/salaries/create')?'active':''}}">
                <a class="nav-link " href="{{route('admin.salaries.create')}}"
                   title="{{\App\CPU\translate('list_of_admin')}}">
                    <span class="tio-circle nav-indicator-icon"></span>
                    <span class="text-truncate i">{{\App\CPU\translate('دفع مرتب')}}</span>
                </a>
            </li>

            <li class="nav-item {{Request::is('admin/admin/salaries')?'active':''}}">
                <a class="nav-link " href="{{route('admin.salaries.index')}}"
                   title="{{\App\CPU\translate('list_of_admin')}}">
                    <span class="tio-circle nav-indicator-icon"></span>
                    <span class="text-truncate i">{{\App\CPU\translate('مراجعة المرتبات')}}</span>
                </a>
            </li>
  
                            </ul>
                        </li>

                        <!-- End Dashboards -->

                        <!-- Pos End Pages -->

                        



                          
                        
                        <!-- Stores Pages-->
         
                        <!-- Pos End Pages -->

                        <!-- category Pages -->

            

                        <!-- category End Pages -->

                      
                        </li>
                                               <li class="navbar-vertical-aside-has-menu">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:">
            <i class="tio-report nav-icon"></i>
            <span  class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{ \App\CPU\translate('قسم التقارير') }}</span>
        </a>
<ul class="js-navbar-vertical-aside-submenu nav nav-sub {{Request::is('admin/product/getreportProducts') ||Request::is('admin/product/getreportProductsPurchase')||Request::is('admin/tax/listalltodaynew')||Request::is('admin/product/getreportProductsSales*')||Request::is('admin/tax/list/tax')||Request::is('admin/tax/list/box')||Request::is('admin/tax/list/listalltodaybyseller')||Request::is('admin/product/getreportMainStock')||Request::is('admin/product/getReportProductsAllStock')||Request::is('admin/product/listreportexpire')||Request::is('admin/stock/stock-limit')|| Request::is('admin/productsunlike')||Request::is('admin/product/listexpireinvoice') ?'d-block':''}}">    
      <li class="nav-item {{Request::is('admin/pos/orders')?'active':''}}">
            <a class="nav-link " href="{{route('admin.pos.orders')}}"
               title="{{\App\CPU\translate('orders')}}">
                <span class="tio-circle nav-indicator-icon"></span>
                <span class="text-truncate i">{{\App\CPU\translate('فواتير المبيعات')}}
                    <span class="badge badge-success ml-2">{{\App\Models\Order::where('type', 4)->get()->count()}}</span>
                </span>
            </a>
        </li>
        <li class="nav-item {{Request::is('admin/pos/refunds')?'active':''}}">
            <a class="nav-link " href="{{route('admin.pos.refunds')}}"
               title="{{\App\CPU\translate('refunds')}}">
                <span class="tio-circle nav-indicator-icon"></span>
                <span class="text-truncate i">{{\App\CPU\translate('فواتير المرتجعات')}}
                    <span class="badge badge-success ml-2">{{\App\Models\Order::where('type', 7)->get()->count()}}</span>
                </span>
            </a>
        </li>

    <!--<li class="nav-item {{Request::is('admin/account/list-expense')?'active':''}}">-->
    <!--            <a class="nav-link" href="{{ route('admin.account.listExpense') }}">-->
    <!--                <span class="tio-circle nav-indicator-icon"></span>-->
    <!--                <span class="text-truncate">{{\App\CPU\translate('تقرير بنود مصروفات ')}}</span>-->
    <!--            </a>-->
    <!--        </li>-->
              
                                   <li class="nav-item {{Request::is('admin/product/listexpireinvoice')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.product.listexpireinvoice')}}"
                                       title="{{\App\CPU\translate('listexpireinvoice')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate i">{{\App\CPU\translate('قائمة اوامر الهالك')}}</span>
                                    </a>
                                </li>
<li class="nav-item {{ Request::is('admin/product/getreportProducts') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.product.getreportProducts') }}" title="{{ \App\CPU\translate('getreportProducts') }}">
                             <span class="tio-circle nav-indicator-icon"></span>

                <span class="text-truncate i">{{ \App\CPU\translate('كشف المنتجات المباعة') }}</span>
            </a>
        </li>
         <li class="nav-item {{ Request::is('admin/product/getreportProductsPurchase') ? 'active' : '' }}">
             
            <a class="nav-link" href="{{ route('admin.product.getreportProductsPurchase') }}" title="{{ \App\CPU\translate('getreportProductsPurchase') }}">
                                             <span class="tio-circle nav-indicator-icon"></span>

                <span class="text-truncate i">{{ \App\CPU\translate('كشف  المشتريات') }}</span>
            </a>
        </li>
            <li class="nav-item {{ Request::is('admin/tax/listalltodaynew') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.taxe.listalltodaynew') }}" title="{{ \App\CPU\translate('listalltodaynew') }}">
                <span class="tio-circle nav-indicator-icon"></span>
                    <span class="text-truncate i">{{ \App\CPU\translate('تقرير نقاط البيع') }}</span>
                </a>
            </li>
         <li class="nav-item {{ Request::is('admin/product/getreportProductsSales/1') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.product.getreportProductsSales', ['type' => 1]) }}" title="{{ \App\CPU\translate('getreportProductsSales') }}">
                                <span class="tio-circle nav-indicator-icon"></span>

                <span class="text-truncate i">{{ \App\CPU\translate('هامش الربح والخسارة') }}</span>
            </a>
        </li>
        <li class="nav-item {{ Request::is('admin/product/getreportProductsSales/0') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('admin.product.getreportProductsSales', ['type' => 0]) }}" title="{{ \App\CPU\translate('getreportProductsSales') }}">
                                                            <span class="tio-circle nav-indicator-icon"></span>

        <span class="text-truncate i">{{ \App\CPU\translate('الكميات المباعة للمندوبين') }}</span>
    </a>
</li>
           <li class="nav-item {{ Request::is('admin/tax/list/tax') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.taxe.listall') }}" title="{{ \App\CPU\translate('list_of_taxes') }}">
                                                    <span class="tio-circle nav-indicator-icon"></span>

                    <span class="text-truncate i">{{ \App\CPU\translate('قائمة  الضرائب ') }}</span>
                </a>
            </li>
            <li class="nav-item {{ Request::is('admin/tax/list/box') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.taxe.listalltoday') }}" title="{{ \App\CPU\translate('list_of_taxes') }}">
                                                    <span class="tio-circle nav-indicator-icon"></span>

                    <span class="text-truncate i">{{ \App\CPU\translate('قائمة  الصندوق ') }}</span>
                </a>
            </li>
            <li class="nav-item {{ Request::is('admin/tax/list/listalltodaybyseller') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.taxe.listalltodaybyseller') }}" title="{{ \App\CPU\translate('list_of_taxes') }}">
                                                                 <span class="tio-circle nav-indicator-icon"></span>

                    <span class="text-truncate i">{{ \App\CPU\translate('قائمة  الصندوق اليومي ') }}</span>
                </a>
            </li>
          <li class="nav-item {{ Request::is('admin/product/getreportMainStock') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.product.getreportMainStock') }}" title="{{ \App\CPU\translate('getreportMainStock') }}">
                                                                                 <span class="tio-circle nav-indicator-icon"></span>

                <span class="text-truncate i">{{ \App\CPU\translate('كشف المستودع الرئيسي') }}</span>
            </a>
        </li>
        <!-- <li class="nav-item {{ Request::is('admin/product/getReportProductsAllStock') ? 'active' : '' }}">-->
        <!--    <a class="nav-link" href="{{ route('admin.product.getReportProductsAllStock') }}" title="{{ \App\CPU\translate('getReportProductsAllStock') }}">-->
        <!--                                                                                         <span class="tio-circle nav-indicator-icon"></span>-->

        <!--        <span class="text-truncate">{{ \App\CPU\translate('كشف المستودعات') }}</span>-->
        <!--    </a>-->
        <!--</li>-->
        <li class="nav-item {{ Request::is('admin/product/listreportexpire') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.product.listreportexpire') }}" title="{{ \App\CPU\translate('list_of_products') }}">
                                                                                                 <span class="tio-circle nav-indicator-icon"></span>

                <span class="text-truncate i">{{ \App\CPU\translate('كشف الصلاحية') }}</span>
            </a>
        </li>

        <li class="nav-item {{ Request::is('admin/stock/stock-limit') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.stock.stock-limit') }}">
                                                                                                 <span class="tio-circle nav-indicator-icon"></span>
                <span class="text-truncate i">{{ \App\CPU\translate('كشف نواقص') }}</span>
            </a>
        </li>

        <li class="nav-item {{ Request::is('admin/productsunlike') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.ordernotification.Productunlike') }}" title="{{ \App\CPU\translate('list_of_products') }}">
                <span class="tio-circle nav-indicator-icon"></span>

                <span class="text-truncate i">{{ \App\CPU\translate('كشف الركود') }}</span>
            </a>
        </li>
         
        
    </ul>
</li>

                        <!--unit end -->

                     

                        <!-- Product Pages -->

                 

                        <!-- Product End Pages -->
                        <!--<li class="nav-item">-->
                        <!--    <small-->
                        <!--        class="nav-subtitle">{{\App\CPU\translate('قسم البيزنس')}}</small>-->
                        <!--    <small class="tio-more-horizontal nav-subtitle-replacer"></small>-->
                        <!--</li>-->
                        <!-- Coupon End Pages -->
                        <!--<li class="navbar-vertical-aside-has-menu {{Request::is('admin/coupon*')?'active':''}}">-->
                        <!--    <a class="js-navbar-vertical-aside-menu-link nav-link"-->
                        <!--       href="{{route('admin.coupon.add-new')}}">-->
                        <!--        <i class="tio-gift nav-icon"></i>-->
                        <!--        <span-->
                        <!--            class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{\App\CPU\translate('كوبونات الخصومات')}}</span>-->
                        <!--    </a>-->
                        <!--</li>-->


                       
                        <!-- Admin Pages -->
                              



                                         
                        <!-- Coupon End Pages -->

                        <!-- Account start pages -->
            
                        <!-- Account End pages -->

                      
                        <!-- Customer Pages -->
                   

                            

                        <!-- Admin end Pages -->
    
                        <!-- Settings Start Pages -->

                     
                               

                     
                    </ul>
                </div>
                <!-- End Content -->
            </div>
        </div>
    </aside>
</div>



@push('script_2')
    <script src={{asset("public/assets/admin/js/accounts.js")}}></script>
<script>
    $(document).ready(function () {
        $('.table').DataTable({
            "paging": false,
            "ordering": true,
            "info": false,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/Arabic.json"
            }
        });
    });
    
</script>


@endpush
