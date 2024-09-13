<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class RoleUser extends BaseModel
{
    public $timestamps = false;
    use HasFactory;
    protected $table = 'role_user';
}
