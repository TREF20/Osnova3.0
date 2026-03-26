@extends('layouts.app')

@section('content')
    <h2 class="section-title" style="margin-bottom: 40px;">Админ-панель: Товары</h2>

    @if (session('success'))
        <div class="success-message" style="margin-bottom: 30px;">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.products.create') }}" class="btn-submit" style="display: inline-block; margin-bottom: 32px; text-decoration: none; text-align: center; padding: 12px 24px; font-size: 1.1rem;">
        + Добавить новый товар
    </a>

    <div class="product-grid">
        @forelse ($products as $product)
            <div class="product-card">
                <!-- Фото товара -->
                @if ($product->images->isNotEmpty())
                    <img src="{{ asset($product->images->first()->image_path) }}" alt="{{ $product->name }}" style="width:100%; height:240px; object-fit:cover; border-radius: 12px 12px 0 0;" />
                @elseif ($product->image)
                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" style="width:100%; height:240px; object-fit:cover; border-radius: 12px 12px 0 0;" />
                @else
                    <div class="product-placeholder" style="height:240px; background:#f8f0e8; display:flex; align-items:center; justify-content:center; color:#aaa; font-size:1.1rem; border-radius: 12px 12px 0 0;">
                        Нет фото
                    </div>
                @endif

                <div class="product-info" style="padding: 20px; text-align: center;">
                    <div class="product-name" style="font-size: 1.3rem; font-weight: 600; margin-bottom: 8px;">{{ $product->name }}</div>
                    <div class="product-price" style="font-size: 1.4rem; font-weight: 700; color: #d47a8f; margin-bottom: 16px;">
                        {{ number_format($product->price, 0, '', ' ') }} ₽
                    </div>

                    <div style="display: flex; gap: 12px; justify-content: center;">
                        <a href="{{ route('admin.products.edit', $product) }}" style="padding: 10px 20px; background: #0066cc; color: white; border-radius: 8px; text-decoration: none; font-size: 0.95rem;">
                            Редактировать
                        </a>

                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Удалить товар навсегда?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="padding: 10px 20px; background: #cc0000; color: white; border: none; border-radius: 8px; cursor: pointer; font-size: 0.95rem;">
                                Удалить
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p style="grid-column: 1 / -1; text-align: center; color: #777; padding: 80px 0; font-size: 1.3rem;">
                Товаров пока нет. Добавьте первый!
            </p>
        @endforelse
    </div>
@endsection