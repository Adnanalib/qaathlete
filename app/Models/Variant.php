<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Variant extends BaseModel
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name'
    ];
    public function teamMembers()
    {
        return $this->hasMany(TeamMember::class, 'jersey_size', 'id');
    }

    public function fetchAgainstSize($teamId){
        return Variant::withCount(['teamMembers' => function ($query) use ($teamId) {
            $query->where('team_id', $teamId);
        }])->get();
    }
}
