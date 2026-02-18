@extends('layouts.app')

@section('title', 'Редактировать объявление')

@section('content')
<div class="container">
    <div class="form-page">
        <h1 class="form-page__title">Редактировать объявление</h1>

        <div class="form-card">
            <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data" class="form">
                @csrf
                @method('PUT')

                <div class="form-section">
                    <h2 class="form-section__title">Основная информация</h2>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="status">Статус *</label>
                            <select id="status" name="status" class="form-input" required>
                                <option value="">Выберите статус</option>
                                <option value="lost" {{ $post->status == 'lost' ? 'selected' : '' }}>Пропал</option>
                                <option value="found" {{ $post->status == 'found' ? 'selected' : '' }}>Найден</option>
                            </select>
                            @error('status')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="lost_date">Дата события *</label>
                            <input type="date" id="lost_date" name="lost_date" class="form-input"
                                   value="{{ old('lost_date', $post->lost_date->format('Y-m-d')) }}" required>
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
                                   placeholder="Например, Барсик" value="{{ old('name', $post->name) }}">
                            @error('name')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="category_id">Вид животного *</label>
                            <select id="category_id" name="category_id" class="form-input" required>
                                <option value="" disabled {{ old('category_id', $post->category_id) ? '' : 'selected' }}>Выберите вид</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}"
                                            {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
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
                            <label for="breed_search">Порода</label>
                            <input type="text" id="breed_search" name="breed_search" class="form-input" list="breed_list"
                                   placeholder="Начните ввод..." value="{{ old('breed_search', $post->breed?->name) }}">
                            <datalist id="breed_list">
                                @foreach($breeds as $breed)
                                    <option value="{{ $breed->name }}" data-category="{{ $breed->category_id }}"></option>
                                @endforeach
                            </datalist>
                            <input type="hidden" id="breed_id" name="breed_id" value="{{ old('breed_id', $post->breed_id) }}">
                            <div class="form-hint">Выберите породу из списка, соответствующую виду</div>
                            @error('breed_id')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="gender">Пол</label>
                            <select id="gender" name="gender" class="form-input">
                                <option value="">Выберите пол</option>
                                <option value="male" {{ old('gender', $post->gender) == 'male' ? 'selected' : '' }}>Самец</option>
                                <option value="female" {{ old('gender', $post->gender) == 'female' ? 'selected' : '' }}>Самка</option>
                                <option value="unknown" {{ old('gender', $post->gender) == 'unknown' ? 'selected' : '' }}>Неизвестно</option>
                            </select>
                            @error('gender')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="age">Возраст</label>
                            <select id="age" name="age" class="form-input">
                                <option value="" disabled {{ old('age', $post->age) ? '' : 'selected' }}>Выберите возраст</option>
                                <option value="щенок" {{ old('age', $post->age) == 'щенок' ? 'selected' : '' }}>Детёныш</option>
                                <option value="взрослый" {{ old('age', $post->age) == 'взрослый' ? 'selected' : '' }}>Взрослый</option>
                                <option value="unknown" {{ old('age', $post->age) == 'unknown' ? 'selected' : '' }}>Неизвестно</option>
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
                                           {{ in_array($color->id, old('colors', $post->colors->pluck('id')->toArray())) ? 'checked' : '' }}
                                           class="checkbox-input">
                                    <span class="checkbox-text">{{ $color->name }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('colors')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="photos">Фото (изображения)</label>
                        @if($post->photos && count($post->photos))
                            <div class="current-photos" style="margin-bottom: 10px;">
                                <p>Текущие фото:</p>
                                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                                    @foreach($post->photos as $photo)
                                        <img src="{{ asset('storage/'.$photo) }}" alt="Фото" style="max-width: 100px; height: 100px; object-fit: cover;">
                                    @endforeach
                                </div>
                                <p>Выберите новые фото, чтобы заменить все текущие.</p>
                            </div>
                        @endif
                        <input type="file" id="photos" name="photos[]" class="form-input" accept="image/*" multiple>
                        @error('photos')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                        @error('photos.*')
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
                                <option value="" disabled {{ old('district_id', $post->district_id) ? '' : 'selected' }}>Неизвестно</option>
                                @foreach($districts as $district)
                                    <option value="{{ $district->id }}"
                                            {{ old('district_id', $post->district_id) == $district->id ? 'selected' : '' }}>
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
                                  placeholder="Подробное описание животного, что произошло, особые приметы...">{{ old('description', $post->description) }}</textarea>
                        @error('description')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="contact_phone">Ваш номер телефона</label>
                        <input type="tel" id="contact_phone" name="contact_phone" class="form-input"
                               placeholder="+375 (XX) XXX-XX-XX" value="{{ old('contact_phone', $post->contact_phone) }}">
                        @error('contact_phone')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn--primary">
                        <i class="fas fa-save"></i> Сохранить изменения
                    </button>
                    <a href="{{ route('posts.show', $post) }}" class="btn btn--outline">
                        <i class="fas fa-times"></i> Отмена
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const breeds = @json($breeds->toArray());

    const categorySelect = document.getElementById('category_id');
    const breedSearchInput = document.getElementById('breed_search');
    const breedIdInput = document.getElementById('breed_id');

    function syncBreedOptions() {
        const selectedCategory = categorySelect.value;
        const dataList = document.getElementById('breed_list');
        dataList.innerHTML = '';

        const options = breeds
            .filter(b => selectedCategory ? String(b.category_id) === selectedCategory : true)
            .map(b => {
                const option = document.createElement('option');
                option.value = b.name;
                option.dataset.category = b.category_id;
                return option;
            });

        options.forEach(o => dataList.appendChild(o));
    }

    categorySelect.addEventListener('change', () => {
        breedSearchInput.value = '';
        breedIdInput.value = '';
        syncBreedOptions();
    });

    breedSearchInput.addEventListener('change', () => {
        const selected = breedSearchInput.value.trim();
        if (!selected) {
            breedIdInput.value = '';
            return;
        }
        const selectedCategory = categorySelect.value;
        const match = breeds.find(b => b.name === selected && (!selectedCategory || String(b.category_id) === selectedCategory));
        if (match) {
            breedIdInput.value = match.id;
        } else {
            breedIdInput.value = '';
            alert('Выберите породу из списка (подходящую для выбранного вида).');
        }
    });

    document.querySelector('form').addEventListener('submit', function(e) {
        if (breedSearchInput.value && !breedIdInput.value) {
            e.preventDefault();
            alert('Выберите доступную породу из списка.');
        }
    });

    window.addEventListener('DOMContentLoaded', syncBreedOptions);
</script>
@endsection