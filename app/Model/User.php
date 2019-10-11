<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
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
    public function isAdmin() {
        return $this->role == 5;
    }

    public function salaries() {
        return $this->hasMany( \App\Salary::class, 'name', 'salary_name' );
    }
}
