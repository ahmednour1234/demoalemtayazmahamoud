<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class JournalEntry extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'journal_entries';

    protected $fillable = [
        'entry_date',
        'reference',
        'description',
        'created_by',
        'payment_voucher_id'
    ];
        protected $dates = ['deleted_at'];

    public function details()
    {
        return $this->hasMany(JournalEntryDetail::class, 'journal_entry_id');
    }

      public function seller()
    {
        return $this->belongsTo(Seller::class, 'created_by');
    }
    public function branch(){ return $this->belongsTo(\App\Models\Branch::class, 'branch_id'); }

}
