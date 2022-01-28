<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{

    protected $fillable = [
        'email',
        'password',
    ];


    protected $hidden = [
        'password',
    ];


    protected $casts = [
        'password' => 'encrypted',
    ];
}
