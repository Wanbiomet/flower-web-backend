<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\FlowerType;
use App\Models\Occasions;

class Products extends Model
{
    use HasFactory;
    protected $table = "products";
    protected $fillable = [
        'occasion_id',
        'flowertype_id',
        'product_name',
        'product_img',
        'product_price',
        'product_design',
        'product_status'
    ];
    public function occasion()
    {
        return $this->belongsTo(Occasions::class,'occasion_id')->withDefault();
    }
    public function flowertype()
    {
        return $this->belongsTo(FlowerType::class,'flowertype_id')->withDefault();
    }
}
