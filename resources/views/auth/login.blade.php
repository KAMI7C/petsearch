@extends('layouts.app')

@section('title', 'Вход в систему')

@section('content')
<div class="container">
    <div class="auth-page">
        <div class="auth-card">
            <h1 class="auth-title">Вход в систему</h1>

            @if($errors->any())
                <div class="alert alert--error">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="auth-form">
                @csrf

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-input"
                           value="{{ old('email') }}" required autofocus>
                </div>

                <div class="form-group">
                    <label for="password">Пароль</label>
                    <input type="password" id="password" name="password" class="form-input" required>
                </div>

                <div class="form-group">
                    <label class="checkbox-label">
                        <input type="checkbox" name="remember" class="checkbox-input">
                        <span class="checkbox-text">Запомнить меня</span>
                    </label>
                </div>

                <button type="submit" class="btn btn--primary btn--full">
                    <i class="fas fa-sign-in-alt"></i> Войти
                </button>
            </form>

            <div class="auth-links">
                <p>Нет аккаунта? <a href="{{ route('register') }}">Зарегистрироваться</a></p>
            </div>
        </div>
    </div>
</div>
@endsection