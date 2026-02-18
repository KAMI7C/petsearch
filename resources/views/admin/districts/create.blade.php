@extends('layouts.app')

@section('title', 'Создание района — PetSearch')

@section('content')
<div class="container">
    <div class="admin-page">
        <div class="page-header">
            <h1>Создание района</h1>
            <a href="{{ route('admin.districts') }}" class="btn btn-secondary">← Назад к районам</a>
        </div>

        <div class="admin-form-container">
            <form method="POST" action="{{ route('admin.districts.store') }}" class="admin-form">
                @csrf

                <div class="form-group">
                    <label for="name">Название района *</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Создать район</button>
                    <a href="{{ route('admin.districts') }}" class="btn btn-secondary">Отмена</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection