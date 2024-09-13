<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends BaseModel
{
    use HasFactory;

    public function store(Cart $cart, CartItem $cartItem, Order $order)
    {
        $orderItem = new OrderItem();
        $orderItem
            ->setAttributeValue('sku', $cartItem->sku)
            ->setAttributeValue('variant', $cartItem->variant)
            ->setAttributeValue('quantity', $cartItem->quantity)
            ->setAttributeValue('price', $cartItem->price)
            ->setAttributeValue('discount', $cartItem->discount)
            ->setAttributeValue('preference', $cartItem->preference)
            ->setAttributeValue('order_id', $order->id)
            ->setAttributeValue('cart_id', $cart->id)
            ->setAttributeValue('product_id', $cartItem->product_id)
            ->setAttributeValue('category_id', $cartItem->category_id)
            ->save();
        return $orderItem;
    }
}
