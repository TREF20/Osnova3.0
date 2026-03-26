@extends('layouts.app')

@section('content')
    <div class="auth-form-container">
        <h2>Вход в аккаунт</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="example@mail.com" />
                @error('email')
                    <span style="color:#c00; font-size:0.9rem; margin-top:6px; display:block;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Пароль</label>
                <input id="password" type="password" name="password" required placeholder="••••••••" />
                @error('password')
                    <span style="color:#c00; font-size:0.9rem; margin-top:6px; display:block;">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn-submit">Войти</button>

            <div class="form-footer">
                Нет аккаунта? <a href="{{ route('register') }}">Зарегистрироваться</a>
            </div>
        </form>
    </div>
@endsection