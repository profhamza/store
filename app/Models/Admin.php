<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;
    protected $table = 'admins';
    protected $fillable = ['id', 'name', 'email', 'password', 'photo'];
    protected $hidden = ['created_at', 'updated_at'];
    public $timestamps = false;
}
