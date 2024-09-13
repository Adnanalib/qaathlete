<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Enums\UserType;
use Google\Service\Sheets as ServiceSheets;
use Google_Client;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Revolution\Google\Sheets\Sheets;

class Order extends BaseModel
{
    use HasFactory;

    public function items()
    {
        return $this->hasMany(OrderItem::class, "order_id", "id");
    }
    public function transaction()
    {
        return $this->hasOne(Transaction::class, "order_id", "id");
    }
    public function user()
    {
        return $this->belongsTo(User::class, "user_id", "id");
    }
    public function team()
    {
        return $this->belongsTo(Team::class, "team_id", "id");
    }

    public function findQuery($sessionId = null, $status = OrderStatus::PENDING)
    {
        $query = $this->where('user_id', Auth::user()->id)->where('type', Auth::user()->type)->where('status', $status);
        if (config('app.cart_session') == 'true' && !empty($sessionId)) {
            $query = $query->whereNotNull('sessionId')->where('sessionId', $sessionId);
        }
        return $query;
    }

    public function getCartCount($sessionId = null)
    {
        $order = $this->findQuery($sessionId)->withCount('items')->latest()->first();
        return !empty($order) ? $order->items_count : 0;
    }

    public function getAll($showAll = null)
    {
        $query = $this->where('user_id', Auth::user()->id)->where('type', Auth::user()->type);
        if (empty($showAll)) {
            $query = $query->limit(config('app.order_limit'));
        }
        return $query->with('transaction')->withCount('items')->latest()->get();
    }

    public function getBySessionId($sessionId, $status = OrderStatus::PENDING)
    {
        return $this->findQuery($sessionId, $status)->latest()->first();
    }
    public function scopeGetOrder($query, $status = OrderStatus::PENDING){
        return $query->where('status', $status);
    }
    public function storeSheet()
    {

        $sheet = new Sheets();

        try {
            DB::beginTransaction();

            $sheets = $sheet->spreadsheet(config('sheet.spread_sheet_id'))->sheet(config('sheet.sheets_detail.order.athlete'))->get();

            $header = $sheets->pull(0);

            if (empty($header)) {
                $array = config('sheet.defaultHeader.order.athlete');
                $sheet->append([$array]);
            }
            $items = [];
            foreach ($this->items as $key => $item) {
                array_push($items, [
                    'sku' => $item->sku,
                    'variant' => $item->variant,
                    'quantity' => $item->quantity,
                    'preference' => $item->preference
                ]);
            }
            $sheet->append([
                [
                    'orderId' => $this->token,
                    'billingAddress' => $this->billing_address,
                    'customerName' => auth()->user()->full_name,
                    'customerEmail' => auth()->user()->email,
                    'items' => json_encode($items),
                    'status' => OrderStatus::PENDING,
                    'qrUrl' => getQRImageURL()
                ]
            ]);

            DB::commit();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            DB::rollback();
            throw $e;
        }
    }
    public function storeCoachSheet()
    {
        $sheet = new Sheets();
        try {
            DB::beginTransaction();
            $sheets = $sheet->spreadsheet(config('sheet.spread_sheet_id'))->sheet(config('sheet.sheets_detail.order.coach'))->get();
            $header = $sheets->pull(0);
            if (empty($header)) {
                $array = config('sheet.defaultHeader.order.coach');
                $sheet->append([$array]);
            }
            $teamId = auth()->user()->team->id ?? null;
            $variants = (new Variant())->fetchAgainstSize($teamId);
            $teamMembers = TeamMember::where('team_id', $teamId)->whereNotNull('athlete_id')->get();
            $items = [];
            $sizes = [];
            $members = [];
            foreach ($teamMembers as $key => $member) {
                array_push($members, [
                    'qr_image' => $member->qr_image_url,
                    'size' => $member->size->name,
                    'name' => $member->user->full_name,
                ]);
            }
            foreach ($variants as $key => $variant) {
                array_push($sizes, [
                    'name' => $variant->name,
                    'description' => $variant->description,
                    'count' => $variant->team_members_count,
                ]);
            }
            foreach ($this->items as $key => $item) {
                array_push($items, [
                    'sku' => $item->sku,
                    'quantity' => $item->quantity,
                    'title' => $item->product->title ?? '',
                ]);
            }
            $sheet->append([
                [
                    'orderId' => $this->token,
                    'billingAddress' => $this->billing_address,
                    'customerName' => auth()->user()->full_name,
                    'customerEmail' => auth()->user()->email,
                    'items' => json_encode($items),
                    'sizes' => json_encode($sizes),
                    'Members' => json_encode($members),
                    'status' => OrderStatus::PENDING
                ]
            ]);

            DB::commit();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            DB::rollback();
            throw $e;
        }
    }

}
