<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Facades\Storage;

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


    public function createProduct()
    {
        // Ambil semua kategori untuk dropdown
        $categories = Category::all();

        return view('product.product-create', compact('categories'));
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'kategori' => 'required|string',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:5120',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:5120',
        ]);

        // Handle image uploads
        $imagePath = $request->file('image')->store('products', 'public');

        $additionalImages = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $additionalImages[] = $image->store('products', 'public');
            }
        }

        // Prepare specifications and features
        $specifications = [];
        if ($request->has('specifications')) {
            foreach ($request->specifications as $spec) {
                if (!empty($spec['key']) && !empty($spec['value'])) {
                    $specifications[$spec['key']] = $spec['value'];
                }
            }
        }

        $features = array_filter($request->features ?? []);

        Product::create([
            'seller_id' => Auth::user()->seller->user_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'original_price' => $request->original_price,
            'discount' => $request->discount,
            'stock' => $request->stock,
            'kategori' => $request->kategori,
            'status' => $request->status ?? 'aktif',
            'image' => $imagePath,
            'images' => $additionalImages,
            'specifications' => $specifications,
            'features' => $features,
        ]);

        return redirect()->route('seller.dashboard')->with('success', 'Produk berhasil ditambahkan!');
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
            ->limit($request->ajax() ? 12 : 9)
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

        return redirect()->route('seller.dashboard')->with('success', 'Produk berhasil ditambahkan.');
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
        // Pastikan produk milik seller yang sedang login
        if ($product->seller_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $categories = Category::all();

        return view('product.product-edit', compact('product', 'categories'));
    }

    // Update data produk
    public function update(Request $request, Product $product)
    {
        // Pastikan produk milik seller yang sedang login
        if ($product->seller_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:aktif,non-aktif',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240', // 10MB max
        ], [
            'name.required' => 'Nama produk wajib diisi.',
            'name.max' => 'Nama produk maksimal 255 karakter.',
            'description.required' => 'Deskripsi produk wajib diisi.',
            'price.required' => 'Harga produk wajib diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            'price.min' => 'Harga tidak boleh kurang dari 0.',
            'stock.required' => 'Stok produk wajib diisi.',
            'stock.integer' => 'Stok harus berupa angka bulat.',
            'stock.min' => 'Stok tidak boleh kurang dari 0.',
            'category_id.required' => 'Kategori produk wajib dipilih.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'status.required' => 'Status produk wajib dipilih.',
            'status.in' => 'Status produk tidak valid.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif.',
            'image.max' => 'Ukuran gambar maksimal 10MB.',
        ]);

        // Handle upload gambar baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            // Upload gambar baru
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = Storage::url($imagePath);
        }

        // Update produk
        $product->update($validated);

        return redirect()
            ->route('seller.products')
            ->with('success', 'Produk berhasil diperbarui!');
    }


    // Hapus produk
    public function destroy(Product $product)
    {
        $this->authorizeProduct($product);

        $product->delete();

        return redirect()->route('seller.dashboard')->with('success', 'Produk berhasil dihapus.');
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
