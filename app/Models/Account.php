<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'accounts';

    protected $fillable = [
        'code',
        'account_type', // asset/liability/equity/revenue/expense/other
        'parent_id',
    ];

    protected $casts = [
        'parent_id' => 'integer',
    ];

    /**
     * توليد كود حساب جديد.
     * - الجذور (بدون parent_id): تَستخدم رقم النوع + رقم واحد (11..19) كجذر فعلي، ونسمح بعدة جذور لكل نوع.
     * - الأبناء:
     *   - حتى "المستوى المنطقي" 4: نضيف رقمًا واحدًا.
     *   - من المستوى المنطقي 5+: نضيف أربع خانات تبدأ من 0001.
     *
     * المستوى "المنطقي" = مستوى الأسلاف الحقيقي + 1 (للحساب الجديد) + 1 (تعويضًا عن المستوى الافتراضي للنوع).
     */
    public static function generateAccountCode(?string $accountType = null, ?int $parentId = null): string
    {
        $prefixes = [
            'asset'     => '1',
            'liability' => '2',
            'equity'    => '3',
            'revenue'   => '4',
            'expense'   => '5',
            'other'     => '6',
        ];

        // ===== حالة إنشاء "جذر حقيقي" (بدون أب) =====
        if (is_null($parentId)) {
            if (!isset($prefixes[$accountType])) {
                throw new \Exception("Invalid account type.");
            }
            $pref = $prefixes[$accountType];

            // الجذور الحقيقية لنوع معيّن تكون بطول 2: مثل 11, 12 ... 19
            $lastRoot = self::query()
                ->whereNull('parent_id')
                ->where('account_type', $accountType)
                ->whereRaw('CHAR_LENGTH(code) = 2')
                ->where('code', 'LIKE', $pref . '%')
                ->orderBy('code', 'desc')
                ->first();

            $lastDigit = $lastRoot ? (int) mb_substr($lastRoot->code, -1) : 0;

            if ($lastDigit >= 9) {
                throw new \Exception("Reached maximum of 9 top-level roots for type '{$accountType}'.");
            }

            $counter = $lastDigit + 1; // 1..9
            return $pref . $counter;   // مثال: 11 أول جذر للأصول
        }

        // ===== حالة إنشاء ابن =====
        $parent = self::find($parentId);
        if (!$parent) {
            throw new \Exception("Parent account not found.");
        }

        $parentLevelReal = self::computeLevel($parent); // الجذر الحقيقي = 1
        $newLevelLogical = ($parentLevelReal + 1) + 1;  // +1 للحساب الجديد، +1 لمستوى النوع الافتراضي

        $parentLen = mb_strlen($parent->code);

        // حتى المستوى المنطقي 4 → لاحقة رقم واحد
        if ($newLevelLogical <= 4) {
            $lastSibling = self::query()
                ->where('parent_id', $parent->id)
                ->whereRaw('CHAR_LENGTH(code) = ?', [$parentLen + 1])
                ->where('code', 'LIKE', $parent->code . '%')
                ->orderBy('code', 'desc')
                ->first();

            $lastDigit = $lastSibling ? (int) mb_substr($lastSibling->code, -1) : 0;

            if ($lastDigit >= 9) {
                throw new \Exception("Maximum of 9 children (one-digit) reached under parent {$parent->code} for logical levels ≤ 4.");
            }

            $counter = $lastDigit + 1;
            return $parent->code . $counter; // مثال: 1112
        }

        // من المستوى المنطقي 5 فما فوق → لاحقة 4 أرقام
        $lastSibling4 = self::query()
            ->where('parent_id', $parent->id)
            ->whereRaw('CHAR_LENGTH(code) = ?', [$parentLen + 4])
            ->where('code', 'LIKE', $parent->code . '%')
            ->orderBy('code', 'desc')
            ->first();

        $lastNum = $lastSibling4 ? (int) mb_substr($lastSibling4->code, -4) : 0;

        if ($lastNum >= 9999) {
            throw new \Exception("Maximum of 9,999 children reached under parent {$parent->code} for logical levels ≥ 5.");
        }

        $counter = $lastNum + 1;
        return $parent->code . str_pad((string) $counter, 4, '0', STR_PAD_LEFT); // مثال: 11120001
    }

    /**
     * يحسب المستوى الحقيقي بناءً على الأسلاف المخزّنين:
     * - حساب بلا أب = مستوى 1
     */
    public static function computeLevel(Account $account): int
    {
        $level = 1;
        $cur = $account;
        while ($cur->parent_id) {
            $cur = self::find($cur->parent_id);
            if (!$cur) break;
            $level++;
        }
        return $level;
    }

    /* ================= العلاقات الشجرية الصحيحة (Self-Reference) ================= */

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function ancestors()
    {
        $anc = collect();
        $cur = $this->parent;
        while ($cur) {
            $anc->push($cur);
            $cur = $cur->parent;
        }
        return $anc;
    }

    public function isDescendantOf(int $ancestorId): bool
    {
        return $this->ancestors()->pluck('id')->contains($ancestorId);
    }

    /* ================= علاقات أخرى كما هي ================= */

    public function transections()
    {
        return $this->hasMany(Transection::class);
    }

    public function storage()
    {
        return $this->belongsTo(Storage::class, 'storage_id');
    }

    public function expense()
    {
        return $this->hasMany(Expense::class, 'expense_id');
    }

    /* سكوبات مساعدة */

    public function scopeRoots($q)
    {
        return $q->whereNull('parent_id');
    }

    public function scopeOfType($q, string $accountType)
    {
        return $q->where('account_type', $accountType);
    }
}
