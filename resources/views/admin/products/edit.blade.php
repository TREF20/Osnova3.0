@extends('layouts.app')

@section('content')
    <div class="auth-form-container" style="max-width: 900px; margin: 80px auto;">
        <h2 style="text-align: center; margin-bottom: 40px; color: #2c1f1a;">Редактировать товар: {{ $product->name }}</h2>

        <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Название</label>
                <input id="name" type="text" name="name" value="{{ old('name', $product->name) }}" required />
                @error('name') <span style="color:#c00;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="description">Описание</label>
                <textarea name="description" rows="5" required>{{ old('description', $product->description) }}</textarea>
                @error('description') <span style="color:#c00;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="category">Категория</label>
                <select name="category" id="category">
                    <option value="">Выберите категорию</option>
                    <option value="Рубашки" {{ old('category', $product->category) == 'Рубашки' ? 'selected' : '' }}>Рубашки</option>
                    <option value="Футболки" {{ old('category', $product->category) == 'Футболки' ? 'selected' : '' }}>Футболки</option>
                    <option value="Лонгсливы" {{ old('category', $product->category) == 'Лонгсливы' ? 'selected' : '' }}>Лонгсливы</option>
                    <option value="Джинсы" {{ old('category', $product->category) == 'Джинсы' ? 'selected' : '' }}>Джинсы</option>
                    <option value="Брюки" {{ old('category', $product->category) == 'Брюки' ? 'selected' : '' }}>Брюки</option>
                    <option value="Спортивный костюм" {{ old('category', $product->category) == 'Спортивный костюм' ? 'selected' : '' }}>Спортивный костюм</option>
                </select>
                @error('category') <span style="color:#c00;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="price">Цена (₽)</label>
                <input id="price" type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" required />
                @error('price') <span style="color:#c00;">{{ $message }}</span> @enderror
            </div>

            <!-- Все текущие фото с возможностью удаления -->
            <div class="form-group">
                <label>Текущие фото товара</label>
                @if ($product->images->isNotEmpty())
                    <div style="display: flex; flex-wrap: wrap; gap: 16px; margin: 20px 0;">
                        @foreach ($product->images as $image)
                            <div style="position: relative; width: 160px; height: 160px; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
                                <img src="{{ asset($image->image_path) }}" alt="Фото" style="width: 100%; height: 100%; object-fit: cover;">
                                
                                <!-- Кнопка удаления отдельного фото -->
                                <form action="{{ route('admin.product-images.destroy', $image->id) }}" method="POST" style="position: absolute; top: 8px; right: 8px;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Удалить это фото?')" 
                                            style="background: #ff4444; color: white; border: none; border-radius: 50%; width: 28px; height: 28px; cursor: pointer; font-size: 1rem; line-height: 28px; box-shadow: 0 2px 6px rgba(0,0,0,0.2);">
                                        ×
                                    </button>
                                </form>

                                @if ($image->is_main)
                                    <span style="position: absolute; bottom: 8px; left: 8px; background: #d47a8f; color: white; padding: 4px 10px; border-radius: 12px; font-size: 0.75rem; font-weight: 600;">
                                        Главное
                                    </span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <p style="color: #777; margin: 20px 0;">Нет загруженных фото. Добавьте новые ниже.</p>
                @endif
            </div>

            <!-- Старое одиночное фото (если ещё используется) -->
            @if ($product->image)
                <div class="form-group">
                    <label>Старое главное фото (из старого поля)</label>
                    <img src="{{ asset($product->image) }}" alt="Старое" style="max-width: 200px; border-radius: 12px; display: block; margin: 10px 0;" />
                </div>
            @endif

            <!-- Поле для новых фото (добавляются к существующим) -->
            <div class="form-group">
                <label for="images">Добавить новые фото (к существующим)</label>
                <input type="file" name="images[]" id="images" multiple accept="image/*" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px;" />
                @error('images.*')
                    <span style="color:#c00; display: block; margin-top: 6px;">{{ $message }}</span>
                @enderror
                <small style="color: #777; display: block; margin-top: 8px;">Выберите несколько файлов сразу. Старые фото останутся.</small>
            </div>

            <button type="submit" class="btn-submit" style="width: 100%; margin-top: 30px; padding: 16px; font-size: 1.1rem;">
                Сохранить изменения
            </button>
        </form>
    </div>
@endsection