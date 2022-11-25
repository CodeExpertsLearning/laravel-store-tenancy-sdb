<?php

namespace App\Models;

use App\Traits\BelongsTenantScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory, BelongsTenantScope;

    protected $fillable = [
        'store_id', 'user_id', 'code',
        'items', 'shipping_value', 
        'payment_status'
        ];
    
    public function setShippingValueAttribute($prop)
    {
       $this->attributes['shipping_value'] = $prop * 100;
    }

    public function getShippingValueAttribute()
    {
        return $this->attributes['shipping_value'] / 100;
    }

    public function getItemsAttribute()
    {
        return unserialize($this->attributes['items']);
    }

    public function setItemsAttribute($prop)
    {
       $this->attributes['items'] = serialize($prop);
    }
}
