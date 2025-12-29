<?php

namespace App\Notifications;

use App\Models\Lead;
use App\Models\Admin;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class LeadAssigned extends Notification
{
    use Queueable;

    public function __construct(public Lead $lead) {}

    public function via($notifiable): array
    {
        return ['database']; // أو 'mail','broadcast'...
    }

    public function toArray($notifiable): array
    {
        return [
            'type'     => 'lead_assigned',
            'lead_id'  => $this->lead->id,
            'title'    => 'تم إسناد Lead جديد إليك',
            'message'  => "Lead #{$this->lead->id} ({$this->lead->company_name}) تم إسناده لك.",
            'url'      => route('admin.leads.show', $this->lead->id),
        ];
    }
}
