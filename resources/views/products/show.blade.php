@extends('layouts.app')

@section('content')
    <section class="product-show-section">
        <div class="container">
            <div class="product-show-card">
                <div class="row g-0">
                    <!-- Галерея фото слева -->
                    <div class="col-lg-6">
                        <div class="product-gallery" id="gallery">
                            @if ($product->images->isNotEmpty())
                                @foreach ($product->images as $index => $image)
                                    <img src="{{ asset($image->image_path) }}" alt="{{ $product->name }} - фото {{ $index + 1 }}"
                                         class="gallery-slide {{ $index === 0 ? 'active' : '' }}"
                                         style="width: 100%; height: 100%; object-fit: contain; object-position: center;">
                                @endforeach
                            @else
                                <div class="no-image-placeholder">
                                    Фото скоро появится
                                </div>
                            @endif
                        </div>

                        <!-- Миниатюры (если больше 1 фото) -->
                        @if ($product->images->count() > 1)
                            <div class="gallery-thumbs">
                                @foreach ($product->images as $index => $image)
                                    <div class="thumb-item {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}">
                                        <img src="{{ asset($image->image_path) }}" alt="Мини {{ $index + 1 }}">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Правая часть: информация -->
                    <div class="col-lg-6">
                        <div class="product-info">
                            <h1 class="product-title">{{ $product->name }}</h1>

                            <div class="product-price">
                                {{ number_format($product->price, 0, '', ' ') }} ₽
                            </div>

                            <p class="product-description">
                                {{ $product->description ?? 'Описание товара скоро появится. Это комфортная и стильная вещь для твоего гардероба.' }}
                            </p>

                            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="add-to-cart-form">
                                @csrf
                                <button type="submit" class="add-to-cart-btn">
                                    Добавить в корзину
                                </button>
                            </form>

                            <a href="{{ url()->previous() }}" class="back-link">
                                ← Вернуться назад
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection