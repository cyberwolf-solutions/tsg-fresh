<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SetmenuProducts extends Model
{

    protected $table = 'setmenu_products';
    use HasFactory;

    protected $fillable = [
        'setmenu_id',
        'product_id',
        'quantity',
        'created_by',
        'updated_by',
    ];

}
