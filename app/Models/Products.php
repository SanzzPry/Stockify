<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Products extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'category_id',
        'supplier_id',
        'name',
        'sku',
        'description',
        'purchase_price',
        'selling_price',
        'image',
    ];

    public function stockTransactions(): HasMany
    {
        return $this->hasMany(stockTransactions::class);
    }

    public function categories(): BelongsTo
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }

    public function suppliers(): BelongsTo
    {
        return $this->belongsTo(Suppliers::class, 'supplier_id');
    }

    public function productAttributes(): HasMany
    {
        return $this->hasMany(ProductAttributes::class);
    }
}
