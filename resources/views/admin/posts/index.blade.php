@extends('layouts.app')

@section('title', 'Управление объявлениями — PetSearch')

@section('content')
<div class="container">
    <div class="admin-page">
        <div class="page-header">
            <h1>Управление объявлениями</h1>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">← Назад в админку</a>
        </div>

        <div class="admin-filters">
            <form method="GET" class="filters-form">
                <div class="filter-group">
                    <label for="search">Поиск (заголовок/описание/автор):</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Заголовок, описание, имя или email автора">
                </div>

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

                <div class="filter-group">
                    <label for="status">Статус:</label>
                    <select name="status" id="status">
                        <option value="">Все статусы</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Активные</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Неактивные</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="date_from">Дата с:</label>
                    <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}">
                </div>

                <div class="filter-group">
                    <label for="date_to">Дата по:</label>
                    <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}">
                </div>

                <button type="submit" class="btn btn-primary">Фильтровать</button>
                <a href="{{ route('admin.posts') }}" class="btn btn-secondary">Сбросить</a>
            </form>
        </div>

        <div class="admin-table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Фото</th>
                        <th>Заголовок</th>
                        <th>Категория</th>
                        <th>Автор</th>
                        <th>Статус</th>
                        <th>Дата создания</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($posts as $post)
                    <tr>
                        <td>{{ $post->id }}</td>
                        <td>
                            @php
                                $thumb = null;
                                if (is_array($post->photos) && count($post->photos) > 0) {
                                    $thumb = $post->photos[0];
                                } elseif (!empty($post->photo)) {
                                    $thumb = $post->photo;
                                }
                            @endphp
                            @if($thumb)
                                <img src="{{ asset('storage/'.$thumb) }}" alt="Фото" class="admin-post-thumb">
                            @else
                                —
                            @endif
                        </td>
                        <td>
                            <div class="post-title">
                                <strong>{{ Str::limit($post->name ?? ('Объявление #' . $post->id), 50) }}</strong>
                            </div>
                        </td>
                        <td>{{ $post->category->name ?? 'Без категории' }}</td>
                        <td>
                            <div class="user-info">
                                <span>{{ $post->user->name }}</span>
                                <small>{{ $post->user->email }}</small>
                            </div>
                        </td>
                        <td>
                            @if($post->is_active)
                                <span class="status-badge status-active">Активно</span>
                            @else
                                <span class="status-badge status-inactive">Неактивно</span>
                            @endif
                        </td>
                        <td>{{ $post->created_at->format('d.m.Y H:i') }}</td>
                        <td class="actions-cell">
                            <div class="action-buttons">
                                <button type="button" class="btn btn-info btn-sm" onclick="showPostDetails({{ $post->id }})">Просмотр</button>

                                @if($post->is_active)
                                    <form method="POST" action="{{ route('admin.posts.deactivate', $post) }}" class="inline-form">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-warning btn-sm" onclick="return confirm('Деактивировать объявление?')">Деактивировать</button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('admin.posts.activate', $post) }}" class="inline-form">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Активировать объявление?')">Активировать</button>
                                    </form>
                                @endif

                                <form method="POST" action="{{ route('admin.posts.destroy', $post) }}" class="inline-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Удалить объявление навсегда?')">Удалить</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="no-data">Объявления не найдены</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($posts->hasPages())
            <div class="pagination">
                {{ $posts->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>

<div id="postDetailsModal" class="modal">
    <div class="modal-content large-modal">
        <div class="modal-header">
            <h3>Детали объявления</h3>
            <span class="modal-close">&times;</span>
        </div>
        <div class="modal-body" id="postDetailsContent"></div>
    </div>
</div>

<script>
function showPostDetails(postId) {
    fetch(`/admin/posts/${postId}`)
        .then(response => response.json())
        .then(data => {
            let imagesHtml = '';
            if (data.images && data.images.length > 0) {
                imagesHtml = '<div class="post-images"><h4>Изображения:</h4><div class="images-grid">';
                data.images.forEach(image => {
                    imagesHtml += `<img src="/storage/${image.path}" alt="Изображение" class="post-image-thumb">`;
                });
                imagesHtml += '</div></div>';
            }

            document.getElementById('postDetailsContent').innerHTML = `
                <div class="post-details">
                    <h4>${data.title}</h4>
                    <p><strong>Описание:</strong> ${data.description}</p>
                    <p><strong>Категория:</strong> ${data.category ? data.category.name : 'Без категории'}</p>
                    <p><strong>Порода:</strong> ${data.breed ? data.breed.name : 'Не указана'}</p>
                    <p><strong>Цвет:</strong> ${data.color ? data.color.name : 'Не указан'}</p>
                    <p><strong>Район:</strong> ${data.district ? data.district.name : 'Не указан'}</p>
                    <p><strong>Автор:</strong> ${data.user.name} (${data.user.email})</p>
                    <p><strong>Статус:</strong> ${data.active ? 'Активно' : 'Неактивно'}</p>
                    <p><strong>Дата создания:</strong> ${new Date(data.created_at).toLocaleString('ru-RU')}</p>
                    ${imagesHtml}
                </div>
            `;
            document.getElementById('postDetailsModal').style.display = 'block';
        })
        .catch(error => {
            alert('Ошибка загрузки данных объявления');
        });
}

document.querySelector('.modal-close').addEventListener('click', function() {
    document.getElementById('postDetailsModal').style.display = 'none';
});

window.addEventListener('click', function(event) {
    if (event.target === document.getElementById('postDetailsModal')) {
        document.getElementById('postDetailsModal').style.display = 'none';
    }
});
</script>
@endsection