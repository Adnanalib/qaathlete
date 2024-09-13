<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends BaseModel
{
    use HasFactory;

    public function category()
    {
        return $this->belongsTo(Category::class, "category_id", "id");
    }
    public function createOrUpdate($product, $categoryId){
        $uuid = data_get($product, 'uuid');
        if(empty($uuid)){
            return null;
        }
        $productModal = $this->where('uuid', $uuid)->latest()->first();
        if(empty($productModal)){
            $productModal = new Product();
        }
        $productModal->uuid = $uuid;
        $productModal->category_id = $categoryId;
        $productModal->title = data_get($product, 'title');
        $productModal->description = data_get($product, 'description');
        $productModal->price = floatval(data_get($product, 'price', 0));
        $productModal->discount = floatval(data_get($product, 'discount', 0));
        $productModal->currency = data_get($product, 'currency', '$');
        $productModal->cover_photo = data_get($product, 'cover_photo');
        $productModal->images = data_get($product, 'images');
        $productModal->save();
        return $productModal;
    }
    public static function fetchProducts(){
        return self::has('category')->with('category')->get()->groupBy('category.name');
    }
    public static function fetchOtherProducts($category_id, $excludeProductId = null){
       $products = self::where('category_id',$category_id);
        if(!empty($excludeProductId)){
            $products = $products->whereNot('id',$excludeProductId);
        }
        return $products->latest()->get();
    }
    public function getImageArray(){
        try {
            return json_decode($this->images);
        } catch (\Exception $e) {
            return [];
        }
    }
    public function getPrice(){
        return $this->price;
    }
}
