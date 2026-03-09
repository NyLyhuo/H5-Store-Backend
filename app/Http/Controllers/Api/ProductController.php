<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')
            ->where('status', true)
            ->latest()
            ->paginate(12);

        return response()->json([
            'data' => $products
        ]);
    }

    public function show($slug)
    {
        $product = Product::with('category')
            ->where('slug', $slug)
            ->where('status', true)
            ->firstOrFail();

        return response()->json([
            'data' => $product
        ]);
    }
}
