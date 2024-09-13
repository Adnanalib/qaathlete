<?php

namespace App\Console\Commands;

use App\Enums\OrderStatus;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Revolution\Google\Sheets\Sheets;

class UpdateAthleteOrderStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:athlete-orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will update status of all orders from sheet.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    private $sheets = null;
    private $sheetId = null;
    private $sheet_detail = null;
    private $order = null;

    public function __construct()
    {
        $this->order = new Order();
        $this->sheets = new Sheets();
        $this->sheetId = config('sheet.spread_sheet_id');
        $this->sheet_detail = config('sheet.sheets_detail.order.athlete');
        parent::__construct();
    }
    public function handle()
    {
        try {
            DB::beginTransaction();

            $sheets = $this->sheets->spreadsheet($this->sheetId)->sheet($this->sheet_detail)->get();

            $header = $sheets->pull(0);

            $orders = $this->sheets->collection(header: $header, rows: $sheets);

            foreach($orders as $order){
                $orderId = data_get($order, config('sheet.defaultHeader.order.athlete')[0]);
                $status = data_get($order, 'status');
                $order = $this->order->where('token', $orderId)->has('user')->with('user')->latest()->first();
                if(!empty($order)){
                    if(in_array($status, OrderStatus::getValues())){
                        $order->status = $status;
                        $order->save();
                        $order->user->notifyOrderStatus();
                    }else{
                        Log::debug("Invalid order Status. OrderId: " . $orderId . " Status: " . $status);
                    }
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            echo $e->getMessage();
            DB::rollback();
        }
    }
}
