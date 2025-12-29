<?php

namespace App\Imports;

use App\Models\{Lead, LeadSource, LeadStatus, Admin};
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\{
    ToModel, WithHeadingRow, WithValidation, SkipsOnFailure, SkipsFailures
};

class LeadsImportRR implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use SkipsFailures;

    protected ?int $defaultOwnerId;
    protected ?int $createdByAdminId;
    protected array $statusCache = [];
    protected array $sourceCache = [];
    protected array $eligibleAdminIds = [];
    protected int $rrIndex = 0;

    public function __construct(?int $defaultOwnerId, ?int $createdByAdminId, array $eligibleAdminIds = [])
    {
        $this->defaultOwnerId    = $defaultOwnerId;
        $this->createdByAdminId  = $createdByAdminId;
        $this->eligibleAdminIds  = array_values(array_unique(array_filter($eligibleAdminIds)));
        if (empty($this->eligibleAdminIds)) {
            // fallback: كل المدراء النشطين
            $this->eligibleAdminIds = Admin::query()->where('is_active',1)->orderBy('id')->pluck('id')->all();
        }
    }

    public function model(array $row)
    {
        // الأعمدة المتوقعة مثل القالب
        $statusId = $this->resolveStatusId($row['status_code'] ?? null);
        $sourceId = $this->resolveSourceId($row['source_code'] ?? null);

        $country = trim((string)($row['country_code'] ?? ''));
        $phone   = trim((string)($row['phone'] ?? ''));
        if (!$country || !$phone) return null;

        $norm    = $this->normalizePhone($country, $phone);

        // محاولة دمج lead موجود بنفس الهاتف الموحد
        $lead = Lead::query()->whereRaw("phone_normalized = ?", [$norm])->first();

        // تحديد المالك:
        $ownerId = $this->resolveOwnerId($row['owner_email'] ?? null, $row['owner_id'] ?? null)
            ?? $this->defaultOwnerId
            ?? $this->nextRoundRobinOwnerId();

        $data = [
            'owner_id'            => $ownerId,
            'created_by_admin_id' => $this->createdByAdminId,
            'status_id'           => $statusId,
            'source_id'           => $sourceId,

            'company_name'        => $row['company'] ?? null,
            'contact_name'        => $row['contact'] ?? null,
            'email'               => $row['email'] ?? null,
            'country_code'        => $country,
            'phone'               => $phone,
            'whatsapp'            => $row['whatsapp'] ?? null,

            'potential_value'     => $row['potential_value'] ?? null,
            'currency'            => $row['currency'] ?? null,
            'rating'              => $row['rating'] ?? null,
            'pipeline_notes'      => $row['notes'] ?? null,
            'last_contact_at'     => $this->parseDate($row['last_contact_at'] ?? null),
            'next_action_at'      => $this->parseDate($row['next_action_at'] ?? null),
        ];

        if ($lead) {
            $lead->fill($data);
            // احفظ phone_normalized لو العمود موجود
            if ($this->hasPhoneNormalizedColumn()) $lead->phone_normalized = $norm;
            $lead->save();
            return null;
        }

        $new = new Lead($data);
        if ($this->hasPhoneNormalizedColumn()) $new->phone_normalized = $norm;
        return $new;
    }

    public function rules(): array
    {
        return [
            '*.country_code' => ['required'],
            '*.phone'        => ['required'],
            '*.email'        => ['nullable','email'],
            '*.rating'       => ['nullable','integer','between:1,5'],
            '*.currency'     => ['nullable','string','size:3'],
        ];
    }

    protected function resolveStatusId(?string $code): ?int
    {
        $code = $code ? Str::lower(trim($code)) : null;
        if (!$code) return null;
        if (isset($this->statusCache[$code])) return $this->statusCache[$code];
        return $this->statusCache[$code] = LeadStatus::where('code',$code)->value('id');
    }

    protected function resolveSourceId(?string $code): ?int
    {
        $code = $code ? Str::lower(trim($code)) : null;
        if (!$code) return null;
        if (isset($this->sourceCache[$code])) return $this->sourceCache[$code];
        return $this->sourceCache[$code] = LeadSource::where('code',$code)->value('id');
    }

    protected function resolveOwnerId(?string $email, $ownerId): ?int
    {
        if ($ownerId) return (int)$ownerId;
        if ($email)   return Admin::where('email',$email)->value('id');
        return null;
    }

    protected function nextRoundRobinOwnerId(): ?int
    {
        if (empty($this->eligibleAdminIds)) return null;
        $id = $this->eligibleAdminIds[$this->rrIndex % count($this->eligibleAdminIds)];
        $this->rrIndex++;
        return $id;
    }

    protected function normalizePhone(string $cc, string $ph): string
    {
        $ph = preg_replace('/\D+/', '', $ph) ?: '';
        return trim($cc . ' ' . $ph);
    }

    protected function parseDate(?string $v): ?string
    {
        if (!$v) return null;
        try { return date('Y-m-d H:i:s', strtotime($v)); } catch (\Throwable $e) { return null; }
    }

    protected function hasPhoneNormalizedColumn(): bool
    {
        static $has = null;
        if ($has === null) $has = \Illuminate\Support\Facades\Schema::hasColumn('leads','phone_normalized');
        return $has;
    }
}
