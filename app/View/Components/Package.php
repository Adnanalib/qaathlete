<?php

namespace App\View\Components;

use App\Enums\UserType;
use App\Models\AthleteDetail;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\View\Component;

class Package extends Component
{
    private $planId = null;
    public $myPlan = null;
    public $otherPlans = [];
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        if(auth()->check()){
            $this->planId = auth()->user()->next_plan_id;
        }else if(!empty($request->plan_id)){
            $plan = Plan::where('priceId', $request->plan_id)->latest()->first();
            $this->planId = !empty($plan) ? $plan->id : null;
        }
        $this->planId = $this->planId ?? app('freePlanId');
        if(!auth()->check()){
            $this->myPlan = Plan::fetchPlan($this->planId);
            $this->otherPlans = Plan::fetchPlans([$this->planId]);
        }else if(auth()->check() && empty($request->user()->athlete)){
            $this->myPlan = Plan::fetchPlan(auth()->user()->next_plan_id);
            $this->otherPlans =(new Plan())->nextPlan(0)->whereNot('id', auth()->user()->next_plan_id)->get();
        }else{
            $this->myPlan = Plan::fetchPlan(auth()->user()->plan_id);
            $this->otherPlans =(new Plan())->nextPlan($this->myPlan->price)->whereNot('id', auth()->user()->next_plan_id)->get();
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.package');
    }
}
