<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class landing_page_items extends Model
{
    protected $fillable = [
        'section_id',
        'title',
        'description',
        'image_path',
        'button_text',
        'button_link',
        'order',
        'style',
        'is_active'
    ];

    protected $casts = [
        'style' => 'array',
        'is_active' => 'boolean'
    ];

    public function section(): BelongsTo
    {
        return $this->belongsTo(landing_page_sections::class);
    }
}
