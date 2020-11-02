<?php

namespace App\Models;

use App\Observers\MainCatObserver;
use App\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class MainCategory extends Model
{
    use HasFactory;
    protected $table = 'main_categories';
    protected $fillable = ['id', 'name', 'description', 'photo', 'translation', 'translate_of', 'active'];
    protected $hidden = ['created_at', 'updated_at'];
    public $timestamps = false;

    protected static function boot()
    {
        parent::boot();
        self::observe(MainCatObserver::class);
    }

    /* Start Scopes */
    public function scopeLocalLangCats($query)
    {
        $current_lang = getCurrentLocale();
        return $query->where("translation", $current_lang);
    }
    public function scopeActive($query)
    {
        return $query->where("active", 1);
    }
    /* End Scopes */

    /* Start Accessors and Motators */
    public function setActiveAttribute($val)
    {
        $this->attributes['active'] = ($val == "on" || $val == 1) ? 1 : 0;
    }
    public function getPhotoAttribute($val)
    {
        return ($val != null) ? "/assets/admin/images/uploads/maincats/" . $val : "";
    }
    /* End Accessors and Motators */

    /* Start method to modify active main categories */
    public function getActive()
    {
        return ($this->active == 1) ? "مفعل" : "غير مفعل";
    }
    /* End to modify active main categories */

    /* Start Relations */
    public function categories()
    {
        return $this->hasMany(self::class, "translate_of", "id");
    }
    public function vendors()
    {
        return $this->hasMany(Vendor::class, "cat_id", "id");
    }
    /* End Relations */
}
