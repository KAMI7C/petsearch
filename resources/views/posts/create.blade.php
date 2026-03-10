@extends('layouts.app')

@section('title', 'Создать объявление')

@section('content')
<div class="container">
    <div class="form-page">
        <h1 class="form-page__title">Создать объявление</h1>
        
        <div class="form-card">
            <form action="{{ route('posts.store') }}" method="POST" class="form">
                @csrf
                
                <div class="form-section">
                    <h2 class="form-section__title">Основная информация</h2>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="status">Статус *</label>
                            <select id="status" name="status" class="form-input" required>
                                <option value="">Выберите статус</option>
                                <option value="lost" {{ old('status') == 'lost' ? 'selected' : '' }}>Пропал</option>
                                <option value="found" {{ old('status') == 'found' ? 'selected' : '' }}>Найден</option>
                            </select>
                            @error('status')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="lost_date">Дата события *</label>
                            <input type="date" id="lost_date" name="lost_date" class="form-input" 
                                   value="{{ old('lost_date') }}" required>
                            @error('lost_date')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h2 class="form-section__title">Информация о животном</h2>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="name">Имя (кличка)</label>
                            <input type="text" id="name" name="name" class="form-input" 
                                   placeholder="Например, Барсик" value="{{ old('name') }}">
                            @error('name')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="category_id">Вид животного *</label>
                            <select id="category_id" name="category_id" class="form-input" required>
                                <option value="">Выберите вид</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="breed_id">Порода</label>
                            <select id="breed_id" name="breed_id" class="form-input">
                                <option value="">Выберите породу</option>
                                @foreach($breeds as $breed)
                                    <option value="{{ $breed->id }}"
                                            {{ old('breed_id') == $breed->id ? 'selected' : '' }}>
                                        {{ $breed->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('breed_id')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="gender">Пол</label>
                            <select id="gender" name="gender" class="form-input">
                                <option value="">Выберите пол</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Самец</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Самка</option>
                                <option value="unknown" {{ old('gender') == 'unknown' ? 'selected' : '' }}>Неизвестно</option>
                            </select>
                            @error('gender')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="age">Возраст</label>
                            <select id="age" name="age" class="form-input">
                                <option value="">Выберите возраст</option>
                                <option value="щенок" {{ old('age') == 'щенок' ? 'selected' : '' }}>Щенок</option>
                                <option value="взрослый" {{ old('age') == 'взрослый' ? 'selected' : '' }}>Взрослый</option>
                            </select>
                            @error('age')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="colors">Окрас(ы)</label>
                        <div class="colors-group">
                            @foreach($colors as $color)
                                <label class="checkbox-label">
                                    <input type="checkbox" name="colors[]" value="{{ $color->id }}"
                                           {{ in_array($color->id, old('colors', [])) ? 'checked' : '' }}
                                           class="checkbox-input">
                                    <span class="checkbox-text">{{ $color->name }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('colors')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-section">
                    <h2 class="form-section__title">Место происшествия</h2>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="district_id">Район</label>
                            <select id="district_id" name="district_id" class="form-input">
                                <option value="">Выберите район</option>
                                @foreach($districts as $district)
                                    <option value="{{ $district->id }}"
                                            {{ old('district_id') == $district->id ? 'selected' : '' }}>
                                        {{ $district->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('district_id')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h2 class="form-section__title">Описание</h2>
                    
                    <div class="form-group">
                        <label for="description">Описание</label>
                        <textarea id="description" name="description" class="form-input form-textarea"
                                  placeholder="Подробное описание животного, что произошло, особые приметы...">{{ old('description') }}</textarea>
                        @error('description')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="contact_phone">Ваш номер телефона</label>
                        <input type="tel" id="contact_phone" name="contact_phone" class="form-input" 
                               placeholder="+7 (XXX) XXX-XX-XX" value="{{ old('contact_phone') }}">
                        @error('contact_phone')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn--primary">
                        <i class="fas fa-check"></i> Создать объявление
                    </button>
                    <a href="{{ route('posts.index') }}" class="btn btn--outline">
                        <i class="fas fa-times"></i> Отмена
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
