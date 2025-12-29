<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomFieldRequest;
use App\Models\CustomField;
use Illuminate\Http\Request;
use function App\CPU\translate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;

class CustomFieldController extends Controller
{
    public function index(Request $request)
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

    if (!in_array("custom_fields.index", $decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }   
        $q = CustomField::query()
            ->when($request->filled('search'), function($qq) use ($request){
                $qq->where(function($x) use ($request){
                    $x->where('name','like','%'.$request->search.'%')
                      ->orWhere('key','like','%'.$request->search.'%')
                      ->orWhere('applies_to','like','%'.$request->search.'%');
                });
            })
            ->when($request->filled('applies_to'), fn($qq)=>$qq->where('applies_to',$request->applies_to))
            ->when($request->filled('type'), fn($qq)=>$qq->where('type',$request->type))
            ->when($request->filled('active'), function($qq) use ($request){
                if ($request->active === '1') $qq->where('is_active', true);
                if ($request->active === '0') $qq->where('is_active', false);
            })
            ->orderBy('applies_to')->orderBy('sort_order');

        $fields = $q->paginate(20)->withQueryString();
        $types  = CustomField::types();
        return view('admin-views.custom-fields.index', compact('fields','types'));
    }

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

    if (!in_array("custom_fields.store", $decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }   
        $types = CustomField::types();
        return view('admin-views.custom-fields.create', compact('types'));
    }

    public function store(CustomFieldRequest $request)
    {
        CustomField::create($request->validated());
        return redirect()->route('admin.custom-fields.index')->with('success','تمت إضافة الحقل.');
    }

    public function edit(CustomField $customField)
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

    if (!in_array("custom_fields.update", $decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }   
        $types = CustomField::types();
        return view('admin-views.custom-fields.edit', ['field'=>$customField, 'types'=>$types]);
    }

    public function update(CustomFieldRequest $request, CustomField $customField)
    {
        $customField->update($request->validated());
        return redirect()->route('admin.custom-fields.index')->with('success','تم تحديث الحقل.');
    }

    public function destroy(CustomField $customField)
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

    if (!in_array("custom_fields.update", $decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }   
        $customField->delete();
        return back()->with('success','تم حذف الحقل.');
    }

    public function active(Request $request, CustomField $customField)
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

    if (!in_array("custom_fields.active", $decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }   
        $customField->update(['is_active' => (bool)$request->boolean('active')]);
        return back()->with('success', 'تم تحديث الحالة.');
    }
}
