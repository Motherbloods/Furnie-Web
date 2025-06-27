<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;


class ProductController extends Controller
{
    // Tampilkan semua produk milik toko user yang login
    public function dashboardSeller()
    {
        $sellerId = Auth::id();

        // Get products from this seller
        $products = Product::where('seller_id', $sellerId)->get();

        // Get order items for products belonging to this seller with related data
        $orderItems = OrderItem::whereHas('product', function ($query) use ($sellerId) {
            $query->where('seller_id', $sellerId);
        })->with(['order.user', 'product'])->get();

        $orders = new EloquentCollection(
            $orderItems
                ->pluck('order')
                ->filter()
                ->unique('id')
                ->values()
        );

        // Sekarang kamu bisa pakai eager load
        $orders->load(['items.product', 'user']);
        $orderCounts = [
            'menunggu_konfirmasi' => $orders->where('order_status', 'menunggu_konfirmasi')->count(),
            'diproses' => $orders->where('order_status', 'diproses')->count(),
            'dikirim' => $orders->where('order_status', 'dikirim')->count(),
            'selesai' => $orders->where('order_status', 'selesai')->count(),
            'dibatalkan' => $orders->where('order_status', 'dibatalkan')->count(),
        ];

        return view('dashboard-seller', compact('products', 'orders', 'orderItems', 'orderCounts'));
    }


    public function index(Request $request)
    {
        $kategori = $request->query('category');
        $query = $request->query('query');

        // Ambil semua kategori
        $categories = Category::all();

        // Build query untuk produk
        $productsQuery = Product::latest();

        // Filter berdasarkan kategori jika ada
        if ($kategori) {
            $productsQuery->where('kategori', $kategori);
        }

        // Filter berdasarkan search query jika ada
        if ($query) {
            $productsQuery->where(function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')
                    ->orWhere('description', 'like', '%' . $query . '%');
            });
        }

        // Ambil produk dengan limit
        $products = $productsQuery
            ->limit($request->ajax() ? 20 : 9)
            ->get();

        // Jika request via AJAX (atau pakai ?json=true), kembalikan sebagai JSON
        if ($request->ajax() || $request->query('json')) {
            return response()->json([
                'success' => true,
                'products' => $products,
                'category' => $kategori,
                'query' => $query,
                'hasMore' => $products->count() >= ($request->ajax() ? 20 : 9), // Simple check
                'currentPage' => 1,
                'total' => $productsQuery->count()
            ]);
        }

        // Jika bukan AJAX, tampilkan view seperti biasa
        return view('layouts.dashboard', compact('products', 'categories'));
    }



    // Tampilkan form tambah produk
    public function create()
    {
        return view('products.create');
    }

    // Simpan produk baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'kategori' => 'required|in:meja,kursi,lemari,kasur,sofa,rak,dekorasi',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'status' => 'required|in:aktif,non-aktif',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();
        $data['seller_id'] = Auth::id();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    // Tampilkan detail produk
    public function show($id)
    {
        $product = Product::findOrFail($id); // pastikan produk ditemukan atau gagal dengan 404
        $relatedProducts = Product::where('kategori', $product->kategori)
            ->where('id', '!=', $product->id)
            ->limit(3)
            ->get();


        return view('product.product-detail', compact('product', 'relatedProducts'));
    }


    // Tampilkan form edit produk
    public function edit(Product $product)
    {
        $this->authorizeProduct($product);
        return view('products.edit', compact('product'));
    }

    // Update data produk
    public function update(Request $request, Product $product)
    {
        $this->authorizeProduct($product);

        $request->validate([
            'name' => 'required|string|max:255',
            'kategori' => 'required|in:meja,kursi,lemari,kasur,sofa,rak,dekorasi',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'status' => 'required|in:aktif,non-aktif',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    // Hapus produk
    public function destroy(Product $product)
    {
        $this->authorizeProduct($product);

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }

    // Pastikan hanya pemilik toko yang bisa mengakses produk
    private function authorizeProduct(Product $product)
    {
        if ($product->seller_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke produk ini.');
        }
    }

    public function getProductsByCategory(Request $request)
    {
        $kategori = $request->query('category');
        $query = $request->query('query');

        $products = Product::latest()
            ->when($kategori, function ($query) use ($kategori) {
                return $query->where('kategori', $kategori);
            })
            ->when($query, function ($queryBuilder) use ($query) {
                return $queryBuilder->where('name', 'like', '%' . $query . '%');
            })
            ->limit(20)
            ->get();

        return response()->json([
            'success' => true,
            'products' => $products,
            'category' => $kategori
        ]);
    }
}
