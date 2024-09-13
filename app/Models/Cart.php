<?php

namespace App\Models;

use App\Enums\CartStatus;
use App\Enums\UserType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class Cart extends BaseModel
{
    use HasFactory;

    public function items()
    {
        return $this->hasMany(CartItem::class, "cart_id", "id");
    }
    public function getCurrentUserCartItems($type = 'onlyHasRelation' ,$productId = null)
    {
        $query = $this->where('user_id', Auth::user()->id)->where('type', Auth::user()->type)->where('status', CartStatus::PENDING);
        if(config('app.cart_session') == 'true'){
            $query = $query->whereNotNull('sessionId')->where('sessionId', Session::get('cartSessionId-'. auth()->user()->id));
        }
        if(auth()->user()->type == UserType::COACH && $type != 'withProductId'){
            return $query->with('items');
        }
        if($type == 'onlyHasRelation'){
            return $query->has('items.product')->has('items.product_variant');
        }else if($type == 'noRelation'){
            return $query;
        }else if($type == 'withWithAndHasRelation'){
            return $query->has('items.product')->with('items.product')->has('items.product_variant')->with('items.product_variant');
        }else if($type == 'withWithAndHasRelationOfOnlyProduct'){
            return $query->has('items.product')->with('items.product');
        }else if($type == 'withWithAndHasRelationOfOnlyVariant'){
            return $query->has('items.product_variant')->with('items.product_variant');
        }else if($type == 'hasAndItems'){
            return $query->has('items.product')->has('items.product_variant')->with('items');
        }else if($type == 'withProductId'){
            return $query->with(['items' => function ($q) use($productId){
                $q->where('product_id', $productId);
            }]);
        }
    }
    public function getBySession()
    {
        return $this->getCurrentUserCartItems('noRelation')->latest()->first();
    }
    public function getByProductId($productId)
    {
        return $this->getCurrentUserCartItems('withProductId', $productId)->latest()->first();
    }
    public function getItemByProductId($productId)
    {
        $cart = $this->getCurrentUserCartItems('withProductId', $productId)->latest()->first();
        return isset($cart->items[0]) ? $cart->items[0] : null;
    }
    public function getItemsByProductId($productId)
    {
        $cart = $this->getCurrentUserCartItems('withProductId', $productId)->latest()->first();
        return isset($cart->items[0]) ? $cart->items : [];
    }
    public function getAllItems()
    {
        $cart = $this->getCurrentUserCartItems('hasAndItems')->latest()->first();
        return !empty($cart) ? $cart->items : null;
    }
    public function getCartCount()
    {
        $cart = $this->getCurrentUserCartItems('onlyHasRelation')->withCount('items')->latest()->first();
        return !empty($cart) ? $cart->items_count : 0;
    }
    public function hasCart()
    {
        return $this->getCartCount() > 0;
    }
    public function getWithItems()
    {
        return $this->getCurrentUserCartItems('hasAndItems')->latest()->first();
    }
    public function getSummary()
    {
        $detail = [
            'shipping' => 0.0,
            'tax' => 0.0,
            'discount' => 0.0,
            'item_total_price' => 0.0, // subTotal
            'total_exclude_discount' => 0.0, // total
            'total' => 0.0, // Grand Total
        ];
        $total = $this->getCurrentUserCartItems('withWithAndHasRelation')->withSum('items', 'price')->first();
        $total = !empty($total) ? $total->items_sum_price : 0.0;
        $discount = $this->getCurrentUserCartItems('withWithAndHasRelation')->withSum('items', 'discount')->first();
        $discount = !empty($discount) ? $discount->items_sum_discount : 0.0;
        $detail['discount'] = $discount;
        $detail['item_total_price'] = $total;
        $detail['total_exclude_discount'] = $total + $detail['shipping'] + $detail['tax'];
        $detail['total'] = $detail['total_exclude_discount'] - $detail['discount'];
        return (object)$detail;
    }
    public function getGrandTotal()
    {
        return round($this->getSummary()->total * 100);
    }
}
