<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class AdminPermissionService
{
    /**
     * يرجّع هل الأدمن الحالي عنده permission معينة داخل role->data (JSON).
     */
    public function adminHasPermission(int $adminId, string $permissionKey): bool
    {
        $admin = DB::table('admins')->where('id', $adminId)->first();
        if (! $admin) {
            return false;
        }

        $role = DB::table('roles')->where('id', $admin->role_id)->first();
        if (! $role) {
            return false;
        }

        $decoded = $this->decodeRoleData($role->data);

        if (! is_array($decoded)) {
            return false;
        }

        return in_array($permissionKey, $decoded, true);
    }

    /**
     * يفك JSON سواء كان مرة أو متداخل (string داخل JSON).
     */
    private function decodeRoleData($data)
    {
        if ($data === null) return null;

        $decoded = json_decode($data, true);

        // أحياناً بيتخزن JSON كنص داخل JSON
        if (is_string($decoded)) {
            $decoded = json_decode($decoded, true);
        }

        return $decoded;
    }
}
