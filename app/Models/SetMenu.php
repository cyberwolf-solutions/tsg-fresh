<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SetMenu extends Model
{
    protected $table = 'setmenu';
    use HasFactory;

    protected $fillable = [
        'name',
        'category_id',
        'unit_price_lkr',
        'unit_price_usd',
        'unit_price_eu',
        'image_url',
        'setmenu_type',
        'type',
        'setmenu_meal_type',

        'setmenu_type',
        'description',
        'created_by',
        'updated_by',
        'deleted_by'
    ];



    public function category() {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class,'meals_products','meal_id','product_id');
    }

    public function createdBy() {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function updatedBy() {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }

    public function deletedBy() {
        return $this->hasOne(User::class, 'id', 'deleted_by');
    }
    public function setmenuType() {
        return $this->hasOne(SetMenuType::class, 'id', 'setmenu_type');
    }

    public function setmenumealType() {
        return $this->hasOne(SetMenuMealType::class, 'id', 'setmenu_meal_type');
    }
    public function orderItem()
    {
        return $this->morphOne(OrderItem::class, 'itemable');
    }
}
