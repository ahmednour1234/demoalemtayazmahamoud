<?php

namespace App\Listeners;

use App\Events\ApprovalRequested;
use App\Models\Notification;

class SendApprovalRequestedNotification
{
    public function handle(ApprovalRequested $event): void
    {
        foreach ($event->approverIds as $uid) {
            Notification::create([
                'user_id' => $uid,
                'type'    => 'approval.request',
                'title'   => 'طلب موافقة جديد',
                'body'    => sprintf('طلب موافقة على %s #%d', $event->type, $event->id),
                'data'    => ['type' => $event->type, 'id' => $event->id, 'requested_by' => $event->requestedBy],
            ]);
        }
    }
}
