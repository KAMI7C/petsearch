@extends('layouts.app')

@section('title', 'Управление откликами — PetSearch')

@section('content')
<div class="container">
    <div class="admin-page">
        <div class="page-header">
            <h1>Управление откликами</h1>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">← Назад в админку</a>
        </div>

        <div class="admin-filters">
            <form method="GET" class="filters-form">
                <div class="filter-group">
                    <label for="search">Поиск по тексту:</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Введите текст отклика">
                </div>

                <div class="filter-group">
                    <label for="status">Статус:</label>
                    <select name="status" id="status">
                        <option value="">Все статусы</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Активные</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Неактивные</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Фильтровать</button>
                <a href="{{ route('admin.responses') }}" class="btn btn-secondary">Сбросить</a>
            </form>
        </div>

        <div class="admin-table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Текст отклика</th>
                        <th>Объявление</th>
                        <th>Автор</th>
                        <th>Статус</th>
                        <th>Дата создания</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($responses as $response)
                    <tr>
                        <td>{{ $response->id }}</td>
                        <td>
                            <div class="response-text">
                                {{ Str::limit($response->message, 100) }}
                            </div>
                        </td>
                        <td>
                            <div class="post-info">
                                <strong>{{ Str::limit($response->post->name ?? ('Объявление #' . $response->post->id), 30) }}</strong>
                                <small>от {{ $response->post->user->name ?? 'Неизвестно' }}</small>
                            </div>
                        </td>
                        <td>
                            <div class="user-info">
                                <span>{{ $response->user->name ?? ($response->guest_name ?? 'Гость') }}</span>
                                <small>{{ $response->user->email ?? ($response->guest_phone ?? '-') }}</small>
                            </div>
                        </td>
                        <td>
                            @if(!$response->is_archived)
                                <span class="status-badge status-active">Активен</span>
                            @else
                                <span class="status-badge status-inactive">Неактивен</span>
                            @endif
                        </td>
                        <td>{{ $response->created_at->format('d.m.Y H:i') }}</td>
                        <td class="actions-cell">
                            <div class="action-buttons">
                                <button type="button" class="btn btn-info btn-sm" onclick="showResponseDetails({{ $response->id }})">Просмотр</button>

                                @if(!$response->is_archived)
                                    <form method="POST" action="{{ route('admin.responses.deactivate', $response) }}" class="inline-form">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-warning btn-sm" onclick="return confirm('Деактивировать отклик?')">Деактивировать</button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('admin.responses.activate', $response) }}" class="inline-form">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Активировать отклик?')">Активировать</button>
                                    </form>
                                @endif

                                <form method="POST" action="{{ route('admin.responses.destroy', $response) }}" class="inline-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Удалить отклик навсегда?')">Удалить</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="no-data">Отклики не найдены</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($responses->hasPages())
            <div class="pagination">
                {{ $responses->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>

<div id="responseDetailsModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Детали отклика</h3>
            <span class="modal-close">&times;</span>
        </div>
        <div class="modal-body" id="responseDetailsContent"></div>
    </div>
</div>

<script>
function showResponseDetails(responseId) {
    fetch(`/admin/responses/${responseId}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('responseDetailsContent').innerHTML = `
                <div class="response-details">
                    <p><strong>Текст отклика:</strong></p>
                    <div class="response-message">${data.message}</div>
                    <p><strong>Объявление:</strong> ${data.post ? (data.post.name || ('Объявление #' + data.post.id)) : 'Удалено'}</p>
                    <p><strong>Автор объявления:</strong> ${data.post && data.post.user ? data.post.user.name + ' (' + data.post.user.email + ')' : 'Неизвестно'}</p>
                    <p><strong>Автор отклика:</strong> ${data.user ? data.user.name + ' (' + data.user.email + ')' : 'Гость'}</p>
                    <p><strong>Статус:</strong> ${data.active ? 'Активен' : 'Неактивен'}</p>
                    <p><strong>Дата создания:</strong> ${new Date(data.created_at).toLocaleString('ru-RU')}</p>
                </div>
            `;
            document.getElementById('responseDetailsModal').style.display = 'block';
        })
        .catch(error => {
            alert('Ошибка загрузки данных отклика');
        });
}

document.querySelector('.modal-close').addEventListener('click', function() {
    document.getElementById('responseDetailsModal').style.display = 'none';
});

window.addEventListener('click', function(event) {
    if (event.target === document.getElementById('responseDetailsModal')) {
        document.getElementById('responseDetailsModal').style.display = 'none';
    }
});
</script>
@endsection