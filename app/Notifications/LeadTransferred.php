<?php

namespace App\Notifications;

use App\Models\Lead;
use App\Models\Admin;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class LeadTransferred extends Notification
{
    use Queueable;

    public function __construct(
        public Lead $lead,
        public ?Admin $oldOwner = null,
        public ?Admin $newOwner = null
    ) {}

    public function via($notifiable): array
    {
        return ['database']; // أو 'mail','broadcast'...
    }

    public function toArray($notifiable): array
    {
        return [
            'type'     => 'lead_transferred',
            'lead_id'  => $this->lead->id,
            'title'    => 'تم نقل Lead من عهدتك',
            'message'  => "Lead #{$this->lead->id} نُقل من {$this->oldOwner?->email} إلى {$this->newOwner?->email}.",
            'url'      => route('admin.leads.show', $this->lead->id),
        ];
    }
}
