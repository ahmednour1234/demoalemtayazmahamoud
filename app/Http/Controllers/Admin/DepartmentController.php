<?php
// app/Http/Controllers/Admin/DepartmentController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\SystemLog;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Brian2694\Toastr\Facades\Toastr;

class DepartmentController extends Controller
{
  public function index(Request $request)
{
    $q         = $request->query('q');
    $active    = $request->query('active');      // '1' | '0' | null
    $parentId  = $request->query('parent_id');   // رقم | 'root' | 'null' | null

    $departments = Department::query()
        ->when($q, function ($query, $q) {
            $query->where(function ($qq) use ($q) {
                $qq->where('name', 'like', "%{$q}%")
                   ->orWhere('code', 'like', "%{$q}%");
            });
        })
        ->when($active !== null && $active !== '', function ($query) use ($active) {
            $query->where('active', (bool) $active);
        })
        ->when($parentId !== null && $parentId !== '', function ($query) use ($parentId) {
            if ($parentId === 'root' || $parentId === 'null') {
                $query->whereNull('parent_id');       // الأقسام الجذرية فقط
            } else {
                $query->where('parent_id', (int) $parentId); // أبناء قسم محدد
            }
        })
        ->with('parent:id,name')
        ->orderBy('level')
        ->orderBy('name')
        ->paginate(20)
        ->withQueryString();

    return view('admin-views.departments.index', compact('departments', 'q', 'active', 'parentId'));
}

    public function create()
    {
        $parents = Department::orderBy('level')->orderBy('name')->get(['id', 'name', 'level']);
        return view('admin-views.departments.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'      => ['required', 'string', 'max:191'],
            'code'      => ['required', 'string', 'max:64', 'unique:departments,code'],
            'active'    => ['required', 'boolean'],
            'parent_id' => ['nullable', Rule::exists('departments', 'id')],
        ]);

        $dept = Department::create($data);

        // لوج النظام
        $this->log('department.create', 'departments', $dept->id, [
            'name' => $dept->name,
            'code' => $dept->code,
            'active' => $dept->active,
            'parent_id' => $dept->parent_id,
        ], $request);

        Toastr::success('تم إنشاء القسم بنجاح.');
        return redirect()->route('admin.departments.show', $dept->id);
    }

    public function show(Department $department)
    {
        $department->load(['parent:id,name', 'children:id,name,parent_id,active,level']);
        return view('admin-views.departments.show', compact('department'));
    }

    public function edit(Department $department)
    {
        $parents = Department::where('id', '!=', $department->id)
            ->orderBy('level')->orderBy('name')->get(['id','name','level']);

        return view('admin-views.departments.edit', compact('department', 'parents'));
    }

    public function update(Request $request, Department $department)
    {
        $data = $request->validate([
            'name'      => ['required', 'string', 'max:191'],
            'code'      => ['required', 'string', 'max:64', Rule::unique('departments','code')->ignore($department->id)],
            'active'    => ['required', 'boolean'],
            'parent_id' => ['nullable', Rule::exists('departments', 'id')->whereNot('id', $department->id)],
        ]);

        // حماية من جعل القسم أبًا لنفسه أو أحد أحفاده
        if (!empty($data['parent_id'])) {
            $currentPath = $department->path ?? ('/'.$department->id);
            $isDescendant = Department::whereKeyNot($department->id)
                ->where('path', 'like', rtrim($currentPath, '/').'/%')
                ->where('id', $data['parent_id'])
                ->exists();

            if ($isDescendant) {
                Toastr::error('لا يمكن تعيين قسم فرعي كأب لهذا القسم.');
                return back()->withErrors(['parent_id' => 'لا يمكن تعيين قسم فرعي كأب لهذا القسم.'])->withInput();
            }
        }

        $before = $department->only(['name','code','active','parent_id']);
        $department->update($data);
        $after = $department->only(['name','code','active','parent_id']);

        // لوج النظام
        $this->log('department.update', 'departments', $department->id, [
            'before' => $before,
            'after'  => $after,
        ], $request);

        Toastr::success('تم تحديث القسم بنجاح.');
        return redirect()->route('admin.departments.show', $department->id);
    }

    public function destroy(Department $department, Request $request)
    {
        $meta = $department->only(['name','code','active','parent_id']);
        $id   = $department->id;

        $department->delete(); // Soft delete

        // لوج النظام
        $this->log('department.delete', 'departments', $id, $meta, $request);

        Toastr::success('تم حذف القسم.');
        return redirect()->route('admin.departments.index');
    }

    /**
     * تسجيل لوج النظام
     */
    private function log(string $action, ?string $table, ?int $recordId, array $meta, Request $request): void
    {
        SystemLog::create([
            'actor_admin_id' => auth('admin')->id(),
            'action'         => $action,
            'table_name'     => $table,
            'record_id'      => $recordId,
            'lead_id'        => null,
            'ip_address'     => $request->ip(),
            'user_agent'     => substr((string)$request->userAgent(), 0, 255),
            'meta'           => $meta,
            'created_at'     => now()->setTimezone('UTC'),
        ]);
    }
}
