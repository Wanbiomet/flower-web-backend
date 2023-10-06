<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index() {
        
        return response()->json(Products::with(['flowertypes','occasions'])->get());
    }

    public function search(Request $req) {
        $product_query =  Products::with(['flowertype','occasion']);
        // if($req->input('search')){
        //     $product_query = Products::where('product_name','LIKE','%'.$req->keyword.'%');
        // }


        $products = $product_query->get();
        return response()->json([
            'message' => 'fetch data successful',
            'data' => $products
        ],200);
    }
}
