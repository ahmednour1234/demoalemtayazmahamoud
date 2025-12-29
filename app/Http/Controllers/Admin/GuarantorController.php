<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guarantor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Brian2694\Toastr\Facades\Toastr;
use function App\CPU\translate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class GuarantorController extends Controller
{
    /**
     * Display a listing of guarantors.
     */
    public function index()
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

    if (!in_array("guarantors.index", $decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }  
        $guarantors = Guarantor::paginate(15);
        return View::make('admin-views.guarantors.index', compact('guarantors'));
    }

    /**
     * Show the form for creating a new guarantor.
     */
    public function create()
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

    if (!in_array("guarantors.store", $decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
                return redirect()->back();

    }
        return View::make('admin-views.guarantors.create');
    }

    /**
     * Store a newly created guarantor in storage.
     */
    public function store(Request $request)
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

    if (!in_array("guarantors.store", $decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
                return redirect()->back();

    }
        $validated = $request->validate([
            'name'              => 'required|string|max:255',
            'national_id'       => 'required|string|max:50|unique:guarantors,national_id',
            'phone'             => 'required|string|max:20',
            'address'           => 'nullable|string|max:255',
            'job'               => 'nullable|string|max:100',
            'monthly_income'    => 'nullable|numeric|min:0',
            'relation'          => 'nullable|string|max:50',
            'images.*'          => 'nullable|image|max:2048',
        ]);

        $paths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $paths[] = $file->store('uploads/guarantors', 'public');
            }
        }

        $guarantor = Guarantor::create(array_merge($validated, ['images' => json_encode($paths)]));

        Toastr::success(__('إضافة ضامن بنجاح'));
        return Redirect::route('admin.guarantors.index');
    }

    /**
     * Display the specified guarantor.
     */
    public function show($id)
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

    if (!in_array("guarantors.index", $decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
    }
        $guarantor = Guarantor::findOrFail($id);
        return View::make('admin-views.guarantors.show', compact('guarantor'));
    }

    /**
     * Show the form for editing the specified guarantor.
     */
    public function edit($id)
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

    if (!in_array("guarantors.update", $decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
    }
        $guarantor = Guarantor::findOrFail($id);
        return View::make('admin-views.guarantors.edit', compact('guarantor'));
    }

    /**
     * Update the specified guarantor in storage.
     */
    public function update(Request $request, $id)
    {
        $guarantor = Guarantor::findOrFail($id);
        $validated = $request->validate([
            'name'              => 'required|string|max:255',
            'national_id'       => 'required|string|max:50|unique:guarantors,national_id,' . $guarantor->id,
            'phone'             => 'required|string|max:20',
            'address'           => 'nullable|string|max:255',
            'job'               => 'nullable|string|max:100',
            'monthly_income'    => 'nullable|numeric|min:0',
            'relation'          => 'nullable|string|max:50',
            'images.*'          => 'nullable|image|max:2048',
        ]);

        $paths = json_decode($guarantor->images ?? '[]', true);
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $paths[] = $file->store('uploads/guarantors', 'public');
            }
        }

        $guarantor->update(array_merge($validated, ['images' => json_encode($paths)]));

        Toastr::success(__('Guarantor updated successfully'));
        return Redirect::route('admin.guarantors.index');
    }

    /**
     * Remove the specified guarantor from storage.
     */
    public function destroy($id)
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

    if (!in_array("guarantors.destroy", $decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
                return redirect()->back();

    }
        $guarantor = Guarantor::findOrFail($id);
        $guarantor->delete();

        Toastr::success(__('Guarantor deleted successfully'));
        return Redirect::route('admin.guarantors.index');
    }
}
