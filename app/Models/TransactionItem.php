<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'transaction_id',
        'product_id',
        'product_name',
        'category',
        'price',
        'quantity',
        'subtotal',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer',
        'subtotal' => 'decimal:2',
    ];

    // Relationship ke transaction
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    // Relationship ke product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
