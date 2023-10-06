<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Products;

class FlowerType extends Model
{
    use HasFactory;
    protected $table = "flowertype";
    protected $primaryKey = 'flowertype_id';
    protected $fillable = [
        'flowertype_name',
    ];
    public $timestamps = true; // Sử dụng thời gian tạo và cập nhật
    public function products(){
        return $this->hasMany(Products::class, 'flowertype_id', 'flowertype_id');
    }
}
