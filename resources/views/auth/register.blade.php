@extends('layouts.app')

@section('content')
    <div class="auth-form-container">
        <h2>Создать аккаунт</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label for="name">Имя</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus placeholder="Как вас зовут" />
                @error('name')
                    <span style="color:#c00; font-size:0.9rem; margin-top:6px; display:block;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required placeholder="example@mail.com" />
                @error('email')
                    <span style="color:#c00; font-size:0.9rem; margin-top:6px; display:block;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Пароль</label>
                <input id="password" type="password" name="password" required placeholder="Минимум 8 символов" />
                @error('password')
                    <span style="color:#c00; font-size:0.9rem; margin-top:6px; display:block;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Повторите пароль</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required placeholder="••••••••" />
            </div>

            <button type="submit" class="btn-submit">Зарегистрироваться</button>

            <div class="form-footer">
                Уже есть аккаунт? <a href="{{ route('login') }}">Войти</a>
            </div>
        </form>
    </div>
@endsection