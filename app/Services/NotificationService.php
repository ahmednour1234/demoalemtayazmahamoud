<?php

namespace App\Services;

use App\Models\Notification;

class NotificationService
{
    public static function push(int $userId, string $type, string $title, ?string $body = null, array $data = []): void
    {
        Notification::create([
            'user_id' => $userId,
            'type'    => $type,
            'title'   => $title,
            'body'    => $body,
            'data'    => $data ?: null,
        ]);
    }
}
