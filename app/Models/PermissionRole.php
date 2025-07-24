<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermissionRole extends Model
{
     protected $table = 'role_user_school';
    protected $fillable = ['user_id', 'role_id', 'school_id'];
}
