<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetails extends Model
{
    //

    use HasFactory;
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
