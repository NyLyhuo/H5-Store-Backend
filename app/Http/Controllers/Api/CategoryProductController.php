<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryProductController extends Controller
{
    public function index($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $products = $category->products()
            ->where('status', true)
            ->latest()
            ->paginate(12);

        return response()->json([
            'category' => $category,
            'products' => $products
        ]);
    }
}
