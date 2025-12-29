<?php

namespace App\Exports;

use App\Models\Lead;
use Maatwebsite\Excel\Concerns\{FromQuery, WithHeadings, WithMapping, ShouldAutoSize};

class LeadsExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    protected array $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        $q = Lead::query()->with(['status','source','owner']);

        if (!empty($this->filters['search'])) {
            $q->where(function ($qq) {
                $s = $this->filters['search'];
                $qq->where('company_name','like',"%$s%")
                   ->orWhere('contact_name','like',"%$s%")
                   ->orWhere('email','like',"%$s%")
                   ->orWhere('phone','like',"%$s%");
            });
        }
        if (!empty($this->filters['status_id'])) $q->where('status_id', $this->filters['status_id']);
        if (!empty($this->filters['source_id'])) $q->where('source_id', $this->filters['source_id']);
        if (!empty($this->filters['owner_id']))  $q->where('owner_id',  $this->filters['owner_id']);
        if (isset($this->filters['archived']) && $this->filters['archived'] !== '') {
            $q->where('is_archived', (int)$this->filters['archived']);
        }

        return $q->orderByDesc('id');
    }

    public function headings(): array
    {
        return [
            'ID','Company','Contact','Email','Country Code','Phone','Phone Normalized',
            'WhatsApp','Potential Value','Currency','Rating','Status Code','Source Code','Owner Email',
            'Last Contact At','Next Action At','Notes','Created At'
        ];
    }

    public function map($lead): array
    {
        return [
            $lead->id,
            $lead->company_name,
            $lead->contact_name,
            $lead->email,
            $lead->country_code,
            $lead->phone,
            $lead->phone_normalized ?? ($lead->country_code.' '.preg_replace('/\D+/','',$lead->phone)),
            $lead->whatsapp,
            $lead->potential_value,
            $lead->currency,
            $lead->rating,
            optional($lead->status)->code,
            optional($lead->source)->code,
            optional($lead->owner)->email,
            optional($lead->last_contact_at)?->toDateTimeString(),
            optional($lead->next_action_at)?->toDateTimeString(),
            $lead->pipeline_notes,
            optional($lead->created_at)?->toDateTimeString(),
        ];
    }
}
