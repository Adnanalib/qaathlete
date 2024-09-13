<?php

namespace App\View\Components;

use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\View\Component;

class SetupTeam extends Component
{
    public $members = [];
    public $teamMembers = [];
    public $team = null;
    public $member_count = 0;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->team = $request->user()->team;
        $this->members = (new TeamMember())->getAll($request->teamMemberList);
        $this->teamMembers = (new TeamMember())->getActiveOnly();
        $this->member_count = count((new TeamMember())->getAll(true));
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.setup-team');
    }
}
