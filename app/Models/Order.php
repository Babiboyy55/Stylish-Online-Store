<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'fullname', 'email', 'phone', 'address', 'payment_method', 'subtotal', 'shipping', 'total', 'status'
    ];

    // Relationship: Order belongs to a User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship: Order has many OrderItems
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Alias for items (for compatibility)
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
