<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Category, Order, Plan, Product, Team, TeamMember, User};
use App\Enums\{OrderStatus, UserType};

class DashboardController extends Controller
{
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
    public function index()
    {
        return view('admin.dashboard.index',[
            'orders' => Order::count(),
            'new_orders' => Order::getOrder(OrderStatus::PENDING)->count(),
            'in_review_orders' => Order::getOrder(OrderStatus::IN_REVIEW)->count(),
            'completed_orders' => Order::getOrder(OrderStatus::COMPLETE)->count(),
            'categories' => Category::count(),
            'earnings' => Order::getOrder(OrderStatus::COMPLETE)->sum('grand_total'),
            'active_plans' => Plan::getActive()->count(),
            'products' => Product::count(),
            'teams' => Team::count(),
            'team_members' => TeamMember::count(),
            'users' => User::count(),
            'athletes' => User::where('type', UserType::ATHLETE)->count(),
            'coaches' => User::where('type', UserType::COACH)->count(),
            'orderList' => Order::with('user')->latest()->get(),
            'orderTitle' => 'Orders'
        ]);
    }
}
