<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SetMenuMealType extends Model
{

    protected $table = 'setmenu_meal_type';
    use HasFactory;
    protected $fillable = [
        'name',
        'created_by',
        'updated_by',
        'deleted_by'
    ];
}
