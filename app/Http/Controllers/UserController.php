<?php

namespace App\Http\Controllers;

use App\Enums\HttpResponse;
use App\Models\AthleteDetail;
use App\Models\AthleteLink;
use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class UserController extends Controller
{
    private $athlete_detail = null;
    private $social_links = null;
    private $teamMember = null;
    public function __construct()
    {
        $this->athlete_detail = new AthleteDetail();
        $this->social_links = new AthleteLink();
        $this->teamMember = new TeamMember();
    }
    public function regenerateQR()
    {
        try {
            $user = User::find(Auth::user()->id);
            if (!empty($user)) {
                $uuid = generateUUID();
                $qrUrl = url('/profile-view') . '/' . $uuid;
                $oldQRImage = $user->qr_image_url;
                $qr = getQRImage($qrUrl, $uuid);
                $user
                    ->setNumberAttributeValue('uuid', $uuid)
                    ->setNumberAttributeValue('qr_image_url', $qr['qr_image_url'])
                    ->setAttributeValue('qr_id', $qr['qr_id'])
                    ->setAttributeValue('qr_url', $qr['qr_url'])
                    ->setAttributeValue('qr_data', $qr['qr_data'])
                    ->save();
                Storage::disk('public')->delete($oldQRImage);
            }
        } catch (\Throwable $th) {
            Session::flash('error', $th->getMessage());
            Log::error("Error: " . json_encode($th->getMessage()));
        } catch (\Exception $th) {
            Session::flash('error', $th->getMessage());
            Log::error("Error: " . json_encode($th->getMessage()));
        }
        return redirect()->back();
    }
    public function update(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'profile_image' => 'nullable|file|image|mimes:jpeg,jpg,png,gif|max:2048',
            'background_image' => 'nullable|file|image|mimes:jpeg,jpg,png,gif|max:2048',
            'password' => ['nullable', 'confirmed', Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
        ]);
        $user = User::find(Auth::user()->id);
        $user
            ->setAttributeValue('first_name', $request->first_name)
            ->setAttributeValue('last_name', $request->last_name)
            ->setAttributeValue('full_name', $request->first_name . ' ' . $request->last_name)
            ->setAttributeValue('phone', $request->phone)
            ->setAttributeValue('short_description', $request->short_description)
            ->setAttributeValue(
                'profile_image',
                !empty($request->file('profile_image')) && $request->hasFile('profile_image')
                    ? uploadAvatar($request->file('profile_image'))
                    : $user->profile_image
            )
            ->setAttributeValue(
                'background_image',
                !empty($request->file('background_image')) && $request->hasFile('background_image')
                    ? uploadThumbnail($request->file('background_image'))
                    : $user->background_image
            )
            ->save();
        if(!empty($request->password)){
            $user->setAttributeValue('password', Hash::make($request->password))->save();
        }
        Session::flash('alert-class', "alert-success");
        Session::flash('success', "Profile updated successfully.");
        return redirect()->back();
    }
    public function profile($uuid)
    {
        $user = User::where('uuid', $uuid)->with('school')->latest()->first();
        if (!empty($user)) {
            $athlete_detail = $this->athlete_detail->findOrCreateAthleteDetailNonUser($user->id);
            $links = $this->social_links->fetchAllLinksNonUser($user->id, true);
            return view('profile.index', compact('athlete_detail', 'links', 'user'));
        }
        abort(HttpResponse::NOT_FOUND);
    }
    public function teamProfile($uuid)
    {
        $teamMember = $this->teamMember->findBy('uuid', $uuid);
        if (!empty($teamMember) && !empty($teamMember->user)) {
            return $this->profile($teamMember->user->uuid);
        }
        abort(HttpResponse::NOT_FOUND);
    }

}
