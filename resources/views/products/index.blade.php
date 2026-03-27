@extends('layouts.app')

@section('content')
<!-- Hero -->
<section class="hero" style="height: 85vh; min-height: 620px; position: relative; display: flex; align-items: center; justify-content: center; overflow: hidden;">
    
    <!-- Мягкий тёплый градиент на весь hero -->
    <div style="position: absolute; inset: 0; 
                background: linear-gradient(135deg, 
                    #f9f4ed 0%, 
                    #f4ede4 35%, 
                    #e8d9cc 65%, 
                    #d9c2b0 100%);">
    </div>

    <!-- Лёгкий розовый акцент -->
    <div style="position: absolute; inset: 0; 
                background: linear-gradient(to bottom, 
                    rgba(212, 122, 143, 0.16) 0%, 
                    rgba(212, 122, 143, 0.05) 60%, 
                    transparent 100%);">
    </div>

    <div class="hero-content" style="position: relative; z-index: 2; text-align: center; color: #2c1f1a; max-width: 820px; padding: 0 20px;">
        <h1 style="font-size: 5.1rem; font-weight: 700; margin-bottom: 20px; letter-spacing: -2px; color: #2c1f1a;">
            ОСНОВА
        </h1>
        
        <p style="font-size: 1.72rem; margin-bottom: 50px; color: #4a372f; line-height: 1.45;">
            Женская одежда, в которой хочется жить каждый день
        </p>

        <a href="#categories" 
           class="hero-btn" 
           style="display: inline-block; 
                  padding: 18px 54px; 
                  background: #d47a8f; 
                  color: white; 
                  font-size: 1.25rem; 
                  font-weight: 600; 
                  border-radius: 60px; 
                  text-decoration: none; 
                  box-shadow: 0 12px 35px rgba(212, 122, 143, 0.28);
                  transition: all 0.4s ease;">
            Выбрать свой стиль ↓
        </a>
    </div>
</section>

    <!-- Секция категорий -->
<!-- Секция категорий -->
<section id="categories" class="categories-section" style="padding: 100px 0; background: transparent;">
    <div class="container">
        <h2 class="section-title" style="text-align: center; margin-bottom: 60px; font-size: 2.8rem;">Выберите категорию</h2>

        <div class="category-grid">
            @foreach ($categories as $cat)
                <a href="{{ route('category.show', urlencode($cat)) }}" class="category-card">
                    @php
                        $catProduct = \App\Models\Product::where('category', $cat)->first();
                        $catImage = $catProduct && $catProduct->images->isNotEmpty() 
                            ? $catProduct->images->first()->image_path 
                            : ($catProduct->image ?? 'https://avatars.mds.yandex.net/i?id=b5e602003f728068a6bbf9cf345dee1f_l-7930431-images-thumbs&n=13' . urlencode($cat));
                    @endphp
                    <div class="category-image">
                        <img src="{{ asset($catImage) }}" alt="{{ $cat }}" style="width:100%; height:100%; object-fit: cover;">
                    </div>
                    <div class="category-overlay">
                        <h3>{{ $cat }}</h3>
                        <span>Смотреть →</span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Новинки -->
<section class="featured-section" style="padding: 100px 0; background: transparent;">
    <div class="container">
        <h2 class="section-title" style="text-align: center; margin-bottom: 60px; font-size: 2.8rem;">Новинки</h2>

        <div class="product-grid">
            @forelse ($featuredProducts as $product)
                <div class="product-card" style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.08); display: flex; flex-direction: column; height: 100%;">

                    <!-- Фото товара + ссылка на полный просмотр -->
                    <a href="{{ route('product.show', $product->id) }}" style="text-decoration: none; color: inherit;">
                        <div style="height: 380px; background: #f8f0e8; position: relative;">
                            @if ($product->images->isNotEmpty())
                                <img src="{{ asset($product->images->first()->image_path) }}" 
                                     alt="{{ $product->name }}" 
                                     style="width:100%; height:100%; object-fit: contain; object-position: center;">
                            @elseif ($product->image)
                                <img src="{{ asset($product->image) }}" 
                                     alt="{{ $product->name }}" 
                                     style="width:100%; height:100%; object-fit: contain; object-position: center;">
                            @else
                                <div style="height:100%; display:flex; align-items:center; justify-content:center; color:#aaa; font-size:1.3rem;">
                                    Фото скоро
                                </div>
                            @endif
                        </div>
                    </a>

                    <!-- Информация под фото -->
                    <div class="product-info" style="padding: 24px 20px; flex-grow: 1; display: flex; flex-direction: column;">
                        <div class="product-name" style="font-size: 1.35rem; font-weight: 600; margin-bottom: 8px; flex-grow: 1;">
                            {{ $product->name }}
                        </div>
                        
                        <div class="product-price" style="font-size: 1.55rem; font-weight: 700; color: #d47a8f; margin-bottom: 20px;">
                            {{ number_format($product->price, 0, '', ' ') }} ₽
                        </div>

                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="add-to-cart-btn" style="width: 100%; padding: 14px; font-size: 1.05rem; margin-top: auto;">
                                В корзину
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p style="grid-column: 1/-1; text-align: center; padding: 80px 0; color: #777;">Новинок пока нет</p>
            @endforelse
        </div>
    </div>
</section>
@endsection