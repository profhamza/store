<?php

namespace App\Models;

use App\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;
    protected $table = 'languages';
    protected $fillable = ['id', 'name', 'locale', 'abbr', 'direction', 'active'];
    protected $hidden = ['created_at', 'updated_at'];
    public $timestamps = false;

    /* Start Language Active Accessors and motators */
    public function setActiveAttribute($val)
    {
        $this->attributes['active'] = ($val == "on") ? 1 : 0;
    }
    public function getActive()
    {
        return ($this->active == 1) ? "مفعل" : "غير مفعل";
    }
    /* End Language Active Accessors and motators */

    public function scopeActiveLanguages($query)
    {
        return $query->where("active", 1);
    }
}
