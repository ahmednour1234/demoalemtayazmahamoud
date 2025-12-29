<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{LeadNote, Lead, Admin, SystemLog, CustomField};
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use function App\CPU\translate;

class LeadNoteController extends Controller
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

    if (!in_array("lead_notes.index", $decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }   
        $q = LeadNote::query()->with(['lead','admin']);

        if ($s = $request->string('search')->toString()) {
            $q->where(function(Builder $w) use ($s){
                $w->where('note','like',"%{$s}%")
                  ->orWhereHas('lead', fn($qq)=>$qq->where('company_name','like',"%{$s}%")
                                                    ->orWhere('contact_name','like',"%{$s}%")
                                                    ->orWhere('phone','like',"%{$s}%"))
                  ->orWhereHas('admin', fn($qq)=>$qq->where('email','like',"%{$s}%"));
            });
        }
        if ($request->filled('lead_id'))  $q->where('lead_id', (int)$request->lead_id);
        if ($request->filled('admin_id')) $q->where('admin_id',(int)$request->admin_id);
        if ($request->filled('visibility')) $q->where('visibility',$request->visibility);

        $notes = $q->orderByDesc('id')->paginate(20)->withQueryString();

        return view('admin-views.lead_notes.index', [
            'notes'   => $notes,
            'filters' => $request->only(['search','lead_id','admin_id','visibility']),
            'leads'   => Lead::orderByDesc('id')->limit(300)->get(),
            'admins'  => Admin::orderBy('email')->get(),
        ]);
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

    if (!in_array("lead_notes.store", $decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }   
        return view('admin-views.lead_notes.create', [
            'leads'  => Lead::orderByDesc('id')->limit(300)->get(),
            'admins' => Admin::orderBy('email')->get(),
            'visibilities' => ['private'=>'خاص','team'=>'الفريق','public'=>'عام'],
            'defaultAdminId' => auth('admin')->id(),
        ]);
    }

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

    if (!in_array("lead_notes.store", $decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }   
        $data = $this->validatePayload($request);
        $data['admin_id'] = $data['admin_id'] ?? auth('admin')->id();

        DB::transaction(function () use ($data, $request) {
            /** @var LeadNote $note */
            $note = LeadNote::create($data);

            // حفظ الحقول المخصّصة
            if (method_exists($note, 'syncCustomFields')) {
                $note->syncCustomFields($request->input('custom_fields', []));
            }

            $this->log('lead_note.created', 'lead_notes', $note->id, [
                'after' => $note->toArray(),
                'cf'    => $request->input('custom_fields', []),
            ], $request);
        });

        Toastr::success('تم إضافة الملاحظة');
        return redirect()->route('admin.lead-notes.index');
    }

    public function edit(LeadNote $lead_note)
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

    if (!in_array("lead_notes.update", $decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }   
        $lead_note->load(['lead','admin','customFieldValues.customField']);

        return view('admin-views.lead_notes.edit', [
            'note'   => $lead_note,
            'leads'  => Lead::orderByDesc('id')->limit(300)->get(),
            'admins' => Admin::orderBy('email')->get(),
            'visibilities' => ['private'=>'خاص','team'=>'الفريق','public'=>'عام'],
        ]);
    }

    public function update(Request $request, LeadNote $lead_note)
    {
        $data = $this->validatePayload($request);
        $data['admin_id'] = $data['admin_id'] ?? auth('admin')->id();

        $before = $lead_note->replicate()->toArray();

        DB::transaction(function () use ($lead_note, $before, $data, $request) {
            $lead_note->update($data);

            if (method_exists($lead_note, 'syncCustomFields')) {
                $lead_note->syncCustomFields($request->input('custom_fields', []));
            }

            $this->log('lead_note.updated','lead_notes',$lead_note->id,[
                'before'=>$before,
                'after'=>$lead_note->toArray(),
                'changes'=>$lead_note->getChanges(),
                'cf'=>$request->input('custom_fields', []),
            ], $request);
        });

        Toastr::success('تم تحديث الملاحظة');
        return redirect()->route('admin.lead-notes.index');
    }

    public function destroy(Request $request, LeadNote $lead_note)
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

    if (!in_array("lead_notes.destroy", $decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }   
        DB::transaction(function () use ($lead_note, $request) {
            $snapshot = $lead_note->toArray();
            $id = $lead_note->id;
            $lead_note->delete();

            $this->log('lead_note.deleted','lead_notes',$id,[
                'before'=>$snapshot,
            ], $request);
        });

        Toastr::success('تم حذف الملاحظة');
        return back();
    }

    private function validatePayload(Request $request): array
    {
        return $request->validate([
            'lead_id'    => ['required','exists:leads,id'],
            'admin_id'   => ['nullable','exists:admins,id'],
            'note'       => ['required','string'],
            'visibility' => ['required','in:private,team,public'],

            // مجمّع الحقول المخصّصة
            'custom_fields' => ['sometimes','array'],
        ]);
    }

    private function log(string $action, ?string $table, ?int $recordId, array $meta, Request $request): void
    {
        SystemLog::create([
            'actor_admin_id' => auth('admin')->id(),
            'action'         => $action,
            'table_name'     => $table,
            'record_id'      => $recordId,
            'lead_id'        => $meta['after']['lead_id'] ?? null,
            'ip_address'     => $request->ip(),
            'user_agent'     => substr((string)$request->userAgent(), 0, 255),
            'meta'           => $meta,
            'created_at'     => now()->setTimezone('UTC'),
        ]);
    }
}
