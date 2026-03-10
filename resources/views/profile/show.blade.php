@extends('layouts.app')

@section('title', 'Личный кабинет — ' . $user->name)

@section('content')
<div class="container">
    <div class="profile-page">
        <!-- Заголовок -->
        <div class="page-header">
            <h1>Личный кабинет</h1>
            <p>Здравствуйте, {{ $user->name }}!</p>
        </div>

        <div class="profile-grid">
            <!-- Левая колонка: Информация о пользователе -->
            <div class="profile-sidebar">
                <div class="profile-card">
                    <h3>Личная информация</h3>

                    <div class="profile-info">
                        <div class="info-item">
                            <strong>Имя:</strong>
                            <span>{{ $user->name }}</span>
                        </div>

                        <div class="info-item">
                            <strong>Email:</strong>
                            <span>{{ $user->email }}</span>
                        </div>

                        @if($user->phone)
                            <div class="info-item">
                                <strong>Телефон:</strong>
                                <span>{{ $user->phone }}</span>
                            </div>
                        @endif

                        <div class="info-item">
                            <strong>Дата регистрации:</strong>
                            <span>{{ $user->created_at->format('d.m.Y') }}</span>
                        </div>
                    </div>

                    <div class="profile-actions">
                        <a href="{{ route('profile.edit') }}" class="btn btn--outline">
                            <i class="fas fa-edit"></i> Редактировать профиль
                        </a>
                        <a href="{{ route('logout') }}" class="btn btn--danger"
                           onclick="return confirm('Вы уверены, что хотите выйти?')">
                            <i class="fas fa-sign-out-alt"></i> Выйти
                        </a>
                    </div>
                </div>

                <!-- Статистика -->
                <div class="profile-card">
                    <h3>Статистика</h3>
                    <div class="stats-grid">
                        <div class="stat-item">
                            <div class="stat-number">{{ $user->posts->count() }}</div>
                            <div class="stat-label">Объявлений</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">{{ $user->favoritePosts->count() }}</div>
                            <div class="stat-label">Избранных</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Правая колонка: Объявления пользователя -->
            <div class="profile-content">
                <!-- Мои объявления -->
                <div class="profile-section">
                    <div class="section-header">
                        <h2>Мои объявления</h2>
                        <a href="{{ route('posts.create') }}" class="btn btn--primary">
                            <i class="fas fa-plus"></i> Создать объявление
                        </a>
                    </div>

                    @if($user->posts->count() > 0)
                        <div class="posts-grid">
                            @foreach($user->posts as $post)
                                <div class="post-card">
                                    <div class="post-card__image">
                                        <i class="fas fa-image"></i>
                                    </div>
                                    <div class="post-card__content">
                                        <span class="post-card__status {{ $post->status == 'lost' ? 'status-lost' : 'status-found' }}">
                                            {{ $post->status == 'lost' ? 'Пропал' : 'Найден' }}
                                        </span>
                                        <h3 class="post-card__title">{{ $post->name ?: 'Без имени' }}</h3>
                                        <div class="post-card__meta">
                                            <div><i class="fas fa-paw"></i> {{ $post->category->name }}</div>
                                            <div><i class="far fa-calendar"></i> {{ $post->created_at->format('d.m.Y') }}</div>
                                            <div><i class="fas fa-eye"></i> {{ $post->views }} просмотров</div>
                                        </div>
                                        <div class="post-card__actions">
                                            <a href="{{ route('posts.show', $post) }}" class="btn btn--outline btn--small">
                                                Просмотр
                                            </a>
                                            <a href="{{ route('posts.edit', $post) }}" class="btn btn--secondary btn--small">
                                                Редактировать
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="fas fa-paw"></i>
                            <h3>У вас пока нет объявлений</h3>
                            <p>Создайте первое объявление о пропавшем или найденном питомце</p>
                            <a href="{{ route('posts.create') }}" class="btn btn--primary">
                                Создать объявление
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Избранные объявления -->
                <div class="profile-section">
                    <h2>Избранные объявления</h2>

                    @if($user->favoritePosts->count() > 0)
                        <div class="posts-grid">
                            @foreach($user->favoritePosts as $post)
                                <div class="post-card">
                                    <div class="post-card__image">
                                        <i class="fas fa-image"></i>
                                    </div>
                                    <div class="post-card__content">
                                        <span class="post-card__status {{ $post->status == 'lost' ? 'status-lost' : 'status-found' }}">
                                            {{ $post->status == 'lost' ? 'Пропал' : 'Найден' }}
                                        </span>
                                        <h3 class="post-card__title">{{ $post->name ?: 'Без имени' }}</h3>
                                        <div class="post-card__meta">
                                            <div><i class="fas fa-paw"></i> {{ $post->category->name }}</div>
                                            <div><i class="far fa-calendar"></i> {{ $post->created_at->format('d.m.Y') }}</div>
                                            <div><i class="fas fa-user"></i> {{ $post->user->name }}</div>
                                        </div>
                                        <div class="post-card__actions">
                                            <a href="{{ route('posts.show', $post) }}" class="btn btn--outline btn--small">
                                                Просмотр
                                            </a>
                                            <button class="btn btn--danger btn--small" onclick="removeFromFavorites({{ $post->id }})">
                                                <i class="fas fa-heart-broken"></i> Удалить
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="fas fa-heart"></i>
                            <h3>У вас нет избранных объявлений</h3>
                            <p>Добавляйте интересные объявления в избранное, чтобы не потерять их</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function removeFromFavorites(postId) {
    if (!confirm('Удалить из избранного?')) return;

    fetch(`/posts/${postId}/favorite`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        location.reload();
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Ошибка при удалении из избранного');
    });
}
</script>

