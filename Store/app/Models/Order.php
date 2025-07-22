<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    use HasFactory;

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


    public function product()
    {
        return $this->belongsTo(Product::class)->withTrashed();
    }

    // Each Order belongs to one User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
