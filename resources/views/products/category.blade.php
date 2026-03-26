@php
    use App\Models\Product;
@endphp

@extends('layouts.app')

@section('content')


    <section class="catalog-section">
        <div class="container">
            <h2 class="section-title">Товары в категории «{{ $category }}»</h2>

            <!-- Фильтры внутри категории -->
            <div class="filters">
                <form method="GET" class="search-form">
                    <input type="text" name="search" placeholder="Поиск внутри категории..." value="{{ request('search') }}">
                    <button type="submit">Найти</button>
                </form>

                <form method="GET" class="sort-filter">
                    <select name="sort" onchange="this.form.submit()">
                        <option value="newest" {{ request('sort', 'newest') == 'newest' ? 'selected' : '' }}>Сначала новые</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Дешевле → дороже</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Дороже → дешевле</option>
                    </select>
                </form>
            </div>

            <div class="product-grid">
                @forelse ($products as $product)
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
                    <p style="text-align:center; grid-column:1/-1; padding:80px 0; color:#777; font-size:1.3rem;">
                        В категории «{{ $category }}» пока нет товаров
                    </p>
                @endforelse
            </div>

            <div class="pagination">
                {{ $products->links() }}
            </div>
        </div>
    </section>

@endsection