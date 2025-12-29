<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\CurrentOrder;
use App\Models\Coupon;
use App\Models\Transection;
use App\Models\Account;
use App\Models\OrderDetail;
use App\Models\Customer;
use App\Models\HistoryInstallment;
use App\Models\ReserveProduct;
use App\Models\CurrentReserveProduct;
use App\Models\ReserveProductNotification;
use App\Models\StockOrder;
use App\Models\Seller;
use App\Models\Stock;
use App\Models\Branch;
use App\Models\SellerPrice;
use App\Models\Region;
use App\Models\CustomerPrice;
use App\Models\AdminSeller;
use App\Models\Transaction;
use App\Models\TransactionSeller;
use Illuminate\Support\Facades\Auth;
use App\CPU\Helpers;
use Brian2694\Toastr\Facades\Toastr;
use function App\CPU\translate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class NotificationController extends Controller
{
    public function __construct(
        private Category $category,
        private Product $product,
        private Order $order,
        private Coupon $coupon,
        private Transection $transection,
        private TransactionSeller $TransactionSeller,
        private Region $regions,
        private Account $account,
        private OrderDetail $order_details,
        private StockOrder $stock_order,
        private Customer $customer,
        private CurrentReserveProduct $current_reserve_products,
        private HistoryInstallment $installment,
        private ReserveProduct $reserveProduct,
        private ReserveProductNotification $reserveProductNotification,
    ){}
public function listItems(Request $request)
{
       $adminId = Auth::guard('admin')->id();
    $admin = DB::table('admins')->where('id', $adminId)->first();

    if (!$admin) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }

    $roleId = $admin->role_id;
    $role = DB::table('roles')->where('id', $roleId)->first();

    if (!$role) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }

    $decodedData = json_decode($role->data, true);
    if (is_string($decodedData)) {
        $decodedData = json_decode($decodedData, true);
    }

    if (!is_array($decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }

    if (!in_array("notification.index", $decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }   
    $adminId = Auth::guard('admin')->id();
    $sellerId = AdminSeller::where('admin_id', $adminId)->pluck('seller_id');

    // Fetch all notification-related records
    $refundOrders = $this->order
        ->where('notification', 1)
        ->where('type', 7)
        ->get()
        ->map(function ($order) {
            $order->notification_type = 'refundOrder';
            return $order;
        });

    $orders = $this->order
        ->where('notification', 1)
        ->where('type', 4)
        ->get()
        ->map(function ($order) {
            $order->notification_type = 'order';
            return $order;
        });

    $installments = $this->installment
        ->where('notification', 1)
        ->get()
        ->map(function ($installment) {
            $installment->notification_type = 'installment';
            return $installment;
        });

    $transactionSellers = $this->TransactionSeller
        ->get()
        ->map(function ($transaction) {
            $transaction->notification_type = 'transaction';
            return $transaction;
        });

    $reserveProducts = $this->reserveProduct
        ->where('notification', 1)
        ->where('type', 4)
        ->whereIn('seller_id', $sellerId)
        ->get()
        ->map(function ($reserveProduct) {
            $reserveProduct->notification_type = 'reserveProduct';
            return $reserveProduct;
        });

    $reReserveProducts = $this->reserveProduct
        ->where('notification', 1)
        ->where('type', 7)
        ->whereIn('seller_id', $sellerId)
        ->get()
        ->map(function ($reReserveProduct) {
            $reReserveProduct->notification_type = 'reReserveProduct';
            return $reReserveProduct;
        });

    // Merge all collections
    $mergedNotifications = collect()
        ->merge($orders)
        ->merge($refundOrders)
        ->merge($installments)
        ->merge($transactionSellers)
        ->merge($reserveProducts)
        ->merge($reReserveProducts);

    // Sort the merged notifications by creation date
    $sortedNotifications = $mergedNotifications->sortByDesc('created_at');

    // Paginate manually
    $currentPage = request()->get('page', 1);
    $perPage = Helpers::pagination_limit();
    $paginatedNotifications = new \Illuminate\Pagination\LengthAwarePaginator(
        $sortedNotifications->forPage($currentPage, $perPage),
        $sortedNotifications->count(),
        $perPage,
        $currentPage,
        ['path' => request()->url()]
    );

    return view('admin-views.Notification.index', compact('paginatedNotifications'));
}


public function markAsRead($id, $type): RedirectResponse
{
    if ($type === 'order') {
        $notification = $this->order->where('id', $id)->first();
    } elseif ($type === 'installment') {
        $notification = $this->installment->where('id', $id)->first();
    } elseif ($type === 'reserveProduct') {
        $notification = $this->reserveProduct->where('id', $id)->first();
    }else{
            return redirect()->route('admin.admin.notifications.show', ['id' => $id, 'type' => $type]);

    }

    // Update the notification column to 0
// Update the notification column to 0 without mass assignment
if ($notification && $notification->notification == 1) {
    $notification->notification = 0;
    $notification->save();
}

    // Redirect to the item detail page
    return redirect()->route('admin.admin.notifications.show', ['id' => $id, 'type' => $type]);
}
public function showItemById($id, $type)
{
    // Mark the notification as read
    $this->markAsRead($id, $type);

    // Initialize variables
    $notification = null;
    $search = request('search', '');
    $fromDate = request('from_date', '');
    $toDate = request('to_date', '');
    $regions = $this->regions->get();
    $regionId = 1;
$sellers=Seller::get();
$customers=Customer::get();
$branches=Branch::get();

$seller_id='';
$customer_id='';
$branch_id='';

    // Determine the type and fetch the corresponding data
    switch ($type) {
        case 'order':
            $notification = $this->order->with(['customer', 'seller'])->find($id);
$orderAmountSum=0;
$collectedCashSum=0;
$productCount=0;
$quantitySum=0;
   $adminId = Auth::guard('admin')->id();
    $admin = DB::table('admins')->where('id', $adminId)->first();

    if (!$admin) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }

    $roleId = $admin->role_id;
    $role = DB::table('roles')->where('id', $roleId)->first();

    if (!$role) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }

    $decodedData = json_decode($role->data, true);
    if (is_string($decodedData)) {
        $decodedData = json_decode($decodedData, true);
    }

    if (!is_array($decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }

    if (!in_array("notification4.index", $decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }   
            if ($notification) {
                $orders = Order::where('id', $id)
                    ->when($fromDate && $toDate, fn($query) => $query->whereBetween('created_at', [$fromDate, $toDate]))
                    ->paginate(Helpers::pagination_limit())
                    ->appends(compact('search', 'fromDate', 'toDate'));

                return view('admin-views.pos.order.list', compact('orders', 'search', 'fromDate', 'toDate', 'regions', 'regionId','orderAmountSum','collectedCashSum','productCount','quantitySum','type','sellers','seller_id','customers','customer_id','branches','branch_id'));
            }
            break;
   case 'refundOrder':
            $notification = $this->order->with(['customer', 'seller'])->find($id);
$orderAmountSum=0;
$collectedCashSum=0;
$productCount=0;
$quantitySum=0;
   $adminId = Auth::guard('admin')->id();
    $admin = DB::table('admins')->where('id', $adminId)->first();

    if (!$admin) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }

    $roleId = $admin->role_id;
    $role = DB::table('roles')->where('id', $roleId)->first();

    if (!$role) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }

    $decodedData = json_decode($role->data, true);
    if (is_string($decodedData)) {
        $decodedData = json_decode($decodedData, true);
    }

    if (!is_array($decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }

    if (!in_array("notification7.index", $decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }   
            if ($notification) {
                $orders = Order::where('id', $id)
                    ->when($fromDate && $toDate, fn($query) => $query->whereBetween('created_at', [$fromDate, $toDate]))
                    ->paginate(Helpers::pagination_limit())
                    ->appends(compact('search', 'fromDate', 'toDate'));

                return view('admin-views.pos.order.list', compact('orders', 'search', 'fromDate', 'toDate', 'regions', 'regionId','orderAmountSum','collectedCashSum','productCount','quantitySum','type','sellers','seller_id','customers','customer_id','branches','branch_id'));
            }
        case 'installment':
            $notification = $this->installment->with(['customer', 'seller'])->find($id);
$totalAmount=0;
   $adminId = Auth::guard('admin')->id();
    $admin = DB::table('admins')->where('id', $adminId)->first();

    if (!$admin) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }

    $roleId = $admin->role_id;
    $role = DB::table('roles')->where('id', $roleId)->first();

    if (!$role) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }

    $decodedData = json_decode($role->data, true);
    if (is_string($decodedData)) {
        $decodedData = json_decode($decodedData, true);
    }

    if (!is_array($decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }

    if (!in_array("notification13.index", $decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }   

            if ($notification) {
                $installments = HistoryInstallment::where('id', $id)
                    ->when($fromDate && $toDate, fn($query) => $query->whereBetween('created_at', [$fromDate, $toDate]))
                    ->paginate(Helpers::pagination_limit())
                    ->appends(compact('search', 'fromDate', 'toDate'));

                return view('admin-views.pos.installment.list', compact('installments', 'search', 'fromDate', 'toDate', 'regions', 'regionId','totalAmount','sellers','seller_id','customers','customer_id','branches','branch_id'));
            }
            break;

        case 'reserveProduct':
               $adminId = Auth::guard('admin')->id();
    $admin = DB::table('admins')->where('id', $adminId)->first();

    if (!$admin) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }

    $roleId = $admin->role_id;
    $role = DB::table('roles')->where('id', $roleId)->first();

    if (!$role) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }

    $decodedData = json_decode($role->data, true);
    if (is_string($decodedData)) {
        $decodedData = json_decode($decodedData, true);
    }

    if (!is_array($decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }

    if (!in_array("notification41.index", $decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }   
            $notification = $this->reserveProduct->with(['customer', 'seller'])->find($id);

            if ($notification) {
                $reservations = ReserveProduct::where('id', $id)
                    ->when($fromDate && $toDate, fn($query) => $query->whereBetween('created_at', [$fromDate, $toDate]))
                    ->paginate(Helpers::pagination_limit())
                    ->appends(compact('search', 'fromDate', 'toDate'));

                return view('admin-views.pos.reservations.list_notification', compact('reservations', 'search', 'fromDate', 'toDate', 'regions', 'regionId','type','sellers','seller_id','customers','customer_id','branches','branch_id'));
            }
            break;

        case 'transaction':
               $adminId = Auth::guard('admin')->id();
    $admin = DB::table('admins')->where('id', $adminId)->first();

    if (!$admin) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }

    $roleId = $admin->role_id;
    $role = DB::table('roles')->where('id', $roleId)->first();

    if (!$role) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }

    $decodedData = json_decode($role->data, true);
    if (is_string($decodedData)) {
        $decodedData = json_decode($decodedData, true);
    }

    if (!is_array($decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }

    if (!in_array("notification500.index", $decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }   
            $notification = $this->TransactionSeller->find($id);
$sellers=Seller::all();
            if ($notification) {
                $transactions = TransactionSeller::where('id', $id)
                    ->when($fromDate && $toDate, fn($query) => $query->whereBetween('created_at', [$fromDate, $toDate]))
                    ->paginate(Helpers::pagination_limit())
                    ->appends(compact('search', 'fromDate', 'toDate'));

                return view('admin-views.transaction_sellers.index', compact('transactions', 'search', 'fromDate', 'toDate', 'regions', 'regionId','sellers','branches','branch_id'));
            }
            break;
    }

    // Handle case when notification is not found
    Toastr::error(translate('Notification not found'));
    return redirect()->back();
}
}