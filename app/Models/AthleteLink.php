<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AthleteLink extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'is_feature'
    ];

    public function template()
    {
        return $this->belongsTo(LinkTemplate::class, "link_template_id", "id");
    }
    public function fetchAllLinks($onlyFeature = null){
        if($onlyFeature == null){
            return $this->where('user_id', Auth::user()->id)->has('template')->get();
        }
        return $this->where('user_id', Auth::user()->id)->where('is_feature', $onlyFeature)->has('template')->get();
    }
    public function fetchAllLinksNonUser($id, $onlyFeature = null){
        if($onlyFeature == null){
            return $this->where('user_id', $id)->has('template')->get();
        }
        return $this->where('user_id', $id)->where('is_feature', $onlyFeature)->has('template')->get();
    }
    public static function store($request, $templateId){
        $self = new self();
        $self->url = $request->link;
        $self->link_template_id = $templateId;
        $self->user_id = Auth::user()->id;
        $self->save();
    }
}
