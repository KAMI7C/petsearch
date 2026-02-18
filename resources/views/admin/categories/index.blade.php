@extends('layouts.app')

@section('title', 'Управление категориями — PetSearch')

@section('content')
<div class="container">
    <div class="admin-page">
        <div class="page-header">
            <h1>Управление категориями</h1>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">← Назад в админку</a>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">Добавить категорию</a>
        </div>

        <!-- Таблица категорий -->
        <div class="admin-table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Название</th>
                        <th>Описание</th>
                        <th>Количество объявлений</th>
                        <th>Дата создания</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->description ?? 'Без описания' }}</td>
                        <td>{{ $category->posts_count ?? 0 }}</td>
                        <td>{{ $category->created_at->format('d.m.Y H:i') }}</td>
                        <td class="actions-cell">
                            <div class="action-buttons">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-info btn-sm">Редактировать</a>

                                <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" class="inline-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Удалить категорию?')">Удалить</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="no-data">Категории не найдены</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Пагинация -->
        @if($categories->hasPages())
            <div class="pagination">
                {{ $categories->links() }}
            </div>
        @endif
    </div>
</div>
@endsection