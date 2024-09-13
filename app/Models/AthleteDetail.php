<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AthleteDetail extends BaseModel
{
    use HasFactory;

    public function school()
    {
        return $this->belongsTo(School::class, "school_id", "id");
    }
    public function findOrCreateAthleteDetail(){
        if($this->where('user_id', Auth::user()->id)->count() == 0){
            $athlete_detail = new AthleteDetail();
            $athlete_detail->user_id = Auth::user()->id;
            $athlete_detail->save();
        }
        return $this->where('user_id', Auth::user()->id)->with('school')->latest()->first();
    }
    public function findOrCreateAthleteDetailNonUser($id){
        if($this->where('user_id', $id)->count() == 0){
            $athlete_detail = new AthleteDetail();
            $athlete_detail->user_id = $id;
            $athlete_detail->save();
        }
        return $this->where('user_id', $id)->with('school')->latest()->first();
    }
    public function store($request){
        if($this->current_step == 1 || $request->_move_to_next_page == '2'){
            $this->cpa = $request->cpa;
            $this->gpa = $request->gpa;
            $this->school_id = $request->school;
            $this->major_subject = $request->major_subject;
            $this->uats = $request->uats;
            $this->sats = $request->sats;
            $this->act = $request->act;
            $this->address = $request->address;
            $this->city = $request->city;
            $this->state = $request->state;
            $this->team_name = $request->team_name;
            $this->jersey_number = $request->jersey_no;
            $this->dominant_hand = $request->dominant_hand;
            $this->height = $request->height;
            $this->dead_lift = $request->dead_lift;
            $this->weight = $request->weight;
            if(empty($request->_move_to_next_page)){
                $this->current_step = 2;
            }
            $this->save();
        }else if($this->current_step == 2 || $request->_move_to_next_page == '4'){
            if(!empty($request->_moveToNext) && $request->_moveToNext == 'true'){
                if(empty($request->_move_to_next_page)){
                    $this->current_step = 4;
                }
                $this->save();
            }else{
                $socialLink = AthleteLink::where(['id' => $request->_link_id,'user_id' => Auth::user()->id])->first();
                $templateId = LinkTemplate::store($request, $socialLink);
                AthleteLink::store($request, $templateId);
                if(empty($socialLink)){
                    getCurrentUser()->incrementLinkUsage();
                }
            }
        }else if($this->current_step == 3 || $request->_move_to_next_page == '4'){
            $this->reference_full_name = $request->reference_full_name;
            $this->reference_designation = $request->reference_designation;
            $this->reference_contact_info = $request->reference_contact_info;
            if(empty($request->_move_to_next_page)){
                $this->current_step = 4;
            }
            $this->save();
        }else if($this->current_step == 4 || $request->_move_to_next_page == '5'){
            $this->coach_full_name = $request->coach_full_name;
            $this->coach_designation = $request->coach_designation;
            $this->coach_contact_info = $request->coach_contact_info;
            if(empty($request->_move_to_next_page)){
                $this->current_step = 5;
            }
            $this->save();
        }
    }
}
