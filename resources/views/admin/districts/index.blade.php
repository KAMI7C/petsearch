@extends('layouts.app')

@section('title', 'Управление районами — PetSearch')

@section('content')
<div class="container">
    <div class="admin-page">
        <div class="page-header">
            <h1>Управление районами</h1>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">← Назад в админку</a>
            <a href="{{ route('admin.districts.create') }}" class="btn btn-primary">Добавить район</a>
        </div>

        <!-- Таблица районов -->
        <div class="admin-table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Название</th>
                        <th>Количество объявлений</th>
                        <th>Дата создания</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($districts as $district)
                    <tr>
                        <td>{{ $district->id }}</td>
                        <td>{{ $district->name }}</td>
                        <td>{{ $district->posts_count ?? 0 }}</td>
                        <td>{{ $district->created_at->format('d.m.Y H:i') }}</td>
                        <td class="actions-cell">
                            <div class="action-buttons">
                                <a href="{{ route('admin.districts.edit', $district) }}" class="btn btn-info btn-sm">Редактировать</a>

                                <form method="POST" action="{{ route('admin.districts.destroy', $district) }}" class="inline-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Удалить район?')">Удалить</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="no-data">Районы не найдены</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Пагинация -->
        @if($districts->hasPages())
            <div class="pagination">
                {{ $districts->links() }}
            </div>
        @endif
    </div>
</div>
@endsection