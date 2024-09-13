<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends BaseModel
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'priceId',
        'name',
        'price',
        'currency',
        'interval',
        'trial',
        'active',
        'link_limit',
        'show_analytics',
    ];

    private static $status = [
        'active' => 1,
        'inActive' => 0,
    ];

    public function details()
    {
        return $this->hasMany(PlanDetail::class, "plan_id", "id");
    }

    public static function fetchPlans($excludeIds)
    {
        return self::with('details')->whereNotIn('id', $excludeIds)->where('active', self::$status['active'])->get();
    }

    public static function getPlanId($priceId)
    {
        $plan = self::where('priceId', $priceId)->where('active', self::$status['active'])->first();
        return $plan->id ?? null;
    }

    public static function fetchPlan($planId)
    {
        return self::where('id', $planId)->with('details')->where('active', self::$status['active'])->first();
    }

    public function nextPlan($price)
    {
        return $this->where('price', '>', $price)->where('active', self::$status['active'])->orderBy('price', 'ASC');
    }

    public function scopeGetActive($query)
    {
        return $query->where('active', 1);
    }
}
