<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    // Nama tabel jika berbeda dari nama model
    protected $table = 'transactions';

    // Kolom yang dapat diisi menggunakan mass assignment
    protected $fillable = ['user_id', 'product_id', 'price', 'total_price', 'status', 'snap_token'];

    /**
     * Relasi ke model User.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke model Product.
     * Asumsikan bahwa `product_id` adalah foreign key untuk tabel `products`.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
