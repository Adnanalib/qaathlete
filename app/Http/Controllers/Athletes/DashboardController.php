<?php

namespace App\Http\Controllers\Athletes;

use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Http\Requests\PlanDetailRequest;
use App\Models\AthleteDetail;
use App\Models\AthleteLink;
use App\Models\Cart;
use App\Models\LinkTemplate;
use App\Models\Product;
use App\Models\School;
use App\Models\TeamMember;
use App\Models\User;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class DashboardController extends Controller
{
    private $athlete_detail = null;
    private $social_links = null;
    private $product = null;
    private $variant = null;
    private $cart = null;
    private $user = null;

    public function __construct()
    {
        $this->athlete_detail = new AthleteDetail();
        $this->social_links = new AthleteLink();
        $this->product = new Product();
        $this->variant = new Variant();
        $this->cart = new Cart();
        $this->user = new User();
    }
    public function index(Request $request)
    {
        $showAll = $request->orderList == 'true' ? false : true;
        $athlete_detail = $this->athlete_detail->findOrCreateAthleteDetail();
        $links = $this->social_links->fetchAllLinks();
        return view('athletes.dashboard.index', compact('athlete_detail', 'links', 'showAll'));
    }
    public function viewChart(Request $request)
    {
        $user = getCurrentUser();
        if($user->type == UserType::COACH || !$user->checkPermission('can-show-analytics')){
            dangerError("Sorry, you do not have permission to proceed with this page.", "Un-Authorized Access!");
            return redirect()->route('athletes.dashboard');
        }
        if (empty($user->qr_id)) {
            dangerError("System didn't find any qr against this Qr id", "Not Found!");
            return redirect()->route('athletes.dashboard');
        }
        $chartDetail = getQrDetail($user);
        return view('athletes.dashboard.view-chart', compact('chartDetail', 'user'));
    }
    public function detail($uuid, Request $request){
        $product = $this->product->findBy('uuid', $uuid);
        if(empty($product)){
            return redirect()->back();
        }
        $cartItem = $this->cart->getItemByProductId($product->id);
        $relatedProducts = !empty($product->category_id) ? $this->product->fetchOtherProducts($product->category_id, $product->id) : [];
        $images = $product->getImageArray();
        $variants = $this->variant->pluck('name');
        return view('athletes.dashboard.product-detail', compact('product', 'relatedProducts', 'images', 'variants', 'cartItem'));
    }
}
