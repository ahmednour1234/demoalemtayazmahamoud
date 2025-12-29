<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\SystemLog;

trait WithAdminGate
{
    private function ensurePermissionOrBack(Request $request, string $permissionKey): ?RedirectResponse
    {
        $adminId = Auth::guard('admin')->id();
        $admin = DB::table('admins')->where('id', $adminId)->first();

        if (!$admin) { Toastr::warning('غير مسموح لك! كلم المدير.'); return redirect()->back(); }

        $role = DB::table('roles')->where('id', $admin->role_id)->first();
        if (!$role) { Toastr::warning('غير مسموح لك! كلم المدير.'); return redirect()->back(); }

        $decoded = json_decode($role->data, true);
        if (is_string($decoded)) $decoded = json_decode($decoded, true);
        if (!is_array($decoded) || !in_array($permissionKey, $decoded)) {
            Toastr::warning('غير مسموح لك! كلم المدير.');
            return redirect()->back();
        }

        return null;
    }

    protected function log(string $action, ?string $table, ?int $recordId, array $meta, Request $request): void
    {
        SystemLog::create([
            'actor_admin_id' => auth('admin')->id(),
            'action'         => $action,
            'table_name'     => $table,
            'record_id'      => $recordId,
            'lead_id'        => $meta['lead_id'] ?? null,
            'ip_address'     => $request->ip(),
            'user_agent'     => substr((string)$request->userAgent(), 0, 255),
            'meta'           => $meta,
            'created_at'     => now()->setTimezone('UTC'),
        ]);
    }
}
