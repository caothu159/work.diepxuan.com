<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

//use Jenssegers\Mongodb\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',

        'salary_name',
        'role',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'role'              => 'tinyint',
        'username'          => 'string',
        'salary_name'       => 'string',
        'email_verified_at' => 'datetime',
    ];

    /**
     * Check user is admin.
     */
    public function isAdmin()
    {
        // if ($this->role->name == 'Admin' && $this->is_active == 1) {
        //     return true;
        // }
        return $this->role == 5;
    }

    public function role()
    {
        return $this->belongsTo(\App\Role::class);
    }

    public function salaries()
    {
        return $this->hasMany(\App\Salary::class, 'name', 'salary_name');
    }
}
