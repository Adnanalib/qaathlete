<?php

namespace App\View\Components;

use App\Models\Cart as ModelsCart;
use Illuminate\View\Component;

class Cart extends Component
{
    public $cart_count = 0;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $cart = new ModelsCart();
        $this->cart_count = $cart->getCartCount();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.cart');
    }
}
