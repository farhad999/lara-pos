<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        if (!empty($this->image)) {
            $image_url = asset('/images/' . rawurlencode($this->image));
        } else {
            $image_url = asset('/images/default/no-image.png');
        }
        return $image_url;
    }

    function brand(){
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }

    function unit(){
        return $this->belongsTo(Unit::class, 'unit_id');
    }

}
