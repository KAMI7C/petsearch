@extends('layouts.app')

@section('title', 'Регистрация')

@section('content')
<div class="container">
    <div class="auth-page">
        <div class="auth-card">
            <h1 class="auth-title">Регистрация</h1>

            @if($errors->any())
                <div class="alert alert--error">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST" class="auth-form">
                @csrf

                <div class="form-group">
                    <label for="name">Имя</label>
                    <input type="text" id="name" name="name" class="form-input"
                           value="{{ old('name') }}" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-input"
                           value="{{ old('email') }}" required>
                </div>

                <div class="form-group">
                    <label for="password">Пароль</label>
                    <input type="password" id="password" name="password" class="form-input" required>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Подтверждение пароля</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" required>
                </div>

                <button type="submit" class="btn btn--primary btn--full">
                    <i class="fas fa-user-plus"></i> Зарегистрироваться
                </button>
            </form>

            <div class="auth-links">
                <p>Уже есть аккаунт? <a href="{{ route('login') }}">Войти</a></p>
            </div>
        </div>
    </div>
</div>
@endsection