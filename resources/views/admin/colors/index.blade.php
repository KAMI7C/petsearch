@extends('layouts.app')

@section('title', 'Управление цветами — PetSearch')

@section('content')
<div class="container">
    <div class="admin-page">
        <div class="page-header">
            <h1>Управление цветами</h1>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">← Назад в админку</a>
            <a href="{{ route('admin.colors.create') }}" class="btn btn-primary">Добавить цвет</a>
        </div>

        <!-- Таблица цветов -->
        <div class="admin-table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Название</th>
                        <th>Отображение</th>
                        <th>Количество объявлений</th>
                        <th>Дата создания</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($colors as $color)
                    <tr>
                        <td>{{ $color->id }}</td>
                        <td>{{ $color->name }}</td>
                        <td>
                            <span class="color-circle" style="background-color: {{ $color->hex_code ?? '#cccccc' }};"></span>
                            <small>{{ $color->hex_code ?? '#cccccc' }}</small>
                        </td>
                        <td>{{ $color->posts_count ?? 0 }}</td>
                        <td>{{ $color->created_at->format('d.m.Y H:i') }}</td>
                        <td class="actions-cell">
                            <div class="action-buttons">
                                <a href="{{ route('admin.colors.edit', $color) }}" class="btn btn-info btn-sm">Редактировать</a>

                                <form method="POST" action="{{ route('admin.colors.destroy', $color) }}" class="inline-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Удалить цвет?')">Удалить</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="no-data">Цвета не найдены</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Пагинация -->
        @if($colors->hasPages())
            <div class="pagination">
                {{ $colors->links() }}
            </div>
        @endif
    </div>
</div>
@endsection