<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Product;
use App\Models\Category;

class SearchProduk extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');
        $category = $request->input('category');
        $page = $request->input('page', 1);
        $perPage = 12;

        Log::info('Data pencarian produk:', [
            'query' => $query,
            'category' => $category,
            'page' => $page,
        ]);

        // Ambil semua kategori untuk filter
        $categories = Category::all();

        // Build query untuk pencarian produk
        $productsQuery = Product::query();

        // Filter berdasarkan search query
        if ($query) {
            $productsQuery->where(function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')
                    ->orWhere('description', 'like', '%' . $query . '%');
            });
        }

        // Filter berdasarkan kategori
        if ($category) {
            $productsQuery->where('kategori', $category);
        }

        // Hitung total produk untuk pagination
        $totalProducts = $productsQuery->count();

        // Ambil produk dengan pagination
        $products = $productsQuery
            ->latest()
            ->skip(($page - 1) * $perPage)
            ->take($perPage)
            ->get();

        // Hitung apakah masih ada halaman selanjutnya
        $hasMore = ($page * $perPage) < $totalProducts;
        $showing = min($page * $perPage, $totalProducts);

        // Jika request AJAX, return JSON response
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'hasMore' => $hasMore,
                'total' => $totalProducts,
                'products' => $products,
                'showing' => $showing,
                'currentPage' => $page,
                'query' => $query,
                'category' => $category
            ]);
        }

        // Jika bukan AJAX, redirect ke dashboard dengan parameter
        $params = [];
        if ($query) {
            $params['query'] = $query;
        }
        if ($category) {
            $params['category'] = $category;
        }

        return redirect()->route('layouts.dashboard', $params);
    }
}