<?php

namespace App\View\Components;

use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\View\Component;

class PackageTitle extends Component
{
    public $planName = null;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $plan = null;
        if(auth()->check()){
            $plan = Plan::find(auth()->user()->next_plan_id);
        }else if(!empty($request->plan_id)){
            $plan = Plan::where('priceId', $request->plan_id)->latest()->first();
        }else{
            $plan = Plan::find(app('freePlanId'));
        }
        $this->planName = !empty($plan) ? $plan->name : null;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.package-title');
    }
}
