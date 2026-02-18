@extends('layouts.app')

@section('title', 'Управление пользователями — PetSearch')

@section('content')
<div class="container">
    <div class="admin-page">
        <div class="page-header">
            <h1>Управление пользователями</h1>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">← Назад в админку</a>
        </div>

        <div class="admin-filters">
            <form method="GET" class="filters-form">
                <div class="filter-group">
                    <label for="search">Поиск по email или имени:</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Введите email или имя">
                </div>

                <div class="filter-group">
                    <label for="role">Роль:</label>
                    <select name="role" id="role">
                        <option value="">Все роли</option>
                        <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>Пользователь</option>
                        <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Администратор</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="status">Статус:</label>
                    <select name="status" id="status">
                        <option value="">Все статусы</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Активные</option>
                        <option value="banned" {{ request('status') === 'banned' ? 'selected' : '' }}>Заблокированные</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Фильтровать</button>
                <a href="{{ route('admin.users') }}" class="btn btn-secondary">Сбросить</a>
            </form>
        </div>

        <div class="admin-table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Имя</th>
                        <th>Email</th>
                        <th>Роль</th>
                        <th>Статус</th>
                        <th>Дата регистрации</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="role-badge role-{{ $user->role }}">
                                {{ $user->role === 'admin' ? 'Администратор' : 'Пользователь' }}
                            </span>
                        </td>
                        <td>
                            @if($user->banned)
                                <span class="status-badge status-banned">Заблокирован</span>
                            @else
                                <span class="status-badge status-active">Активен</span>
                            @endif
                        </td>
                        <td>{{ $user->created_at->format('d.m.Y H:i') }}</td>
                        <td class="actions-cell">
                            <div class="action-buttons">
                                @if(!$user->banned)
                                    <form method="POST" action="{{ route('admin.users.ban', $user) }}" class="inline-form">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="action" value="ban">
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Заблокировать пользователя?')">Заблокировать</button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('admin.users.unban', $user) }}" class="inline-form">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="action" value="unban">
                                        <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Разблокировать пользователя?')">Разблокировать</button>
                                    </form>
                                @endif

                                @if($user->role !== 'admin')
                                    <form method="POST" action="{{ route('admin.users.make-admin', $user) }}" class="inline-form">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="action" value="make_admin">
                                        <button type="submit" class="btn btn-warning btn-sm" onclick="return confirm('Назначить администратором?')">Сделать админом</button>
                                    </form>
                                @elseif($user->id !== auth()->id())
                                    <form method="POST" action="{{ route('admin.users.revoke-admin', $user) }}" class="inline-form">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-secondary btn-sm" onclick="return confirm('Забрать права администратора?')">Забрать администратора</button>
                                    </form>
                                @endif

                                <button type="button" class="btn btn-info btn-sm" onclick="showUserDetails({{ $user->id }})">Подробно</button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="no-data">Пользователи не найдены</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="pagination">
                {{ $users->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>

<div id="userDetailsModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Информация о пользователе</h3>
            <span class="modal-close">&times;</span>
        </div>
        <div class="modal-body" id="userDetailsContent"></div>
    </div>
</div>

<script>
function showUserDetails(userId) {
    fetch(`/admin/users/${userId}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('userDetailsContent').innerHTML = `
                <div class="user-details">
                    <p><strong>ID:</strong> ${data.id}</p>
                    <p><strong>Имя:</strong> ${data.name}</p>
                    <p><strong>Email:</strong> ${data.email}</p>
                    <p><strong>Роль:</strong> ${data.role === 'admin' ? 'Администратор' : 'Пользователь'}</p>
                    <p><strong>Статус:</strong> ${data.banned ? 'Заблокирован' : 'Активен'}</p>
                    <p><strong>Дата регистрации:</strong> ${new Date(data.created_at).toLocaleString('ru-RU')}</p>
                    <p><strong>Последний вход:</strong> ${data.last_login ? new Date(data.last_login).toLocaleString('ru-RU') : 'Неизвестно'}</p>
                    ${data.ban_reason ? `<p><strong>Причина блокировки:</strong> ${data.ban_reason}</p>` : ''}
                </div>
            `;
            document.getElementById('userDetailsModal').style.display = 'block';
        })
        .catch(error => {
            alert('Ошибка загрузки данных пользователя');
        });
}

document.querySelector('.modal-close').addEventListener('click', function() {
    document.getElementById('userDetailsModal').style.display = 'none';
});

window.addEventListener('click', function(event) {
    if (event.target === document.getElementById('userDetailsModal')) {
        document.getElementById('userDetailsModal').style.display = 'none';
    }
});
</script>
@endsection