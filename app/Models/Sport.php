<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sport extends BaseModel
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name'
    ];

    public function findOrCreate($name)
    {
        if (empty($name)) {
            return null;
        }
        $category = $this->where('name', $name)->first();
        if (!empty($category)) {
            return $category->id;
        }
        $category = new Sport();
        $category->name = $name;
        $category->save();
        return $category->id;
    }
}
