<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',   'supplier',
        'dashboard',
        'pos',
        'stock',
        'store',
        'cat',
        'unit',
        'product',
        'stock_limit',
        'coupons',
        'customer',
        'seller',
        'admin',
        'setting',
        'storage',
        'requests',
        'notification',
        'tracking',
              'regions',
        'reports',
        'vehicle_stock',
            'department_id',
        'manager_id',
    ];
       public function storage()
    {
        return $this->belongsto(Storage::class);
    }
     public function roles()
  {
    return $this->belongsTo(Role::class,'role_id');
  }
    public function branch()
  {
    return $this->belongsTo(Branch::class,'branch_id');
  }
     public function shift()
  {
    return $this->belongsTo(Shift::class,'shift_id');
  }
   public function detail()
{
    return $this->hasOne(AdminDetail::class);
}
 public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /* المدير المباشر */
    public function manager()
    {
        return $this->belongsTo(self::class, 'manager_id');
    }

    /* المرؤوسون المباشرون */
    public function subordinates()
    {
        return $this->hasMany(self::class, 'manager_id');
    }

    /* سكوبات مفيدة */
    public function scopeInDepartment($q, $departmentId)
    {
        return $q->where('department_id', $departmentId);
    }

    public function scopeManagers($q)
    {
        // مدراء لديهم مرؤوسون
        return $q->whereHas('subordinates');
    }
}
