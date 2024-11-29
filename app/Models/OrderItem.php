<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    use HasFactory, SoftDeletes;

    const CATEGORY_SOUP = 'soup';
    const CATEGORY_MAIN_DISH = 'main_dish';
    const CATEGORY_DESSERT = 'dessert';

    protected $fillable = [
        'product_id',
        'category',
        'order_id'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class)->withTrashed();
    }

    public function orders(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

}
