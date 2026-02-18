@extends('layouts.app')

@section('title', 'Управление породами — PetSearch')

@section('content')
<div class="container">
    <div class="admin-page">
        <div class="page-header">
            <h1>Управление породами</h1>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">← Назад в админку</a>
            <a href="{{ route('admin.breeds.create') }}" class="btn btn-primary">Добавить породу</a>
        </div>

        <!-- Фильтры -->
        <div class="admin-filters">
            <form method="GET" class="filters-form">
                <div class="filter-group">
                    <label for="category">Категория:</label>
                    <select name="category" id="category">
                        <option value="">Все категории</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Фильтровать</button>
                <a href="{{ route('admin.breeds') }}" class="btn btn-secondary">Сбросить</a>
            </form>
        </div>

        <!-- Таблица пород -->
        <div class="admin-table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Название</th>
                        <th>Категория</th>
                        <th>Количество объявлений</th>
                        <th>Дата создания</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($breeds as $breed)
                    <tr>
                        <td>{{ $breed->id }}</td>
                        <td>{{ $breed->name }}</td>
                        <td>{{ $breed->category->name ?? 'Без категории' }}</td>
                        <td>{{ $breed->posts_count ?? 0 }}</td>
                        <td>{{ $breed->created_at->format('d.m.Y H:i') }}</td>
                        <td class="actions-cell">
                            <div class="action-buttons">
                                <a href="{{ route('admin.breeds.edit', $breed) }}" class="btn btn-info btn-sm">Редактировать</a>

                                <form method="POST" action="{{ route('admin.breeds.destroy', $breed) }}" class="inline-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Удалить породу?')">Удалить</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="no-data">Породы не найдены</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Пагинация -->
        @if($breeds->hasPages())
            <div class="pagination">
                {{ $breeds->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>
@endsection