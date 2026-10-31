<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where('status', 'active')
            ->orderBy('category_name')
            ->get([
                'category_id',
                'category_name',
                'description'
            ]);

        return response()->json([
            'success' => true,
            'data' => $categories,
        ]);
    }
}