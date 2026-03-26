@extends('layouts.app')

@section('content')
    <h2 class="section-title">Корзина</h2>

    @if (session('success'))
        <div class="success-message">{{ session('success') }}</div>
    @endif

    @if (empty($cart))
        <p style="text-align: center; color: #777; font-size: 1.2rem; padding: 60px 0;">
            Корзина пуста. <a href="{{ route('home') }}">Вернуться к покупкам</a>
        </p>
    @else
        <div style="max-width: 800px; margin: 0 auto;">
            @foreach ($cart as $id => $item)
                <div style="border: 1px solid #eee; border-radius: 12px; padding: 16px; margin-bottom: 16px; display: flex; align-items: center; background: white; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                    @if ($item['image'])
                        <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}" style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px; margin-right: 20px;" />
                    @endif

                    <div style="flex: 1;">
                        <div style="font-weight: 600; font-size: 1.15rem;">{{ $item['name'] }}</div>
                        <div style="color: #555; margin: 4px 0;">Цена: {{ number_format($item['price'], 0, '', ' ') }} ₽</div>

                        <form action="{{ route('cart.update') }}" method="POST" style="display: inline-flex; align-items: center; margin-top: 8px;">
                            @csrf
                            <input type="hidden" name="id" value="{{ $id }}">
                            <label style="margin-right: 8px;">Количество:</label>
                            <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" style="width: 70px; padding: 6px; border: 1px solid #ddd; border-radius: 6px;" />
                            <button type="submit" style="margin-left: 12px; padding: 6px 12px; background: #000; color: white; border: none; border-radius: 6px; cursor: pointer;">Обновить</button>
                        </form>
                    </div>

                    <div style="text-align: right; min-width: 120px;">
                        <div style="font-weight: 700; font-size: 1.2rem; color: #000;">
                            {{ number_format($item['price'] * $item['quantity'], 0, '', ' ') }} ₽
                        </div>

                        <form action="{{ route('cart.remove') }}" method="POST" style="margin-top: 12px;">
                            @csrf
                            <input type="hidden" name="id" value="{{ $id }}">
                            <button type="submit" style="color: #c00; background: none; border: none; cursor: pointer; font-size: 0.95rem;">
                                Удалить
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach

            <div style="margin-top: 32px; text-align: right; font-size: 1.3rem; font-weight: 600;">
                Итого: 
                @php
                    $total = 0;
                    foreach ($cart as $item) {
                        $total += $item['price'] * $item['quantity'];
                    }
                    echo number_format($total, 0, '', ' ') . ' ₽';
                @endphp
            </div>

            <div style="text-align: center; margin-top: 40px;">
                <a href="{{ route('home') }}" style="padding: 14px 32px; background: #000; color: white; border-radius: 10px; text-decoration: none; font-weight: 500;">
                    Продолжить покупки
                </a>
                <!-- Пока без оформления — можно добавить позже -->
                <button disabled style="margin-left: 20px; padding: 14px 32px; background: #ccc; color: #666; border: none; border-radius: 10px; font-weight: 500;">
                    Оформить заказ (скоро)
                </button>
            </div>
        </div>
    @endif
@endsection