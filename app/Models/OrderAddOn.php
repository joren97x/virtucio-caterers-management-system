<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderAddOn extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'add_on_id',
        'order_id'
    ];

    public function add_on(): BelongsTo
    {
        return $this->belongsTo(AddOn::class);
    } 

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    } 

}
