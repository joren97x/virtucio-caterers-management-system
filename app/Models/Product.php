<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'desc',
        'category_id',
        'price',
        'image_path',
        'special_instructions'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

}
