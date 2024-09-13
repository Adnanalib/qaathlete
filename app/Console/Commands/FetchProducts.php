<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Revolution\Google\Sheets\Sheets;

class FetchProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command fetches products from google sheet';

    /**
     * Execute the console command.
     *
     * @return int
     */
    private $sheets = null;
    private $sheetId = null;
    private $sheet_detail = null;
    private $category = null;
    private $product = null;

    public function __construct()
    {
        $this->category = new Category();
        $this->product = new Product();
        $this->sheets = new Sheets();
        $this->sheetId = config('sheet.spread_sheet_id');
        $this->sheet_detail = config('sheet.sheets_detail');
        parent::__construct();
    }
    public function handle()
    {
        try {
            DB::beginTransaction();

            $sheets = $this->sheets->spreadsheet($this->sheetId)->sheet($this->sheet_detail['product'])->get();

            $header = $sheets->pull(0);

            $products = $this->sheets->collection(header: $header, rows: $sheets);

            foreach($products as $product){
                $categoryId = $this->category->findOrCreate(data_get($product, 'category'));
                $product = $this->product->createOrUpdate($product, $categoryId);
                Log::debug("Product" . json_encode($product));
            }

            DB::commit();
        } catch (\Exception $e) {
            echo $e->getMessage();
            DB::rollback();
        }
    }
}
