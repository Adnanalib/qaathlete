<?php

namespace App\Models;

use App\Enums\TeamMemberStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TeamMember extends BaseModel
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'qr_image_url',
        'qr_url',
        'status',
        'team_id',
        'athlete_id',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class, "team_id", "id");
    }

    public function user()
    {
        return $this->belongsTo(User::class, "athlete_id", "id");
    }

    public function size()
    {
        return $this->belongsTo(Variant::class, "jersey_size", "id");
    }
    public function getTeamMemberQuantity($teamId){
        return $this->where('team_id', $teamId)->whereNotNull('athlete_id')->count();
    }
    public function getAll($showAll = null)
    {
        $query = $this->where('team_id', Auth::user()->team->id);
        if (empty($showAll)) {
            $query = $query->limit(config('app.team_limit'));
        }
        return $query->with('team')->with('user')->latest()->get();
    }
    public function getActiveOnly()
    {
        return $this->where('team_id', Auth::user()->team->id)->has('team')->has('user')->with('team')->with('user')->latest()->get();
    }

    public static function acceptInvitation($request){
        $teamMember = TeamMember::where('uuid', $request->uuid);
        if(auth()->check()){
            $teamMember = $teamMember->where('athlete_id', auth()->user()->id);
        }
        $teamMember = $teamMember->latest()->first();
        if(!empty($teamMember) && $teamMember->status == TeamMemberStatus::INVITATION_SENT){
            $teamMember->saveOrUpdate($teamMember, $request->replace([
                'status' => TeamMemberStatus::INVITATION_ACCEPTED,
            ]));
        }
    }
}
