<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::get();
        return response()->json(['response' => 101, 'message' => null, 'data' => ['products' => $products]]);

    }

    public function categories()
    {
        $categories = Category::get();
        return response()->json(['response' => 101, 'message' => null, 'data' => ['categories' => $categories]]);
    }
}
