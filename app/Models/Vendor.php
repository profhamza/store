<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Vendor extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'vendors';
    protected $fillable = ['id', 'name', 'email', 'phone', 'address', 'password', 'logo', 'active', 'cat_id', 'commented'];
    protected $hidden = ['created_at', 'updated_at'];
    public $timestamps = false;

    /* Start Scopes */
    public function scopeActiveVendors($query)
    {
        return $query->where("active", 1)->where("commented", 0);
    }
    public function scopeSelectVendors($query)
    {
        return $query->select("id", "name", "email", "phone", "password", "logo", "address", "active", "commented", "cat_id");
    }
    /* End Scopes */

    /* Start Accessors and Motators */
    public function getActive()
    {
        return ($this->active == 1) ? "مفعل" : "غير مفعل";
    }
    public function getLogo()
    {
        return ($this->logo != null) ? "/assets/admin/images/uploads/vendors/" . $this->logo : "";
    }
    public function setActiveAttribute($val)
    {
        $this->attributes['active'] = ($val == "on" || $val == 1) ? 1 : 0;
    }
    /* End Accessors and Motators */

    /* Start Relations */
    public function mainCategory()
    {
        return $this->belongsTo(MainCategory::class, "cat_id", "id");
    }
    /* End Relations */
}
