<?php

namespace App\Http\Controllers\Athletes;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlanDetailRequest;
use App\Models\AthleteDetail;
use App\Models\AthleteLink;
use App\Models\LinkTemplate;
use App\Models\Plan;
use App\Models\Product;
use App\Models\School;
use App\Models\User;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OnboardingController extends Controller
{
    private $school = null;
    private $user = null;
    private $athlete_detail = null;
    private $social_links = null;
    private $link_template = null;
    public function __construct()
    {
        $this->school = new School();
        $this->user = new User();
        $this->athlete_detail = new AthleteDetail();
        $this->social_links = new AthleteLink();
        $this->link_template = new LinkTemplate();
    }
    public function index(Request $request)
    {
        $previous_step = $request->previous_step;
        $schools = $this->school->all();
        $isUpdate = !empty($request->step);
        $step = $request->step ?? null;
        $athlete_detail = $this->athlete_detail->findOrCreateAthleteDetail();
        if ($previous_step > 0 && $previous_step < 5) {
            $athlete_detail->setNumberAttributeValue('current_step', $previous_step)->save();
        }
        $links = $this->social_links->fetchAllLinks();
        $nextPlan = getCurrentUser()->getNextPlan();
        return view('athletes.onboarding.index', compact('schools', 'athlete_detail', 'links', 'isUpdate', 'step', 'nextPlan'));
    }
    public function store(PlanDetailRequest $request)
    {
        $previous_step = $request->previous_step;
        if ($previous_step > 0 && $previous_step < 5) {
            return $this->index($request);
        }
        $athlete_detail = $this->athlete_detail->findOrCreateAthleteDetail();
        try {
            $athlete_detail->store($request);
        } catch (\Exception $e) {
            logDebug($e);
            throw ValidationException::withMessages(['link' => $e->getMessage()]);
        }
        if (!empty($request->_move_to_next_page) && $request->_move_to_next_page < 5) {
            if($request->_move_to_next_page == 4 && $request->_moveToNext == 'false'){
                return redirect()->route('athletes.onboarding',['step' => $request->_move_to_next_page - 2]);
            }
            return redirect()->route('athletes.onboarding',['step' => $request->_move_to_next_page]);
        }else if(!empty($request->_move_to_next_page) && $request->_move_to_next_page == 5){
            return redirect()->route('athletes.dashboard');
        } else if ($athlete_detail->current_step == 5) {
            return redirect()->route('athletes.dashboard');
        }
        return redirect()->back();
    }
    public function profile(Request $request)
    {
        $user = $request->user();
        $athlete_detail = $this->athlete_detail->findOrCreateAthleteDetail();
        $links = $this->social_links->fetchAllLinks(true);
        return view('profile.index', compact('athlete_detail', 'links', 'user'));
    }
    public function delete($socialLinkId)
    {
        if ($this->social_links->where(['id' => $socialLinkId, 'user_id' => Auth::user()->id])->count() == 0) {
            throw ValidationException::withMessages(['social-link-' . $socialLinkId => 'Invalid id to be removed.']);
        }
        try {
            DB::beginTransaction();
            $socialLink = $this->social_links->where(['id' => $socialLinkId, 'user_id' => Auth::user()->id])->first();
            $link_template_id = $socialLink->link_template_id;
            $socialLink->delete();
            $this->link_template->find($link_template_id)->delete();
            getCurrentUser()->decrementLinkUsage();
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            throw ValidationException::withMessages(['social-link-' . $socialLinkId => $ex->getMessage()]);
        }
        return redirect()->back();
    }
    public function makeFeature($socialLinkId)
    {
        if ($this->social_links->where(['id' => $socialLinkId, 'user_id' => Auth::user()->id])->count() == 0) {
            throw ValidationException::withMessages(['social-link-' . $socialLinkId => 'Invalid id to be removed.']);
        }
        try {
            DB::beginTransaction();
            $socialLink = $this->social_links->where(['id' => $socialLinkId, 'user_id' => Auth::user()->id])->first();
            $this->social_links->where(['user_id' => Auth::user()->id])->update([
                'is_feature' => false,
            ]);
            $socialLink->setAttributeValue('is_feature', true)->save();
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            throw ValidationException::withMessages(['social-link-' . $socialLinkId => $ex->getMessage()]);
        }
        return redirect()->back();
    }

}
