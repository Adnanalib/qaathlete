<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\UserType;
use App\Providers\RouteServiceProvider;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'first_name',
        'last_name',
        'phone',
        'email',
        'password',
        'type',
        'school_id',
        'uuid',
        'plan_id',
        'next_plan_id',
        'short_description'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected static function boot()
    {
        parent::boot();

        static::saved(function ($model) {
            Session::forget('current_user');
            updateCurrentUser();
        });
    }
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setNumberAttributeValue($name, $value)
    {
        if ($value != null && $value != 'null' && $value != 'undefined') {
            $this->attributes[$name] = (string)$value;
        }
        return $this;
    }
    public function setAttributeValue($name, $value)
    {
        if (!empty($value)) {
            $this->attributes[$name] = $value;
        }
        return $this;
    }
    /**
     * ---------------------------ORM Relations---------------------------------------
     */
    public function school()
    {
        return $this->belongsTo(School::class, "school_id", "id");
    }
    public function plan()
    {
        return $this->belongsTo(Plan::class, "plan_id", "id");
    }
    public function nextPlan()
    {
        return $this->belongsTo(Plan::class, "next_plan_id", "id");
    }
    public function athlete()
    {
        return $this->hasOne(AthleteDetail::class, "user_id", "id");
    }
    public function coach()
    {
        return $this->hasOne(CoachDetail::class, "user_id", "id");
    }
    public function team()
    {
        return $this->hasOneThrough(Team::class, CoachDetail::class, 'user_id', 'coach_id', 'id', 'id');
    }
    /**
     * ---------------------------Helper Functions--------------------------------------
     */

     public function scopeGetUser($query, $status = null){
        return $status ? $query->where('type', $status) : $query;
    }
    public static function getTableName()
    {
        $self = new self();
        return $self->getTable();
    }
    public static function isPaymentPaid($user)
    {
        return $user->subscribed(config('strip.productName'))
            && $user->subscription(config('strip.productName'))->valid()
            ;
    }
    public static function authenticateAndRedirect()
    {
        return redirect()->intended(getCurrentUserHomeUrl());
    }
    public function findBy($key, $value)
    {
        return $this->where($key, $value)->latest()->first();
    }
    public static function getUser()
    {
        if (!Auth::check()) {
            return false;
        }
        return User::find(Auth::user()->id);
    }
    public function setPlanId($planId)
    {
        $plan = Plan::where('priceId', $planId)->latest()->first();
        if (!empty($plan)) {
            $this->plan_id = $plan->id;
            $this->save();
            Session::forget('current_user');
        }
    }
    public function setNextPlanId($planId)
    {
        $plan = Plan::where('priceId', $planId)->latest()->first();
        if (!empty($plan)) {
            $this->next_plan_id = $plan->id;
            $this->save();
            Session::forget('current_user');
        }
    }
    public function setPlanIdNull()
    {
        $this->plan_id = null;
        $this->save();
    }
    public function setNextPlanIdNull()
    {
        $this->next_plan_id = null;
        $this->save();
    }


    public function getCoachSubscriptionPrice($addMorePlayerSize = null)
    {
        if (auth()->user()->type == UserType::COACH) {
            $perPlayerPrice = (float)config('strip.per_player_price', 0.0);
            if(!empty($addMorePlayerSize)){
                return $addMorePlayerSize * $perPlayerPrice;
            }
            return isset(auth()->user()->team->total) ? auth()->user()->team->total * $perPlayerPrice : 0.0;
        }
        return 0.0;
    }
    public static function createOrFindAndSendInvitation($email, $fullName, $teamMember)
    {
        try {
            $fullNameArray = explode(' ', $fullName);
            $password = getRandomToken(10);
            $user = User::create([
                'full_name' => $fullName,
                'first_name' => isset($fullNameArray[0]) ? $fullNameArray[0] : '',
                'last_name' => isset($fullNameArray[1]) ? $fullNameArray[1] : '',
                'email' => $email,
                'type' => UserType::ATHLETE,
                'uuid' => generateUUID(),
                'password' => Hash::make($password),
                'plan_id' => app('freePlanId'),
                'next_plan_id' => app('freePlanId'),
            ]);
            createQRCode($user->uuid);
            $user->createOrGetStripeCustomer();
            $user->sendInvitation($password, $teamMember);
            return $user;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function sendInvitation($password, $teamMember)
    {
        $data = [
            'name' => $this->full_name,
            'email' => $this->email,
            'password' => $password,
            'team_name' => $teamMember->team->name,
            'invitation_link' => route('login') . '?uuid=' . $teamMember->uuid,
        ];
        Mail::send('mail.new-user-invitation', $data, function($message) use ($data){
            $message->from(config('mail.from.address'), config('mail.from.name'));
            $message->to($data['email'])->subject(translateMessage(__('New User Invitation')));
        });
    }

    public function notifyOrderStatus()
    {
    }

    public function checkPermission($permission)
    {
        if($permission == 'can-show-analytics' && $this->plan->show_analytics == '1'){
            return true;

        }else if($permission == 'check-link-limit' && $this->links_usages < $this->getLinkLimit()){
            return true;
        }
        return false;
    }
    public function cancelSubscription(){
        $this->subscription(config('strip.productName'))->cancel();
    }

    public function canCancel()
    {
        return $this->plan->id != app('freePlanId');
    }

    public function isAthlete()
    {
        return $this->type == UserType::ATHLETE;
    }

    public function isCoach()
    {
        return $this->type == UserType::COACH;
    }

    public function isSubscribedToFree()
    {
        return $this->plan_id == app('freePlanId');
    }

    public function isUpgradable()
    {
        return (new Plan())->nextPlan($this->plan->price)->count() > 0;
    }

    public function getNextPlan()
    {
        return (new Plan())->nextPlan($this->plan->price)->first();
    }

    public function getRemainingLinkLimit()
    {
        $link_remains = $this->plan->link_limit - $this->links_usages;
        return $link_remains > 0 ? $link_remains : 0;
    }

    public function getLinkLimit()
    {
        return $this->plan->link_limit ?? 0;
    }

    public function getCurrentStep()
    {
        return !empty($this->athlete) ? (int)$this->athlete->current_step : 0;
    }

    public function incrementLinkUsage()
    {
        $this->links_usages += 1;
        $this->save();
    }

    public function decrementLinkUsage()
    {
        $this->links_usages -= 1;
        $this->save();
    }
}
