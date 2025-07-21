<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'total_price',
        'status', // e.g., pending, completed
        'ordered_at',
        'completed_at', // Nullable for orders that are not yet completed
        'tracking_number', // Optional tracking number for the order
    ];
}
