<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class CartItem extends BaseModel
{
    use HasFactory;

    public function product()
    {
        return $this->belongsTo(Product::class, "product_id", "id");
    }
    public function product_variant()
    {
        return $this->belongsTo(Variant::class, "variant", "name");
    }
    public function getPrice(){
        return $this->price;
    }
}
