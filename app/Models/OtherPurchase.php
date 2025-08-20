<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OtherPurchase extends Model
{
    use HasFactory, SoftDeletes;
    protected $connection = 'tenant';
    protected $table = 'other_purchase';

    protected $fillable = [
        'date',
        'supplier_id',
        'note',
        'sub_total',
        'vat',
        'vat_amount',
        'discount',
        'total',
        'payment_status',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public function supplier()
    {
        return $this->hasOne(Supplier::class, 'id', 'supplier_id');
    }
    public function items()
    {
        return $this->hasMany(PurchaseItem::class, 'purchase_id');
    }

    // public function payments() {
    //     return $this->hasMany(PurchasePayment::class, 'purchase_id', 'id');
    // }
    public function payments()
    {
        return $this->hasMany(InventoryPurchasePayment::class, 'purchase_id', 'id');
    }

    public function paymentSum()
    {

        return $this->payments()->sum('amount');
    }

    public function calculateDueAmount()
    {

        return $this->total - $this->payments()->sum('amount');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    // public function purchaseItems()
    // {
    //     return $this->hasMany(PurchaseItem::class);
    // }
}
