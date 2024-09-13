<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Team extends BaseModel
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'total',
        'sport_type_id',
        'coach_id'
    ];
    public function members()
    {
        return $this->hasMany(TeamMember::class, "team_id", "id");
    }
    public function getTeamMemberQuantity(){
        return TeamMember::where('team_id', $this->id)->count();
    }
    public function getSetupTeamMemberQuantity(){
        return TeamMember::where('team_id', $this->id)->whereNotNull('athlete_id')->count();
    }
    public function getNotSetupTeamMemberQuantity(){
        return TeamMember::where('team_id', $this->id)->whereNotNull('athlete_id')->count();
    }
}
