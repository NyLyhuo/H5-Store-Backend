<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class CategoryController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => Category::latest()->get()
        ]);
    }

    public function show(string $slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        return response()->json([
            'data' => $category
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug',
        ]);

        $slug = $validated['slug'] ?? Str::slug($validated['name']);
        $base = $slug;
        $i = 1;
        while (Category::where('slug', $slug)->exists()) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        $category = Category::create([
            'name' => $validated['name'],
            'slug' => $slug,
        ]);

        return response()->json([
            'message' => 'Category created successfully',
            'data' => $category,
        ], 201);
    }
}
