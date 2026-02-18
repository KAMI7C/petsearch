@extends('layouts.app')

@section('title', 'Редактирование категории — PetSearch')

@section('content')
<div class="container">
    <div class="admin-page">
        <div class="page-header">
            <h1>Редактирование категории</h1>
            <a href="{{ route('admin.categories') }}" class="btn btn-secondary">← Назад к категориям</a>
        </div>

        <div class="admin-form-container">
            <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="admin-form">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Название категории *</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" required>
                    @error('name')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description">Описание</label>
                    <textarea name="description" id="description" rows="4">{{ old('description', $category->description) }}</textarea>
                    @error('description')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                    <a href="{{ route('admin.categories') }}" class="btn btn-secondary">Отмена</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection