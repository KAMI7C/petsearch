@extends('layouts.app')

@section('title', 'Редактирование профиля')

@section('content')
<div class="container">
    <div class="profile-edit-page">
        <div class="page-header">
            <h1>Редактирование профиля</h1>
            <p>Обновите свою личную информацию</p>
        </div>

        <div class="edit-form-container">
            <form method="POST" action="{{ route('profile.update') }}" class="profile-form">
                @csrf
                @method('PATCH')

                <!-- Сообщения об успехе -->
                @if (session('status') === 'profile-updated')
                    <div class="alert alert--success">
                        <i class="fas fa-check-circle"></i>
                        Профиль успешно обновлен!
                    </div>
                @endif

                <!-- Ошибки валидации -->
                @if ($errors->any())
                    <div class="alert alert--error">
                        <i class="fas fa-exclamation-triangle"></i>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="form-grid">
                    <!-- Левая колонка -->
                    <div class="form-section">
                        <h3>Основная информация</h3>

                        <!-- Имя -->
                        <div class="form-group">
                            <label for="name" class="form-label">Имя *</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                                   class="form-input @error('name') form-input--error @enderror" required>
                            @error('name')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label for="email" class="form-label">Email *</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                                   class="form-input @error('email') form-input--error @enderror" required>
                            @error('email')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Телефон -->
                        <div class="form-group">
                            <label for="phone" class="form-label">Телефон</label>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone', $user->phone) }}"
                                   class="form-input @error('phone') form-input--error @enderror"
                                   placeholder="+7 (999) 123-45-67">
                            @error('phone')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Правая колонка -->
                    <div class="form-section">
                        <h3>Дополнительная информация</h3>

                        <!-- Город -->
                        <div class="form-group">
                            <label for="city" class="form-label">Город</label>
                            <input type="text" id="city" name="city" value="{{ old('city', $user->city) }}"
                                   class="form-input @error('city') form-input--error @enderror"
                                   placeholder="Например: Москва">
                            @error('city')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- О себе -->
                        <div class="form-group">
                            <label for="about" class="form-label">О себе</label>
                            <textarea id="about" name="about" class="form-textarea @error('about') form-textarea--error @enderror"
                                      rows="4" placeholder="Расскажите немного о себе...">{{ old('about', $user->about) }}</textarea>
                            @error('about')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Кнопки действий -->
                <div class="form-actions">
                    <button type="submit" class="btn btn--primary">
                        <i class="fas fa-save"></i> Сохранить изменения
                    </button>
                    <a href="{{ route('profile.show') }}" class="btn btn--outline">
                        <i class="fas fa-arrow-left"></i> Вернуться в профиль
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.profile-edit-page {
    padding: 40px 0;
    max-width: 1000px;
    margin: 0 auto;
}

.page-header {
    text-align: center;
    margin-bottom: 40px;
}

.page-header h1 {
    color: #4a3729;
    margin-bottom: 10px;
}

.page-header p {
    color: #6b5a4c;
    font-size: 18px;
}

.edit-form-container {
    background: white;
    padding: 32px;
    border-radius: 16px;
    border: 1px solid #e0d6cc;
}

.profile-form {
    width: 100%;
}

.alert {
    padding: 16px;
    border-radius: 8px;
    margin-bottom: 24px;
    display: flex;
    align-items: flex-start;
    gap: 12px;
}

.alert--success {
    background-color: #e6f7e6;
    border: 1px solid #166534;
    color: #166534;
}

.alert--error {
    background-color: #fee2e2;
    border: 1px solid #b91c1c;
    color: #b91c1c;
}

.alert i {
    font-size: 18px;
    margin-top: 2px;
}

.alert ul {
    margin: 0;
    padding-left: 20px;
}

.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 32px;
    margin-bottom: 32px;
}

.form-section h3 {
    color: #4a3729;
    margin-bottom: 24px;
    font-size: 18px;
    border-bottom: 2px solid #f0eae4;
    padding-bottom: 8px;
}

.form-group {
    margin-bottom: 20px;
}

.form-label {
    display: block;
    margin-bottom: 6px;
    color: #4a3729;
    font-weight: 500;
}

.form-input,
.form-textarea {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid #e0d6cc;
    border-radius: 8px;
    font-size: 16px;
    transition: border-color 0.2s;
}

.form-input:focus,
.form-textarea:focus {
    outline: none;
    border-color: #d97c4a;
}

.form-input--error,
.form-textarea--error {
    border-color: #b91c1c;
}

.form-textarea {
    resize: vertical;
    min-height: 100px;
}

.form-error {
    display: block;
    color: #b91c1c;
    font-size: 14px;
    margin-top: 4px;
}

.form-actions {
    display: flex;
    gap: 16px;
    justify-content: center;
    padding-top: 24px;
    border-top: 1px solid #e0d6cc;
}

/* Адаптивность */
@media (max-width: 768px) {
    .form-grid {
        grid-template-columns: 1fr;
        gap: 24px;
    }

    .edit-form-container {
        padding: 24px;
    }

    .form-actions {
        flex-direction: column;
    }

    .form-actions .btn {
        width: 100%;
    }
}
</style>
@endsection
