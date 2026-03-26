@php
    use App\Models\Product;
@endphp

@extends('layouts.app')

@section('content')

    <!-- Hero -->
    <section class="hero">
        <div class="hero-content">
            <h1>ОСНОВА</h1>
            <p>Женская одежда — стиль, комфорт, любовь</p>
            <a href="#categories" class="hero-btn">Выбрать свой стиль ↓</a>
        </div>
    </section>

    <!-- Секция категорий -->
    <section id="categories" class="categories-section">
        <div class="container">
            <h2 class="section-title">Выберите категорию</h2>

            <div class="category-grid">
                @forelse ($categories as $category)
                    <a href="{{ route('category.show', $category) }}" class="category-card">
                        @php
                            $catProduct = Product::where('category', $category)->first();
                            $catImage = $catProduct && $catProduct->image 
                                ? $catProduct->image 
                                : 'https://via.placeholder.com/400x500?text=' . urlencode($category);
                        @endphp

                        <div class="category-image">
                            <img src="{{ asset($catImage) }}" alt="{{ $category }}" loading="lazy">
                        </div>
                        <div class="category-overlay">
                            <h3>{{ $category }}</h3>
                            <span>Смотреть →</span>
                        </div>
                    </a>
                @empty
                    <p style="text-align:center; grid-column:1/-1; padding:80px 0; color:#777; font-size:1.2rem;">
                        Пока нет категорий. Добавьте товары в админке!
                    </p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Новинки -->
    <section class="featured-section">
        <div class="container">
            <h2 class="section-title">Новинки</h2>

            <div class="product-grid">
                @forelse ($featuredProducts as $product)
                <a href="{{ route('product.show', $product) }}" class="product-card-link" style="text-decoration: none; color: inherit; display: block;">   
                <div class="product-card">
                        <div class="product-image-wrapper">
@if ($product->images->isNotEmpty())
    <img src="{{ asset($product->images->first()->image_path) }}" alt="{{ $product->name }}" loading="lazy">
@elseif ($product->image)
    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" loading="lazy">
@else
    <div class="no-image">Фото скоро</div>
@endif

                            <div class="product-overlay">
                                <div class="overlay-content">
                                    <div class="product-name-overlay">{{ $product->name }}</div>
                                    <div class="product-price-overlay">{{ number_format($product->price, 0, '', ' ') }} ₽</div>
                                </div>
                            </div>
                        </div>

                        <div class="product-info">
                            <div class="product-name">{{ $product->name }}</div>
                            <div class="product-price">{{ number_format($product->price, 0, '', ' ') }} ₽</div>

                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="add-to-cart-btn">В корзину</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p style="text-align:center; grid-column:1/-1; padding:80px 0; color:#777;">
                        Новинок пока нет
                    </p>
                @endforelse
            </div>
        </div>
    </section>

@endsection