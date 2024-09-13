<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;

class OrdersController extends Controller
{
    private $showButtons = [
        'all' => true,
        OrderStatus::PENDING => true,
        OrderStatus::IN_REVIEW => true,
        OrderStatus::COMPLETE => true
    ];
    private $buttonsTitle = [
        'all' => 'Orders',
        OrderStatus::PENDING => 'New Orders',
        OrderStatus::IN_REVIEW => 'In Review Orders',
        OrderStatus::COMPLETE => 'Complete Orders'
    ];
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($status = 'all')
    {
        $this->showButtons[$status] = false;
        $orders = Order::with('user');
        if($status != 'all'){
            $orders = $orders->getOrder($status);
        }
        $orders = $orders->latest()->get();
        return view('admin.orders.index',[
            'orders' => $orders,
            'orderTitle' => $this->buttonsTitle[$status],
            'showButtons' => $this->showButtons
        ]);
    }
    public function newOrders()
    {
        return $this->index(OrderStatus::PENDING);
    }
    public function reviewOrders()
    {
        return $this->index(OrderStatus::IN_REVIEW);
    }
    public function completeOrders()
    {
        return $this->index(OrderStatus::COMPLETE);
    }
}
