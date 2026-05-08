<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_name',
        'customer_phone',
        'customer_address',
        'subtotal',
        'tax',
        'total',
        'payment_method',
         'ewallet_provider',   // <--- tambah ini
        'cash_amount',
        'change',
        'transaction_id',   // <-- tambahkan
        'transaction_date', // <-- tambahkan
        'status' ,           // <-- tambahkan
        'rejection_reason'  // ← pastikan ini ada
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'total' => 'decimal:2',
        'cash_amount' => 'decimal:2',
        'change' => 'decimal:2',
        'transaction_date' => 'datetime',
    ];

    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }

    public static function generateTransactionId()
    {
        return 'TRX-' . strtoupper(substr(uniqid(), -8));
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($transaction) {
            if (empty($transaction->transaction_id)) {
                $transaction->transaction_id = self::generateTransactionId();
            }
            if (empty($transaction->transaction_date)) {
                $transaction->transaction_date = now();
            }
            if (empty($transaction->status)) {
                $transaction->status = 'pending'; // default
            }
        });
    }
}
