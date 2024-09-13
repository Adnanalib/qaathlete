<?php

namespace App\Http\Controllers\Coach;

use App\Enums\TeamMemberStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\TeamMemberRequest;
use App\Models\{Cart, Product, Team, TeamMember, User, Variant};
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Support\Facades\Response;

class DashboardController extends Controller
{
    private $team = null;
    private $teamMember = null;
    private $variant = null;
    private $product = null;
    private $cart = null;

    public function __construct()
    {
        $this->variant = new Variant();
        $this->team = new Team();
        $this->teamMember = new TeamMember();
        $this->product = new Product();
        $this->cart = new Cart();
    }
    public function index(Request $request)
    {
        $showAll = $request->orderList == 'true' ? false : true;
        $showAllTeam = $request->teamMemberList == 'true' ? false : true;
        return view('coach.dashboard.index', compact('showAll', 'showAllTeam'));
    }
    public function downloadRoaster(Request $request)
    {
        $members = (new TeamMember())->getActiveOnly();
        $team = $request->user()->team;
        $data = [
            'members' => $members,
            'team' => $team,
            'date' => count($members),
            'baseUrl' => config('app.url')
        ];

        $pdf = SnappyPdf::loadView('coach.team.roaster-pdf', $data);
        $pdfContent = $pdf->setPaper('A4')->output();

        return Response::make(
            $pdfContent,
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename=' . ($team->name ?? Carbon::now()->format('Y-m-d H:i:s')) . '.pdf',
            ]
        );
    }
    public function viewChart(Request $request)
    {
        $member = $this->teamMember->findBy('qr_id', $request->qr_id);
        if (empty($member)) {
            dangerError("System didn't find any qr against this Qr id", "Not Found!");
            return redirect()->route('coach.dashboard');
        }
        if (empty($member->athlete_id)) {
            dangerError("Look like you didn't setup against this member yet.", "Team Member Not Found!");
        }
        $chartDetail = getQrDetail($member);
        return view('coach.dashboard.view-chart', compact('member', 'chartDetail'));
    }

    public function productDetail($uuid, Request $request)
    {
        $product = $this->product->findBy('uuid', $uuid);
        $team = $request->user()->team;
        $teamMembers = $team->members;
        if (empty($product)) {
            dangerError("Product Not Found", "Not Found!");
            return redirect()->route('coach.dashboard');
        }
        $cartItem = $this->cart->getItemByProductId($product->id);
        $relatedProducts = !empty($product->category_id) ? $this->product->fetchOtherProducts($product->category_id, $product->id) : [];
        $images = $product->getImageArray();
        $variants = $this->variant->fetchAgainstSize($team->id);
        return view('coach.dashboard.product-detail', compact('product', 'relatedProducts', 'images', 'variants', 'cartItem', 'team', 'teamMembers'));
    }
    public function setupTeam(Request $request)
    {
        try {
            $this->team = $request->user()->team;
            $teamMembers = $this->team->members;
            $this->team->saveOrUpdate($this->team, $request);
            if (count($this->team->members) == 0) {
                for ($index = 0; $index < $this->team->total; $index++) {
                    $uuid = generateUUID();
                    $teamQR = createTeamQRCode($uuid);
                    $this->teamMember->saveOrUpdate(new TeamMember(), $request->replace([
                        'uuid' => $uuid,
                        'team_id' => $this->team->id,
                        'qr_image_url' => $teamQR['qr_image_url'],
                        'qr_url' => $teamQR['qr_url'],
                        'qr_id' => $teamQR['qr_id'],
                        'qr_data' => $teamQR['qr_data'],
                    ]));
                }
            }
            $teamMembers = $this->teamMember->where('team_id', $this->team->id)->get();
            $team = $this->team;
            $variants = $this->variant->all();
            return view('coach.team.index', compact('teamMembers', 'team', 'variants'));
        } catch (\Throwable $e) {
            dangerError($e->getMessage());
            Log::error("Error: " . json_encode($e->getMessage()));
            Log::error($e);
        } catch (\Exception $e) {
            dangerError($e->getMessage());
            Log::error("Error: " . json_encode($e->getMessage()));
            Log::error($e);
        }
        return redirect()->back()->withInput($request->all());
    }
    public function TeamMemberStore(TeamMemberRequest $request)
    {
        try {
            DB::beginTransaction();
            $members = $request->only(['player_name', 'player_email', 'jersey_size', 'uuid', 'profile_link']);
            $isUpdate = false;
            foreach ($members['player_name'] as $index => $member) {
                $uuid = $members['uuid'][$index];
                $player_name = $members['player_name'][$index];
                $player_email = $members['player_email'][$index];
                $jersey_size = $members['jersey_size'][$index];
                $profile_link = $members['profile_link'][$index];
                $teamMember = $this->teamMember->findBy('uuid', $uuid);
                if (empty($teamMember)) {
                    dangerError(__('Team member not found. Please refresh your browser and try again.'));
                }
                if (!empty($player_email)) {
                    $status = !empty($teamMember->status) ? $teamMember->status : TeamMemberStatus::INVITATION_SENT;
                    $user = User::where('email', $player_email)->first();
                    if (empty($user)) {
                        $status = TeamMemberStatus::INVITATION_SENT;
                        $user = User::createOrFindAndSendInvitation($player_email, $player_name, $teamMember);
                    }
                    $teamMember->saveOrUpdate($teamMember, $request->replace([
                        'player_name' => $player_name,
                        'player_email' => $player_email,
                        'profile_link' => $profile_link,
                        'athlete_id' => $user->id,
                        'jersey_size' => $jersey_size,
                        'status' => $status,
                    ]));
                    $isUpdate = true;
                }
            }
            if ($isUpdate) {
                Session::flash('alert-class', 'alert-success');
                Session::flash('alert-extra-class', 'setup-team-alert');
                Session::flash('alert-title', 'Success!');
                Session::flash('message', "Team Setup Successfully.");
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            logError($e);
            dangerError($e->getMessage());
            return redirect()->back()->withInput($request->all());
        }
        return redirect()->back();
    }
}
