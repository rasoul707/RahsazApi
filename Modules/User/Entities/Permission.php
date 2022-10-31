<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permission extends Model
{
    protected $table = 'permissions';
    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_permission');
    }
}
