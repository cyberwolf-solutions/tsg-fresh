<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryPurchaseItem extends Model
{
    use HasFactory;
    protected $connection = 'tenant';
    protected $table = 'inventory_purchase_item';
    protected $fillable = [
        'purchase_id',
        'product_id',
        'price',
        'quantity',
        'total',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public function purchase()
    {
        return $this->belongsTo(Purchases::class, 'id', 'purchase_id');
    }
    public function opurchase()
    {
        return $this->belongsTo(OtherPurchase::class, 'id', 'purchase_id');
    }
    // public function product() {
    //     return $this->hasOne(Ingredient::class, 'id', 'product_id');
    // }
    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'product_id', 'id');
    }
    // public function ingredient() {
    //    return $this->belongsTo(Ingredient::class, 'ingredient_id', 'id');
    // } 
    // public function inventory() {
    //     return $this->belongsTo(Inventory::class, 'inventory_id');
    // }
}
