<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class landing_page_sections extends Model
{
    protected $fillable = ['name', 'title', 'is_active'];

    public function items(): HasMany
    {
        return $this->hasMany(landing_page_items::class, 'section_id')->orderBy('order');
    }
}
