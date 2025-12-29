<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'account_stock_id',
        'code'
    ];
    public function account_stock()
    {
        return $this->belongsto(Account::class,'account_stock_id');
    }
        public function admins()
    {
        // لو عمود الربط اسمه branch_id في جدول admins
        return $this->hasMany(Admin::class, 'branch_id');
    }

}
