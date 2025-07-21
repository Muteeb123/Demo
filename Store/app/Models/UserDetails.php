<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDetails extends Model
{
    //
     protected $table = 'userDetails';
    protected $fillable = [
        'user_id',
        'address',
        'phone_number',
        'city',
        'state',
        'country',
        'postal_code',
    ];
}
