<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsTenantScope;

class ShippingOption extends Model
{
    use HasFactory, BelongsTenantScope;

    protected $fillable = ['name', 'price'];

    public function setPriceAttribute($prop)
    {
        $price = str_replace(['.', ','], ['', '.'], $prop);

        $this->attributes['price'] = $price * 100;
    }

    public function getPriceAttribute()
    {
        return $this->attributes['price'] / 100;
    }
}
