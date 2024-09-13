<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Models\CoachDetail;
use App\Models\Plan;
use App\Models\Sport;
use App\Models\Team;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules\Password;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'full_name' => ['required', 'string', 'min:3', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'numeric', 'phone:AUTO,US', 'unique:users,phone'],
            'password' => ['required', 'confirmed', Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
        ]);
        $fullName = $request->full_name;
        $fullNameArray = explode(' ', $fullName);
        $planId = Plan::getPlanId($request->plan_id);
        if(empty($planId)){
            $planId = app('freePlanId');
        }
        $user = User::create([
            'full_name' => $fullName,
            'first_name' => isset($fullNameArray[0]) ? $fullNameArray[0] : '',
            'last_name' => isset($fullNameArray[1]) ? $fullNameArray[1] : '',
            'email' => $request->email,
            'phone' => $request->phone,
            'type' => UserType::ATHLETE,
            'uuid' => generateUUID(),
            'password' => Hash::make($request->password),
            'plan_id' => $planId,
            'next_plan_id' => $planId,
        ]);
        if (!empty($request->plan_id)) {
            $user->setNextPlanId($request->plan_id);
        }
        event(new Registered($user));

        Auth::login($user);

        createQRCode($user->uuid);

        if (auth()->check()) {
            return User::authenticateAndRedirect();
        }

        return redirect(RouteServiceProvider::HOME);
    }
    public function coachRegister(Request $request)
    {
        if (count($request->all()) == 0) {
            $types = Sport::all();
            return view('auth.register-coach', compact('types'));
        }
        $request->validate([
            'full_name' => ['required', 'string', 'min:3', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'numeric', 'phone:AUTO,US', 'unique:users,phone'],
            'password' => ['required', 'confirmed', Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
            'team_name' => ['required', 'string', 'min:3', 'max:255', 'regex:/^[a-zA-Z\s]+$/', 'unique:teams,name'],
            'team_number' => ['required', 'numeric'],
            'sport_type' => ['nullable', 'numeric', 'exists:sports,id'],
        ]);

        try {
            DB::beginTransaction();
            $fullName = $request->full_name;
            $fullNameArray = explode(' ', $fullName);
            $user = User::create([
                'full_name' => $fullName,
                'first_name' => isset($fullNameArray[0]) ? $fullNameArray[0] : '',
                'last_name' => isset($fullNameArray[1]) ? $fullNameArray[1] : '',
                'email' => $request->email,
                'phone' => $request->phone,
                'type' => UserType::COACH,
                'uuid' => generateUUID(),
                'password' => Hash::make($request->password),
            ]);
            $coach = CoachDetail::create([
                'user_id' => $user->id,
            ]);
            Team::create([
                'name' => $request->team_name,
                'total' => (int)$request->team_number,
                'sport_type_id' => $request->sport_type,
                'coach_id' => $coach->id,
            ]);
            $user->createOrGetStripeCustomer();
            event(new Registered($user));
            Auth::login($user);
            DB::commit();
            if (auth()->check()) {
                return User::authenticateAndRedirect();
            }
            return redirect(RouteServiceProvider::HOME);
        } catch (\Exception $e) {
            Session::flash('alert-class', "alert-danger");
            Session::flash('message', $e->getMessage());
            Log::error("Coach Registration. Email: $request->email.  Error: " . json_encode($e->getMessage()));
            DB::rollback();
            return redirect()->back();
        }
    }
}
