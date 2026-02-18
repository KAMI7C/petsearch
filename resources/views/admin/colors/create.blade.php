@extends('layouts.app')

@section('title', 'Создание цвета — PetSearch')

@section('content')
<div class="container">
    <div class="admin-page">
        <div class="page-header">
            <h1>Создание цвета</h1>
            <a href="{{ route('admin.colors') }}" class="btn btn-secondary">← Назад к цветам</a>
        </div>

        <div class="admin-form-container">
            <form method="POST" action="{{ route('admin.colors.store') }}" class="admin-form">
                @csrf

                <div class="form-group">
                    <label for="name">Название цвета *</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="hex_code">Цвет кружка (HEX)</label>
                    <input type="color" id="hex_code" value="{{ old('hex_code', '#cccccc') }}" oninput="document.getElementById('hex_code_text').value = this.value">
                    <input type="text" name="hex_code" id="hex_code_text" value="{{ old('hex_code', '#cccccc') }}" placeholder="#RRGGBB" pattern="^#[A-Fa-f0-9]{6}$">
                    @error('hex_code')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Создать цвет</button>
                    <a href="{{ route('admin.colors') }}" class="btn btn-secondary">Отмена</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection