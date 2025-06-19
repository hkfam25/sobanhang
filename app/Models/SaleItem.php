<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    use HasFactory;
    protected $fillable = ['sale_id', 'product_id', 'quantity', 'price_at_sale', 'cost_at_sale'];
    public $timestamps = false; // Thường không cần timestamps cho sale_items

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

        public function getTotalAttribute()
    {
        return $this->quantity * $this->price_at_sale;
    }
}

