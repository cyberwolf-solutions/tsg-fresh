<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SetMenuType extends Model
{
    use HasFactory;
    protected $table = 'setmenu_type';
    protected $fillable = [
        'name',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    
}
