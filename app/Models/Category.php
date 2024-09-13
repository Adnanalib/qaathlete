<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends BaseModel
{
    use HasFactory;

    public function findOrCreate($name){
        if(empty($name)){
            return null;
        }
        $category = $this->where('name', $name)->first();
        if(!empty($category)){
            return $category->id;
        }
        $category = new Category();
        $category->name = $name;
        $category->save();
        return $category->id;
    }

}