<style>
.profile-page {
    padding: 40px 0;
}

.page-header {
    text-align: center;
    margin-bottom: 40px;
}

.page-header h1 {
    color: #4a3729;
    margin-bottom: 10px;
}

.page-header p {
    color: #6b5a4c;
    font-size: 18px;
}

.profile-grid {
    display: grid;
    grid-template-columns: 300px 1fr;
    gap: 40px;
}

.profile-sidebar {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.profile-card {
    background: white;
    padding: 24px;
    border-radius: 16px;
    border: 1px solid #e0d6cc;
}

.profile-card h3 {
    color: #4a3729;
    margin-bottom: 20px;
    font-size: 18px;
}

.profile-info {
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin-bottom: 24px;
}

.info-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.info-item strong {
    color: #4a3729;
}

.info-item span {
    color: #6b5a4c;
}

.profile-actions {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.stats-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
}

.stat-item {
    text-align: center;
    padding: 15px;
    background: #f5e6d8;
    border-radius: 12px;
}

.stat-number {
    font-size: 24px;
    font-weight: 600;
    color: #d97c4a;
    margin-bottom: 5px;
}

.stat-label {
    color: #6b5a4c;
    font-size: 14px;
}

.profile-content {
    display: flex;
    flex-direction: column;
    gap: 40px;
}

.profile-section {
    background: white;
    padding: 24px;
    border-radius: 16px;
    border: 1px solid #e0d6cc;
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
}

.section-header h2 {
    color: #4a3729;
    margin: 0;
}

.posts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
}

.post-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    border: 1px solid #e0d6cc;
    transition: transform 0.2s;
}

.post-card:hover {
    transform: translateY(-2px);
}

.post-card__image {
    height: 150px;
    background-color: #f0eae4;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #8b6f5a;
    font-size: 32px;
}

.post-card__content {
    padding: 16px;
}

.post-card__status {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
    margin-bottom: 10px;
}

.status-lost {
    background-color: #fee2e2;
    color: #b91c1c;
}

.status-found {
    background-color: #e6f7e6;
    color: #166534;
}

.post-card__title {
    font-size: 16px;
    margin-bottom: 8px;
    color: #3e2e23;
    font-weight: 600;
}

.post-card__meta {
    font-size: 12px;
    color: #6b5a4c;
    margin-bottom: 12px;
}

.post-card__meta div {
    margin-bottom: 4px;
}

.post-card__meta i {
    color: #d97c4a;
    width: 14px;
    margin-right: 4px;
}

.post-card__actions {
    display: flex;
    gap: 8px;
}

.btn--small {
    padding: 6px 12px;
    font-size: 12px;
}

.empty-state {
    text-align: center;
    padding: 40px 20px;
    color: #6b5a4c;
}

.empty-state i {
    font-size: 48px;
    color: #d97c4a;
    margin-bottom: 20px;
}

.empty-state h3 {
    color: #4a3729;
    margin-bottom: 10px;
}

.empty-state p {
    margin-bottom: 20px;
}

/* Адаптивность */
@media (max-width: 1024px) {
    .profile-grid {
        grid-template-columns: 1fr;
        gap: 30px;
    }

    .posts-grid {
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    }
}

@media (max-width: 768px) {
    .section-header {
        flex-direction: column;
        gap: 15px;
        align-items: flex-start;
    }

    .posts-grid {
        grid-template-columns: 1fr;
    }

    .stats-grid {
        grid-template-columns: 1fr;
    }

    .post-card__actions {
        flex-direction: column;
    }
}
</style>
@endsection