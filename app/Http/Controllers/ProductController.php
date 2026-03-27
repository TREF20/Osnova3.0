<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    // Главная страница / каталог
public function index(Request $request)
{
    $query = Product::query();

    if ($search = $request->query('search')) {
        $query->where('name', 'like', '%' . trim($search) . '%');
    }

    $category = $request->query('category');
    if ($category) {
        $trimmed = trim($category);
        $query->whereRaw('TRIM(LOWER(category)) = ?', [strtolower($trimmed)]);
    }

    $sort = $request->query('sort', 'newest');
    if ($sort === 'price_asc') {
        $query->orderBy('price', 'asc');
    } elseif ($sort === 'price_desc') {
        $query->orderBy('price', 'desc');
    } else {
        $query->latest();
    }

    // Добавляем with('images') — ВАЖНО!
    $products = $query->with('images')->paginate(12)->appends($request->query());

    $categories = Product::whereNotNull('category')
        ->distinct()
        ->pluck('category')
        ->sort()
        ->values();

    // Также для новинок
    $featuredProducts = Product::with('images')->latest()->take(6)->get();

    return view('products.index', compact('products', 'categories', 'featuredProducts'));
}

    // Страница категории
public function category(Request $request, $slug)
{
    $category = urldecode($slug);

    $query = Product::whereRaw('TRIM(LOWER(category)) = ?', [strtolower(trim($category))]);

    if ($search = $request->query('search')) {
        $query->where('name', 'like', '%' . trim($search) . '%');
    }

    $sort = $request->query('sort', 'newest');
    if ($sort === 'price_asc') {
        $query->orderBy('price', 'asc');
    } elseif ($sort === 'price_desc') {
        $query->orderBy('price', 'desc');
    } else {
        $query->latest();
    }

    // ВАЖНО: подгружаем все фото
    $products = $query->with('images')->paginate(12)->appends($request->query());

    return view('products.category', compact('products', 'category'));
}

    // Страница одного товара — ВНУТРИ КЛАССА!
    public function show(Product $product)
    {
        $product->load('images'); // загружаем все фото
        return view('products.show', compact('product'));
    }

    // Корзина
    public function cart()
    {
        $cart = Session::get('cart', []);
        return view('cart', compact('cart'));
    }

    // Добавить в корзину
    public function addToCart(Request $request, $id)
    {
        $product = Product::with('images')->findOrFail($id);

        $cart = Session::get('cart', []);

        $mainImage = $product->images->first() ? $product->images->first()->image_path : null;

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'name'     => $product->name,
                'price'    => $product->price,
                'quantity' => 1,
                'image'    => $mainImage,
            ];
        }

        Session::put('cart', $cart);

        return redirect()->back()->with('success', 'Товар добавлен в корзину!');
    }

    // Обновить количество
    public function updateCart(Request $request)
    {
        $request->validate([
            'id'       => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Session::get('cart', []);

        if (isset($cart[$request->id])) {
            $cart[$request->id]['quantity'] = $request->quantity;
            Session::put('cart', $cart);
        }

        return redirect()->route('cart')->with('success', 'Количество обновлено');
    }

    // Удалить из корзины
    public function removeFromCart(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:products,id',
        ]);

        $cart = Session::get('cart', []);

        if (isset($cart[$request->id])) {
            unset($cart[$request->id]);
            Session::put('cart', $cart);
        }

        return redirect()->route('cart')->with('success', 'Товар удалён из корзины');
    }

    // Админ: список товаров
 public function adminIndex()
{
    // Добавляем with('images') — ВАЖНО!
    $products = Product::with('images')->get();
    return view('admin.products.index', compact('products'));
}

    public function create()
    {
        return view('admin.products.create');
    }

public function store(Request $request)
{
    $request->validate([
        'name'        => 'required|string|max:255',
        'description' => 'required|string',
        'price'       => 'required|numeric|min:0',
        'category'    => 'nullable|string|max:100',
        'images.*'    => 'image|max:2048',
    ]);

    $product = Product::create($request->only(['name', 'description', 'price', 'category']));

    // Добавляем новые фото (если есть)
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $index => $image) {
            $path = $image->store('products', 'public');
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => 'storage/' . $path,
                'is_main'    => $index === 0 && $product->images()->count() === 0, // главное только если фото ещё нет
            ]);
        }
    }

    return redirect()->route('admin.products.index')->with('success', 'Товар добавлен!');
}

    public function edit(Product $product)
    {
        $product->load('images');
        return view('admin.products.edit', compact('product'));
    }

 public function update(Request $request, Product $product)
{
    $request->validate([
        'name'        => 'required|string|max:255',
        'description' => 'required|string',
        'price'       => 'required|numeric|min:0',
        'category'    => 'nullable|string|max:100',
        'images.*'    => 'image|max:2048',
    ]);

    $product->update($request->only(['name', 'description', 'price', 'category']));

    // Добавляем новые фото, НЕ удаляя старые
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $index => $image) {
            $path = $image->store('products', 'public');
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => 'storage/' . $path,
                'is_main'    => $index === 0 && $product->images()->where('is_main', true)->doesntExist(),
            ]);
        }
    }

    return redirect()->route('admin.products.index')->with('success', 'Товар обновлён!');
}

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Товар удалён!');
    }

    public function info()
    {
        return view('info');
    }

    public function destroyImage(ProductImage $productImage)
{
    // Удаляем файл с диска (опционально, но полезно)
    if (file_exists(public_path($productImage->image_path))) {
        unlink(public_path($productImage->image_path));
    }

    $productImage->delete();

    return redirect()->back()->with('success', 'Фото удалено!');
}
}

