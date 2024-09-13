<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    private $showButtons = [
        'all' => true,
        UserType::ATHLETE => true,
        UserType::COACH => true
    ];
    private $buttonsTitle = [
        'all' => 'Users',
        UserType::ATHLETE => 'Athletes',
        UserType::COACH => 'Coaches',
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
        $users = User::with('plan');
        if ($status != 'all') {
            $users = $users->getUser($status);
        }
        $users = $users->latest()->get();
        return view('admin.users.index', [
            'users' => $users,
            'userTitle' => $this->buttonsTitle[$status],
            'showButtons' => $this->showButtons
        ]);
    }
    public function athlete()
    {
        return $this->index(UserType::ATHLETE);
    }
    public function coach()
    {
        return $this->index(UserType::COACH);
    }
    public function edit(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect()->back()->with('error', 'Id is invalid');
        }

        return view('admin.users.edit', [
            'user' => $user
        ]);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'full_name' => ['required', 'string', 'min:3', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'phone' => ['nullable', 'numeric', 'phone:AUTO,US'],
            'password' => ['nullable', 'confirmed', Password::min(8)->letters()],
        ]);
        $user = User::find($id);
        if (!$user) {
            return redirect()->back()->with('error', 'Id is invalid');
        }
        $name_parts = explode(' ', $request->full_name);
        $first_name = isset($name_parts[0]) ? $name_parts[0] : '';
        $last_name = isset($name_parts[1]) ? implode(' ', array_slice($name_parts, 1)) : '';
        $user
            ->setAttributeValue('first_name', $first_name)
            ->setAttributeValue('last_name', $last_name)
            ->setAttributeValue('full_name', $request->full_name)
            ->setAttributeValue('phone', $request->phone)
            ->setAttributeValue('short_description', $request->short_description)
            ->setAttributeValue('long_description', $request->long_description);
        if($request->password){
            $user->setAttributeValue('password', Hash::make($request->password));
        }
        $user->save();
        return redirect()->back()->with('success', 'User record updated successfully');
    }
    public function profileEdit(Request $request)
    {
        $user = Admin::find(Auth::guard('admin')->user()->id);
        return view('admin.users.profile-edit', [
            'user' => $user
        ]);
    }
    public function profileUpdate(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'password' => ['nullable', 'confirmed', Password::min(8)->letters()],
        ]);
        $user = Admin::find(Auth::guard('admin')->user()->id);
        $user->setAttributeValue('name', $request->name);
        if($request->password){
            $user->setAttributeValue('password', Hash::make($request->password));
        }
        $user->save();
        return redirect()->back()->with('success', 'Profile update successfully');
    }
}
