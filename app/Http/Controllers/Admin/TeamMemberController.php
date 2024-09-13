<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\TeamMember;

class TeamMemberController extends Controller
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
        $teamMembers = TeamMember::with(['team', 'size'])->orderBy('created_at','desc')->get();
        return view('admin.team-member.index',[
            'teamMembers' => $teamMembers
        ]);
    }
}
