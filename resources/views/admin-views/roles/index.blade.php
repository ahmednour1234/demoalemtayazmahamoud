@extends('layouts.admin.app')

@section('content')
<style>
    /* جدول الأدوار: مسافات واضحة بين الصفوف */
    .roles-table { border-collapse: separate !important; border-spacing: 0 10px !important; }
    .roles-table tbody td { background:#fff; border:1px solid #eee; }
    .roles-table tbody td:first-child { border-radius:12px 0 0 12px; }
    .roles-table tbody td:last-child  { border-radius:0 12px 12px 0; }

    /* مودال: تحكم كامل في الارتفاع + جعل الهيدر والفوتر ثابتين */
    .modal-xl{max-width:1140px}
    .modal-dialog.modal-dialog-scrollable .modal-content{
        display:flex; flex-direction:column; max-height:92vh; overflow:hidden;
    }
    .modal-header{ position:sticky; top:0; z-index:5; background:#fff; }
    .modal-footer{ position:sticky; bottom:0; z-index:5; background:#fff; box-shadow:0 -6px 12px rgba(0,0,0,.04); }
    .modal-body{ flex:1 1 auto; min-height:0; overflow:hidden; display:flex; flex-direction:column; }

    /* Tabs + محتوى التبويب يتمدّد */
    .nav-tabs .nav-link{font-weight:600}
    .nav-tabs .nav-link.active{background:#f8fafc;border-color:#dee2e6 #dee2e6 #fff}
    .tab-content{ flex:1 1 auto; min-height:0; display:flex; flex-direction:column; }
    .tab-pane{ display:none; flex:1 1 auto; min-height:0; }
    .tab-pane.active{ display:flex; flex-direction:column; min-height:0; }

    /* Card + Scroll داخل التبويب */
    .perm-card{
        border:1px solid #eee;border-radius:14px;padding:14px 16px;margin-bottom:18px;background:#fff;
        display:flex; flex-direction:column; min-height:0;
    }
    .perm-card .card-head{
        display:flex;align-items:center;justify-content:space-between;margin-bottom:10px
    }

    /* Scroll داخل كل تبويب (الارتفاع بيتحدد عبر متغير CSS) */
    .perm-scroll{
        height: var(--perm-h, 60vh);
        overflow-y:auto; padding-right:4px;
        -webkit-overflow-scrolling: touch;
        scroll-padding-bottom:100px;
    }
    /* Spacer بسيط لضمان ظهور آخر صف فوق الفوتر */
    .perm-scroll::after{ content:""; display:block; height:80px; }

    /* جدول الصلاحيات مع فراغات وهيدر ثابت داخل منطقة السكورل */
    .perm-table{width:100%; border-collapse: separate !important; border-spacing: 0 12px !important;}
    .perm-table thead th{
        position:sticky; top:0; background:#f8fafc; z-index:2;
        padding:12px; border-bottom:1px solid #e9ecef;
    }
    .perm-table tbody td{padding:12px 14px; vertical-align:top; background:#fff;}
    .perm-table tbody td:first-child{border:1px solid #e5e7eb; border-right:none; border-radius:12px 0 0 12px;}
    .perm-table tbody td:nth-child(2){border-top:1px solid #e5e7eb; border-bottom:1px solid #e5e7eb;}
    .perm-table tbody td:last-child{border:1px solid #e5e7eb; border-left:none; border-radius:0 12px 12px 0;}
    .perm-row:hover td{background:#fcfcfc}

    /* Badges أوضح */
    .perm-badges{display:flex;flex-wrap:wrap;gap:10px; padding-bottom:10px;}
    .perm-badge{
        display:inline-flex;align-items:center;gap:8px;
        border:1px solid #e5e7eb;border-radius:10px;padding:8px 12px;background:#fafafa;
    }

    .fw-bold{font-weight:700}
    .text-muted{color:#6c757d}
    .small{font-size:.875rem}

    /* تحسين الجدول العام */
    .table { width:100%; color:#000; background-color:#fff; }
</style>

<div class="content container-fluid">
    {{-- Breadcrumb --}}
    <div class="mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white px-3 py-2 rounded shadow-sm">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}" class="text-secondary">
                        <i class="tio-home-outlined"></i> {{ \App\CPU\translate('الرئيسية') }}
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="#" class="text-primary">{{ \App\CPU\translate('إدارة الأدوار والصلاحيات') }}</a>
                </li>
            </ol>
        </nav>
    </div>

    <div class="d-flex justify-content-end mb-3">
        <button class="btn btn-primary" data-toggle="modal" data-target="#addRoleModal">إضافة دور جديد</button>
    </div>

    {{-- قائمة الأدوار --}}
    <div class="row">
        <div class="col-md-12">
            <table class="table align-middle roles-table">
                <thead class="bg-light">
                    <tr>
                        <th style="width:80px">#</th>
                        <th>اسم الدور</th>
                        <th style="width:160px">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roles as $index => $role)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $role->name }}</td>
                            <td>
                                <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#editRoleModal{{ $role->id }}">تعديل</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted">لا توجد أدوار بعد</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@php
# 1) الرئيسية
$mainSection = [
    'الرئيسية' => [
        'dashboard.list' => 'عرض لوحة التحكم',
    ],
];

# 2) المحاسبة المالية
$financePermissions = [
    // القائمة الأساسية
    'شجرة الحسابات' => [
        'account.index'   => 'عرض',
        'account.store'   => 'إضافة',
        'account.update'  => 'تعديل',
        'account.destroy' => 'حذف',
    ],
    'الأرصدة الافتتاحية' => [
        'start.store' => 'إضافة',
    ],

    // العمليات
    'العمليات — السندات' => [
        'expense100.store' => 'إضافة سند صرف',
        'expense200.store' => 'إضافة سند قبض',
    ],
    'العمليات — القيود اليومية' => [
        'transfer.store'                          => 'إضافة قيد يومي',
        'finance.reports.journal_entries'         => 'عرض القيود اليومية',
        'finance.reports.journal_entries.show'    => 'عرض تفاصيل قيد يومي',
        'finance.reports.journal_entries.update'  => 'تعديل قيد يومي',
        'finance.reports.journal_entries.reverse' => 'عكس قيد يومي',
                'finance.reports.journal_entries.soft_delete' => 'حذف قيد يومي',

    ],

    'العمليات — الأصول الثابتة' => [
        'expense2.store'   => 'إضافة أصل ثابت',
        'asset.ehlak'      => 'إهلاك أصل ثابت',
        'asset.addsayan'   => 'جدولة صيانة أصل',
        'asset.showsayana' => 'صيانة أصل ثابت',
        'asset.koyod'      => 'قيود الأصل الثابت',
        'asset.details'    => 'تفاصيل الأصل الثابت',
    ],

    // التقارير
    'التقارير المالية' => [
        'assets.index'                      => 'الأصول الثابتة',
        'finance.reports.payment_vouchers'  => 'سندات الصرف',
        'finance.reports.receipt_vouchers'  => 'سندات القبض',
        'finance.reports.journal_entries'   => 'القيود اليومية',
        'mizania.report'                    => 'الميزانية العمومية',
        'tadfk.report'                      => 'التدفقات النقدية',
        'mizan.report'                      => 'ميزان المراجعة',
        'kamtdakhl.report'                  => 'قائمة الدخل',
        'yearscustomer.report'              => 'أعمار ديون العملاء',
        'yearssupplier.report'              => 'أعمار ديون الموردين',
        'finance.reports.account_statement' => 'كشف الحساب',
    ],

    // مراكز التكلفة
    'مراكز التكلفة' => [
        'costcenter.index'   => 'عرض',
        'costcenter.store'   => 'إضافة',
        'costcenter.update'  => 'تعديل',
        'costcenter.active'  => 'تفعيل',
        'costcenter.destroy' => 'حذف',
    ],
    'حركات مراكز التكلفة' => [
        'costcenter.transactions.index' => 'عرض',
    ],
    'إجماليات مراكز التكلفة' => [
        'costcenter.totals.index' => 'عرض',
    ],

    // العملاء
    'مناطق العملاء' => [
        'region.index'   => 'عرض',
        'region.store'   => 'إضافة',
        'region.update'  => 'تعديل',
        'region.destroy' => 'تفعيل/تعطيل',
    ],
    'قائمة العملاء' => [
        'customer.index'  => 'عرض',
        'customer.store'  => 'إضافة',
        'customer.update' => 'تعديل',
        'customer.active' => 'تفعيل/تعطيل',
    ],
    'تخصصات العملاء' => [
        'category.index'  => 'عرض',
        'category.store'  => 'إضافة',
        'category.update' => 'تعديل',
        'category.active' => 'تفعيل/تعطيل',
    ],
    'الضمناء' => [
        'guarantors.index'   => 'عرض',
        'guarantors.store'   => 'إضافة',
        'guarantors.update'  => 'تعديل',
        'guarantors.destroy' => 'تفعيل/تعطيل',
    ],
];

# 3) الإعدادات الشاملة
$adminSettingsPermissions = [
    'المستخدمين' => [
        'admin.update'  => 'تحديث المستخدم',
        'admin.index'   => 'عرض المستخدمين',
        'admin.store'   => 'إضافة مستخدم',
        'admin.destroy' => 'حذف مستخدم',
    ],
    'الصلاحيات' => [
        'role.index'  => 'عرض الأدوار',
        'role.store'  => 'إضافة دور',
        'role.update' => 'تحديث دور',
    ],
    'مواعيد العمل' => [
        'shift.index'  => 'عرض المواعيد',
        'shift.store'  => 'إضافة موعد',
        'shift.update' => 'تحديث موعد',
    ],
    'انواع الضرايب' => [
        'tax.index'  => 'عرض الضرائب',
        'tax.store'  => 'إضافة ضريبة',
        'tax.update' => 'تحديث ضريبة',
        'tax.active' => 'تفعيل/تعطيل',
    ],
    'الفروع' => [
        'branch.index'  => 'عرض الفروع',
        'branch.store'  => 'إضافة فرع',
        'branch.update' => 'تحديث فرع',
    ],
    'الحقول المخصصة' => [
        'custom_fields.index'  => 'عرض الحقول',
        'custom_fields.store'  => 'إضافة حقل',
        'custom_fields.update' => 'تحديث حقل',
        'custom_fields.active' => 'تفعيل/تعطيل',
    ],
    'الإعدادات' => [
        'settings.update' => 'تحديث الإعدادات',
        'settings.index'  => 'عرض الإعدادات',
    ],
];

# 4) عملاء المحتملين (Leads)
$adminleadsPermissions = [
    'الحالات' => [
        'status.index'   => 'عرض الحالات',
        'status.store'   => 'إضافة حالة',
        'status.update'  => 'تحديث حالة',
        'status.active'  => 'تفعيل/تعطيل',
        'status.destroy' => 'حذف',
    ],
    'المصادر' => [
        'source.index'   => 'عرض المصادر',
        'source.store'   => 'إضافة مصدر',
        'source.update'  => 'تحديث مصدر',
        'source.active'  => 'تفعيل/تعطيل',
        'source.destroy' => 'حذف',
    ],
    'العملاء المحتملين' => [
        'leads.index'   => 'عرض',
        'leads.show'    => 'رؤية بيانات',
        'leads.store'   => 'إضافة',
        'leads.update'  => 'تحديث',
        'leads.active'  => 'تفعيل/تعطيل',
        'leads.destroy' => 'حذف',
    ],
    'نتائج المكالمات' => [
        'call_outcomes.index'   => 'عرض',
        'call_outcomes.show'    => 'رؤية بيانات',
        'call_outcomes.store'   => 'إضافة',
        'call_outcomes.update'  => 'تحديث',
        'call_outcomes.active'  => 'تفعيل/تعطيل',
        'call_outcomes.destroy' => 'حذف',
    ],
    'سجلات المكالمات' => [
        'call_logs.index'   => 'عرض',
        'call_logs.show'    => 'رؤية بيانات',
        'call_logs.store'   => 'إضافة',
        'call_logs.update'  => 'تحديث',
        'call_logs.active'  => 'تفعيل/تعطيل',
        'call_logs.destroy' => 'حذف',
    ],
    'ملاحظات العميل' => [
        'lead_notes.index'   => 'عرض',
        'lead_notes.show'    => 'رؤية بيانات',
        'lead_notes.store'   => 'إضافة',
        'lead_notes.update'  => 'تحديث',
        'lead_notes.active'  => 'تفعيل/تعطيل',
        'lead_notes.destroy' => 'حذف',
    ],
];

# 5) نقاط البيع (Sales / POS)
$adminsalesPermissions = [
    'مبيعات' => [
        'sales.index'   => 'عرض',
        'sales.store'   => 'تنفيذ',
        'sales.destroy' => 'حذف',
    ],
    'مسودات فواتير بيع' => [
        'sales.draft.index'   => 'عرض',
        'sales.draft.store'   => 'تنفيذ',
        'sales.draft.destroy' => 'حذف',
    ],
    'مرتجع بيع' => [
        'pos7.index' => 'تنفيذ',
    ],
    'عروض الأسعار' => [
        'quotation.create'  => 'إنشاء',
        'quotation.store'   => 'تنفيذ',
        'quotation.update'  => 'تعديل',
        'quotation.index'   => 'عرض',
        'quotation.destroy' => 'حذف',
    ],
    'الأقساط' => [
        'installment.index' => 'عرض',
        'installment.store' => 'استلام نقدية',
        'installment.show'  => 'رؤية',
    ],
];

# 6) المشتريات
$adminpurchasePermissions = [
    'مشتريات' => [
        'purchase.store' => 'إنشاء',
        'order12.index'  => 'عرض',
    ],
    'مرتجع' => [
        'pos24.store' => 'إنشاء',
        'order24.index'         => 'عرض',
    ],
        'الموردين' => [
        'supplier.store' => 'إنشاء',
        'supplier.index'         => 'عرض',
                'supplier.show'  => 'رؤية',
        'supplier.update'  => 'تحديث',
        'supplier.active'  => 'تفعيل',

    ],
];
$adminstockPermissions = [
    'وحدات القياس' => [
           'unit.update' => 'تحديث',
        'unit.index' => 'عرض',
        'unit.store' => 'تخزين',
        'unit.destroy' => 'حذف',
    ],
    'المنتجات' => [
              'product.update' => 'تحديث',
        'product.index' => 'عرض',
        'product.store' => 'تخزين',
        'product.destroy' => 'حذف',
        'product.barcode' => 'باركود',
        'product.show' => 'تتبع',
        'product.expire' => 'اضافة هالك',
        'product.expire.show' => 'قائمة الهالك',
        'product.excel.import' => 'استيراد اكسل',
        'product.excel.export' => 'اصدار اكسل',

    ],
        'تحويلات مخازن' => [
        'transfer.view.all' => 'عرض',
'transfer.view'=>'طباعة',
        'transfer.create' => 'انشاء',
        'transfer.edit' => 'تحديث',
        'transfer.delete' => 'حذف',
        'transfer.accept' => 'موافقة علي تحويل',
    ],
           'جرد مخازن' => [
        'InventoryAdjustment.view.all' => 'عرض',
'InventoryAdjustment.view'=>'طباعة',
        'InventoryAdjustment.create' => 'انشاء',
        'InventoryAdjustment.edit' => 'تحديث',
        'InventoryAdjustment.destroy' => 'حذف',
                'InventoryAdjustment.show' => 'عرض التسوية',
        'InventoryAdjustment.end' => 'انهاء تسوية',
        'InventoryAdjustment.accept' => 'اعتماد تسوية',

    ],
];
$adminhrPermissions = [
    'الموظفين' => [
'staff.update' => 'تحديث موظف',
        'staff.index' => 'عرض الموظفين',
        'staff.store' => 'اضافة موظف',
        'staff.destroy' => 'حذف موظف',
    ],
       'التوظيف' => [
      'interview.store' => 'اضافة طلب توظيف',
        'interview.index' => 'عرض طلب توظيف',
        'interview.update' => 'تحديث طلب توظيف',
        'interview.destroy' => 'حذف طلب توظيف',
    ],
       'المقابلات' => [
             'meeting.store' => 'اضافة مقابلة',
        'meeting.update' => 'تعديل مقابلة',
        'meeting.destroy' => 'حذف مقابلة',
        'meeting.index' => 'تاريخ المقابلات',
    ],
           'الحضور والأنصراف' => [
        'attendace.index' => 'سجلات حضور والانصراف',

    ],
            'تقييم موظف' => [
        'attendace.index' => 'سجلات حضور والانصراف',
                'staff.rate' => 'تقييم موظفين',
        'develop.store'=>'تطوير',
        'develop.update'=>'تعديل تطوير',
        'develop.destroy'=>'حذف تطوير',
        'develop.approve'=>'موفقة علي إجازة',
        'course.store'=>'كورسات ',

    ],
               'الرواتب' => [
   'salary.index' => 'عرض الرواتب',
        'salary.store' => 'دفع مرتب',

    ],
    ];
$adminreportsPermissions = [
    'التفارير' => [
           'order4.index' => 'المبيعات',
        'order7.index' => 'مرتجعات',
    'report.productsales' => 'المنتجات المباعة',
        'report.productpurchases' => 'المشتريات',
        'report.pointsales' => 'نقاط البيع',
        'report.gain' => 'هامش الربح والخسارة',
        'report.tax' => 'الضرائب',
        'report.box' => 'الصندوق',
        'report.boxseller' => 'الصندوق اليومي',
        'report.mainstock' => 'المستودع الرئيسي',
        'report.allstock' => 'جميع المستودعات',
        'report.expire' => 'الصلاحية',
        'report.stocklimit' => 'النواقص',
        'report.unlike' => 'الركود'
    ],
        ];
  $workPermissions = [

    // المشروعات
    'المشروعات' => [
        'project.index'   => 'عرض',
        'project.store'   => 'إضافة',
        'project.update'  => 'تعديل',
        'project.destroy' => 'حذف',
        'project.active'  => 'تفعيل/تعطيل',

        // أعضاء المشروع
        'project.members.store'   => 'إضافة عضو',
        'project.members.destroy' => 'إزالة عضو',
    ],

    // المهام
    'المهام' => [
        'task.index'   => 'عرض',
        'task.store'   => 'إضافة',
        'task.update'  => 'تعديل',
        'task.destroy' => 'حذف',
        'task.active'  => 'تفعيل/تعطيل',
    ],

    // الاعتمادات (Approvals)
    'الاعتمادات' => [
        // إنشاء طلب اعتماد (يُستخدم في ApprovalController@store)
        'task.approval.request' => 'طلب اعتماد',
        // صندوق الاعتمادات + اتخاذ القرار (ApprovalController@index/decide)
        'task.approve'          => 'موافقة/إدارة الاعتمادات',
        // لو كنت عامل Routes مباشرة approve/reject على المهام:
        'task.reject'           => 'رفض (مباشر على المهمة)',
        'task.inbox'            => 'صندوق الاعتمادات', // اسم وصفي فقط؛ قرار السماح يتم عبر task.approve
    ],

    // الإسناد والمتابعة والتعليقات
    'الإسناد والمتابعة' => [
        // إسناد مهمة (TaskAssigneeController@store/destroy)
        'task.assignees.store'   => 'إسناد مهمة',
        'task.assignees.destroy' => 'إزالة إسناد',

        // المتابعات Follow-ups
        // ملاحظة: الكنترولر الحالي بيشيك على مفتاح موحّد "task.followup"
        'task.followup'          => 'إدارة المتابعات (إضافة/تعديل/حذف/تغيير حالة)',

        // مفاتيح دقيقة اختيارية لو حابب تفصيل أعلى (استخدمها لاحقًا أو اربطها كلها بنفس الفحص):
        'task.followups.store'   => 'إضافة متابعة',
        'task.followups.done'    => 'وضع متابعة تمّت',
        'task.followups.destroy' => 'حذف متابعة',

        // التعليقات (CommentController@store/destroy)
        // الكنترولر الحالي بيشيك على "task.comment"
        'task.comment'           => 'إدارة التعليقات (إضافة/حذف)',

        // مفاتيح دقيقة اختيارية للتوسّع لاحقًا:
        'task.comments.store'    => 'إضافة تعليق',
        'task.comments.destroy'  => 'حذف تعليق',
    ],

    // التنبيهات
    'التنبيهات' => [
        'notification.index'   => 'عرض التنبيهات',
        'notification.update'  => 'تحديث/تعليم كمقروء',
        'notification.destroy' => 'حذف تنبيه',
    ],

    // تقارير التنفيذ
    'تقارير التنفيذ' => [
        'work.reports.overdue'      => 'المهام المتأخرة',
        'work.reports.productivity' => 'إنتاجية المستخدم/الفريق',
        'work.reports.team_load'    => 'عبء العمل على الفريق',
    ],
];
$visibilityPermissions = [
    'رؤية البيانات' => [
        'scope.view.all'          => 'عرض الكل',
        'scope.view.branch'       => 'عرض نطاق الفرع',
        'scope.view.department'   => 'عرض نطاق القسم',
        'scope.view.manager_tree' => 'عرض شجرة المدير (مرؤوسيني)',
        'scope.view.team'         => 'عرض نطاق التيم',
        'scope.view.self'         => 'عرض بياناتي فقط',
    ],
];
# تبويبات العرض
$sections = [
    'الرئيسية'          => $mainSection,
    'الإعدادات الشاملة' => $adminSettingsPermissions,
    'المحاسبة المالية'  => $financePermissions,
    'عملاء المحتملين'   => $adminleadsPermissions,
            'المهام والمشروعات' => $workPermissions,

    'نقاط البيع'        => $adminsalesPermissions,
    'المشتريات'         => $adminpurchasePermissions,
        'المخزون'         => $adminstockPermissions,
        'الموارد البشرية'         => $adminhrPermissions,
                'التقارير'         => $adminreportsPermissions,
    'رؤية البيانات'     => $visibilityPermissions,



];


# slugify بسيط
$slugify = function ($text) {
    $text = trim((string) $text);
    $text = preg_replace('/[^\p{L}\p{N}\s-]+/u', '', $text);
    $text = preg_replace('/[\s_]+/u', '-', $text);
    return mb_strtolower($text);
};
@endphp


{{-- مودال: إضافة دور --}}
<div class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <form action="{{ route('admin.role.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">إضافة دور جديد</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="إغلاق">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label>اسم الدور</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    {{-- Tabs --}}
                    <ul class="nav nav-tabs nav-justified mb-3" role="tablist">
                        @foreach($sections as $sectionName => $categories)
                            @php $sectionSlug = $slugify($sectionName); @endphp
                            <li class="nav-item">
                                <a class="nav-link {{ $loop->first ? 'active' : '' }}" id="add-tab-{{ $sectionSlug }}" data-toggle="tab" href="#add-pane-{{ $sectionSlug }}" role="tab" aria-controls="add-pane-{{ $sectionSlug }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                    {{ $sectionName }}
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    <div class="tab-content">
                        @php $storedPermissions = []; @endphp
                        @foreach($sections as $sectionName => $categories)
                            @php $sectionSlug = $slugify($sectionName); @endphp
                            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }} {{ $loop->first ? 'active' : '' }}" id="add-pane-{{ $sectionSlug }}" role="tabpanel" aria-labelledby="add-tab-{{ $sectionSlug }}">
                                <div class="perm-card" data-section="{{ $sectionSlug }}">
                                    <div class="card-head">
                                        <div>
                                            <div class="fw-bold">{{ $sectionName }}</div>
                                            <div class="text-muted small">تحكم بصلاحيات هذا القسم</div>
                                        </div>
                                        <label class="small mb-0">
                                            <input type="checkbox" class="check-all-section" data-section="{{ $sectionSlug }}">
                                            تحديد الكل في القسم
                                        </label>
                                    </div>

                                    <div class="perm-scroll">
                                        <table class="perm-table table table-sm mb-0">
                                            <thead>
                                                <tr>
                                                    <th style="width: 260px;">المجموعة</th>
                                                    <th>الصلاحيات</th>
                                                    <th style="width: 160px;">تحديد الكل</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($categories as $category => $perms)
                                                @php
                                                    $catSlug = $slugify($category);
                                                    $catKeys = array_keys($perms);
                                                    $catAllChecked = count(array_intersect($catKeys, $storedPermissions)) === count($catKeys);
                                                @endphp
                                                <tr class="perm-row" data-section="{{ $sectionSlug }}">
                                                    <td class="fw-bold align-middle">{{ $category }}</td>
                                                    <td>
                                                        <div class="perm-badges">
                                                            @foreach($perms as $key => $label)
                                                                <label class="perm-badge mb-0">
                                                                    <input type="checkbox"
                                                                           name="permissions[]"
                                                                           value="{{ $key }}"
                                                                           class="perm perm-{{ $catSlug }} section-{{ $sectionSlug }}">
                                                                    <span>{{ $label }}</span>
                                                                </label>
                                                            @endforeach
                                                        </div>
                                                    </td>
                                                    <td class="align-middle">
                                                        <label class="small mb-0">
                                                            <input type="checkbox" class="check-all-category" data-category="{{ $catSlug }}" {{ $catAllChecked ? 'checked' : '' }}>
                                                            الكل
                                                        </label>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">إضافة</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- مودال: تعديل دور --}}
@foreach($roles as $role)
<div class="modal fade" id="editRoleModal{{ $role->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <form action="{{ route('admin.role.update', $role->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title">تعديل الدور</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="إغلاق">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label>اسم الدور</label>
                        <input type="text" name="name" class="form-control" value="{{ $role->name }}" required>
                    </div>

                    {{-- Tabs --}}
                    <ul class="nav nav-tabs nav-justified mb-3" role="tablist">
                        @foreach($sections as $sectionName => $categories)
                            @php $sectionSlug = $slugify($sectionName); @endphp
                            <li class="nav-item">
                                <a class="nav-link {{ $loop->first ? 'active' : '' }}" id="edit-{{ $role->id }}-tab-{{ $sectionSlug }}" data-toggle="tab" href="#edit-{{ $role->id }}-pane-{{ $sectionSlug }}" role="tab" aria-controls="edit-{{ $role->id }}-pane-{{ $sectionSlug }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                    {{ $sectionName }}
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    @php $storedPermissions = json_decode($role->data, true) ?? []; @endphp
                    <div class="tab-content">
                        @foreach($sections as $sectionName => $categories)
                            @php $sectionSlug = $slugify($sectionName); @endphp
                            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }} {{ $loop->first ? 'active' : '' }}" id="edit-{{ $role->id }}-pane-{{ $sectionSlug }}" role="tabpanel" aria-labelledby="edit-{{ $role->id }}-tab-{{ $sectionSlug }}">
                                <div class="perm-card" data-section="{{ $sectionSlug }}">
                                    <div class="card-head">
                                        <div>
                                            <div class="fw-bold">{{ $sectionName }}</div>
                                            <div class="text-muted small">تحكم بصلاحيات هذا القسم</div>
                                        </div>
                                        <label class="small mb-0">
                                            <input type="checkbox" class="check-all-section" data-section="{{ $sectionSlug }}">
                                            تحديد الكل في القسم
                                        </label>
                                    </div>

                                    <div class="perm-scroll">
                                        <table class="perm-table table table-sm mb-0">
                                            <thead>
                                                <tr>
                                                    <th style="width: 260px;">المجموعة</th>
                                                    <th>الصلاحيات</th>
                                                    <th style="width: 160px;">تحديد الكل</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($categories as $category => $perms)
                                                @php
                                                    $catSlug = $slugify($category);
                                                    $catKeys = array_keys($perms);
                                                    $catAllChecked = count(array_intersect($catKeys, $storedPermissions)) === count($catKeys);
                                                @endphp
                                                <tr class="perm-row" data-section="{{ $sectionSlug }}">
                                                    <td class="fw-bold align-middle">{{ $category }}</td>
                                                    <td>
                                                        <div class="perm-badges">
                                                            @foreach($perms as $key => $label)
                                                                <label class="perm-badge mb-0">
                                                                    <input type="checkbox"
                                                                           name="permissions[]"
                                                                           value="{{ $key }}"
                                                                           class="perm perm-{{ $catSlug }} section-{{ $sectionSlug }}"
                                                                           {{ in_array($key, $storedPermissions) ? 'checked' : '' }}>
                                                                    <span>{{ $label }}</span>
                                                                </label>
                                                            @endforeach
                                                        </div>
                                                    </td>
                                                    <td class="align-middle">
                                                        <label class="small mb-0">
                                                            <input type="checkbox" class="check-all-category" data-category="{{ $catSlug }}" {{ $catAllChecked ? 'checked' : '' }}>
                                                            الكل
                                                        </label>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">تحديث</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endsection

<script>
/* حساب ارتفاع منطقة السكورل ديناميكيًا حتى يظهر باقي الجدول */
(function(){
  function setPermHeight(modalEl){
    var $m = window.jQuery ? jQuery(modalEl) : null;
    if(!$m){ return; }

    var vh       = window.innerHeight || 800;
    var headerH  = $m.find('.modal-header:visible').outerHeight(true) || 0;
    var footerH  = $m.find('.modal-footer:visible').outerHeight(true) || 0;
    var tabsH    = $m.find('.nav-tabs:visible').outerHeight(true) || 0;
    var nameRowH = $m.find('.modal-body .form-group:visible').first().outerHeight(true) || 0;

    // ناخد أول .card-head في التبويب الحالي (لو موجود)
    var activePane = $m.find('.tab-pane.active');
    var cardHeadH  = activePane.find('.perm-card .card-head:visible').first().outerHeight(true) || 0;

    var paddings = 56; // مسافة أمان
    var maxH = vh - (headerH + footerH + tabsH + nameRowH + cardHeadH + paddings);
    if (maxH < 240) maxH = 240; // حد أدنى

    // طبّق الارتفاع كمتحول CSS على كل perm-scroll داخل المودال
    $m.find('.perm-scroll').each(function(){
        this.style.setProperty('--perm-h', maxH + 'px');
    });
  }

  function bind(modal){
    var $m = window.jQuery ? jQuery(modal) : null;
    if(!$m){ return; }

    // حساب أولي عند الفتح
    setPermHeight(modal);

    // عند تغيير التبويب
    $m.on('shown.bs.tab', 'a[data-toggle="tab"]', function(){
      setPermHeight(modal);
    });

    // عند تغيير حجم الشاشة
    var t;
    window.addEventListener('resize', function(){
      clearTimeout(t);
      t = setTimeout(function(){ setPermHeight(modal); }, 100);
    });

    // تنظيف عند إغلاق المودال (اختياري)
    $m.on('hidden.bs.modal', function(){
      window.removeEventListener('resize', setPermHeight);
    });
  }

  // تفعيل على مودال الإضافة والتعديل
  document.addEventListener('DOMContentLoaded', function(){
    if (window.jQuery) {
      jQuery('#addRoleModal').on('shown.bs.modal', function(){ bind(this); setPermHeight(this); });
      jQuery('[id^="editRoleModal"]').on('shown.bs.modal', function(){ bind(this); setPermHeight(this); });
    }
  });
})();
</script>

<script>
/* منطق تحديد الكل/الفئات */
document.addEventListener('DOMContentLoaded', function () {
    function getRoot(node){ return node.closest('.modal-content') || document; }
    function getSectionCheckboxes(sectionSlug, root){ return root.querySelectorAll('.section-' + sectionSlug + '.perm'); }
    function getCategoryCheckboxes(catSlug, root){ return root.querySelectorAll('.perm-' + catSlug + '.perm'); }

    function updateCategoryToggle(catSlug, root){
        const boxes = getCategoryCheckboxes(catSlug, root);
        const toggle = root.querySelector('.check-all-category[data-category="' + catSlug + '"]');
        if (!toggle) return;
        toggle.checked = boxes.length && Array.from(boxes).every(b => b.checked);
    }
    function updateSectionToggle(sectionSlug, root){
        const boxes = getSectionCheckboxes(sectionSlug, root);
        const toggle = root.querySelector('.check-all-section[data-section="' + sectionSlug + '"]');
        if (!toggle) return;
        toggle.checked = boxes.length && Array.from(boxes).every(b => b.checked);
    }

    document.addEventListener('change', function(e){
        const target = e.target;
        const root = getRoot(target);

        if (target.classList.contains('check-all-category')){
            const catSlug = target.getAttribute('data-category');
            getCategoryCheckboxes(catSlug, root).forEach(cb => cb.checked = target.checked);
            const row = target.closest('tr.perm-row');
            const sectionSlug = row ? row.getAttribute('data-section') : null;
            if (sectionSlug) updateSectionToggle(sectionSlug, root);
        }

        if (target.classList.contains('check-all-section')){
            const sectionSlug = target.getAttribute('data-section');
            getSectionCheckboxes(sectionSlug, root).forEach(cb => cb.checked = target.checked);
            root.querySelectorAll('[data-section="' + sectionSlug + '"] .check-all-category')
                .forEach(cat => updateCategoryToggle(cat.getAttribute('data-category'), root));
        }

        if (target.classList.contains('perm')){
            const classes = target.className.split(' ');
            const catClass = classes.find(c => c.startsWith('perm-') && c !== 'perm');
            const secClass = classes.find(c => c.startsWith('section-'));
            if (catClass) updateCategoryToggle(catClass.replace('perm-',''), root);
            if (secClass) updateSectionToggle(secClass.replace('section-',''), root);
        }
    });

    // تهيئة عند التحميل
    document.querySelectorAll('.modal .modal-content').forEach(function(root){
        root.querySelectorAll('.check-all-category').forEach(function(catToggle){
            updateCategoryToggle(catToggle.getAttribute('data-category'), root);
        });
        root.querySelectorAll('.check-all-section').forEach(function(secToggle){
            updateSectionToggle(secToggle.getAttribute('data-section'), root);
        });
    });
});
</script>
