<?php

namespace App\View\Components;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\Component;

class CartOrder extends Component
{
    public $orders = [];
    public $order_count = 0;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->orders = (new Order())->getAll($request->orderList);
        $this->order_count = count((new Order())->getAll(true));
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.cart-order');
    }
}
