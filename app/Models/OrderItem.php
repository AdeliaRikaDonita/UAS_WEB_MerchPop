<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'photo_card_id', 'store_id', 'item_name', 'price', 'qty', 'subtotal',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'subtotal' => 'decimal:2',
        ];
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function photoCard()
    {
        return $this->belongsTo(PhotoCard::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
