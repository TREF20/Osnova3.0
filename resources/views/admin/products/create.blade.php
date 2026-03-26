@extends('layouts.app')

@section('content')
    <div class="auth-form-container" style="max-width: 900px; margin: 80px auto;">
        <h2 style="text-align: center; margin-bottom: 40px; color: #2c1f1a;">Добавить новый товар</h2>

        <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="name">Название</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required />
                @error('name') <span style="color:#c00;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="description">Описание</label>
                <textarea name="description" rows="5" required>{{ old('description') }}</textarea>
                @error('description') <span style="color:#c00;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="category">Категория</label>
                <select name="category" id="category" required>
                    <option value="">Выберите категорию</option>
                    <option value="Рубашки" {{ old('category') == 'Рубашки' ? 'selected' : '' }}>Рубашки</option>
                    <option value="Футболки" {{ old('category') == 'Футболки' ? 'selected' : '' }}>Футболки</option>
                    <option value="Лонгсливы" {{ old('category') == 'Лонгсливы' ? 'selected' : '' }}>Лонгсливы</option>
                    <option value="Джинсы" {{ old('category') == 'Джинсы' ? 'selected' : '' }}>Джинсы</option>
                    <option value="Брюки" {{ old('category') == 'Брюки' ? 'selected' : '' }}>Брюки</option>
                    <option value="Спортивный костюм" {{ old('category') == 'Спортивный костюм' ? 'selected' : '' }}>Спортивный костюм</option>
                </select>
                @error('category') <span style="color:#c00;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="price">Цена (₽)</label>
                <input id="price" type="number" step="0.01" name="price" value="{{ old('price') }}" required />
                @error('price') <span style="color:#c00;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="images">Фото товара (можно несколько)</label>
                <input type="file" name="images[]" id="images" multiple accept="image/*" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px;" />
                @error('images.*')
                    <span style="color:#c00; display: block; margin-top: 6px;">{{ $message }}</span>
                @enderror
                <small style="color: #777; display: block; margin-top: 8px;">Выберите несколько файлов сразу (можно перетащить)</small>
            </div>

            <button type="submit" class="btn-submit" style="width: 100%; margin-top: 30px; padding: 16px; font-size: 1.1rem;">
                Добавить товар
            </button>
        </form>
    </div>
@endsection