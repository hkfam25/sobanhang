<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'po_number',
        'supplier_id',
        'user_id',
        'order_date',
        'expected_delivery_date',
        'status',
        'total_amount',
        'notes',
    ];

    protected $casts = [
        'order_date' => 'date',
        'expected_delivery_date' => 'date',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }

    // Hàm tự động tạo mã phiếu nhập (ví dụ)
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($purchaseOrder) {
            if (empty($purchaseOrder->po_number)) {
                // Ví dụ: PO-20231027-0001
                $prefix = 'PO-' . date('Ymd') . '-';
                $latestOrder = self::where('po_number', 'LIKE', $prefix . '%')->orderBy('po_number', 'desc')->first();
                $number = $latestOrder ? (int)substr($latestOrder->po_number, strlen($prefix)) + 1 : 1;
                $purchaseOrder->po_number = $prefix . str_pad($number, 4, '0', STR_PAD_LEFT);
            }
        });
    }
}
