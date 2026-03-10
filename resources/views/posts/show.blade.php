@extends('layouts.app')

@section('title', ($post->name ?: 'Объявление') . ' — PetSearch')

@section('content')
<div class="container">
    <div class="post-detail">
        <!-- Хлебные крошки -->
        <div class="breadcrumb">
            <a href="{{ route('posts.index') }}">Все объявления</a>
            <span class="breadcrumb__separator">/</span>
            <span>{{ $post->name ?: 'Объявление' }}</span>
        </div>

        <div class="post-grid">
            <!-- Основная информация -->
            <div class="post-main">
                <div class="post-image">
                    <i class="fas fa-image"></i>
                    <p>Фото будет добавлено позже</p>
                </div>

                <div class="post-info">
                    <div class="post-header">
                        <div>
                            <span class="post-status {{ $post->status == 'lost' ? 'status-lost' : 'status-found' }}">
                                {{ $post->status == 'lost' ? 'Пропал' : 'Найден' }}
                            </span>
                            <h1 class="post-title">{{ $post->name ?: 'Без имени' }}</h1>
                        </div>
                        @auth
                            @if(Auth::user()->id !== $post->user_id)
                                <button class="btn btn--favorite" onclick="toggleFavorite({{ $post->id }})">
                                    <i class="fas fa-heart"></i>
                                </button>
                            @endif
                        @endauth
                    </div>

                    <div class="post-meta-row">
                        <div class="post-meta-item">
                            <strong>Вид животного:</strong>
                            <span>{{ $post->category->name }}</span>
                        </div>
                        @if($post->breed)
                            <div class="post-meta-item">
                                <strong>Порода:</strong>
                                <span>{{ $post->breed->name }}</span>
                            </div>
                        @endif
                    </div>

                    <div class="post-meta-row">
                        <div class="post-meta-item">
                            <strong>Дата события:</strong>
                            <span>{{ $post->lost_date->format('d.m.Y') }}</span>
                        </div>
                        <div class="post-meta-item">
                            <strong>Опубликовано:</strong>
                            <span>{{ $post->created_at->format('d.m.Y H:i') }}</span>
                        </div>
                    </div>

                    @if($post->gender || $post->age)
                        <div class="post-meta-row">
                            @if($post->gender)
                                <div class="post-meta-item">
                                    <strong>Пол:</strong>
                                    <span>
                                        @if($post->gender == 'male') Самец
                                        @elseif($post->gender == 'female') Самка
                                        @else Неизвестно @endif
                                    </span>
                                </div>
                            @endif
                            @if($post->age)
                                <div class="post-meta-item">
                                    <strong>Возраст:</strong>
                                    <span>{{ $post->age }}</span>
                                </div>
                            @endif
                        </div>
                    @endif

                    @if($post->colors->count())
                        <div class="post-colors">
                            <strong>Окрас:</strong>
                            <div class="colors-tags">
                                @foreach($post->colors as $color)
                                    <span class="color-tag">{{ $color->name }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($post->district)
                        <div class="post-location">
                            <strong><i class="fas fa-map-marker-alt"></i> Местоположение:</strong>
                            <span>{{ $post->district->name }}</span>
                        </div>
                    @endif

                    @if($post->description)
                        <div class="post-description">
                            <h2>Описание</h2>
                            <p>{{ nl2br($post->description) }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Сбоку: Контакты и действия -->
            <aside class="post-sidebar">
                <div class="post-card-contact">
                    <h3>Контактная информация</h3>
                    
                    <div class="contact-author">
                        <div class="author-avatar">
                            <i class="fas fa-user-circle"></i>
                        </div>
                        <div class="author-info">
                            <p class="author-name">{{ $post->user->name }}</p>
                            <p class="author-role">Опубликовано объявление</p>
                        </div>
                    </div>

                    @if($post->contact_phone)
                        <div class="contact-phone">
                            <i class="fas fa-phone"></i>
                            <a href="tel:{{ $post->contact_phone }}">{{ $post->contact_phone }}</a>
                        </div>
                    @endif

                    @if($post->user->email)
                        <div class="contact-email">
                            <i class="fas fa-envelope"></i>
                            <a href="mailto:{{ $post->user->email }}">{{ $post->user->email }}</a>
                        </div>
                    @endif

                    @auth
                        @if(Auth::user()->id === $post->user_id)
                            <div class="post-actions">
                                <a href="{{ route('posts.edit', $post) }}" class="btn btn--secondary btn--block">
                                    Редактировать
                                </a>
                                <form action="{{ route('posts.destroy', $post) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn--danger btn--block"
                                            onclick="return confirm('Вы уверены?')">
                                        Удалить объявление
                                    </button>
                                </form>
                            </div>
                        @endif
                </div>

                @endauth

                <!-- Кнопка для открытия формы ответа -->
                <button id="show-response-form" class="btn btn--primary btn--block" type="button">
                    Откликнуться на объявление
                </button>

                @if($post->responses->count() > 0)
                    <div class="post-responses">
                        <h3>Ответы ({{ $post->responses->count() }})</h3>
                        <div class="responses-list">
                            @foreach($post->responses as $response)
                                <div class="response-item">
                                    <p class="response-author">
                                        {{ $response->responder_name }}
                                        @if($response->isFromRegisteredUser() && $response->user->phone)
                                            <small>({{ $response->user->phone }})</small>
                                        @elseif($response->guest_phone)
                                            <small>({{ $response->guest_phone }})</small>
                                        @endif
                                    </p>
                                    <p class="response-message">{{ $response->message }}</p>
                                    @if($response->preferred_time)
                                        <p class="response-time">Предпочтительное время связи: {{ $response->preferred_time }}</p>
                                    @endif
                                    @if($response->guest_social && !$response->isFromRegisteredUser())
                                        <p class="response-social">Соцсети: {{ $response->guest_social }}</p>
                                    @endif
                                    <p class="response-date">{{ $response->created_at->format('d.m.Y H:i') }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </aside>
        </div>

        <!-- Похожие объявления -->
        <div class="similar-posts">
            <h2>Похожие объявления</h2>
            <div class="posts-grid">
                @forelse($post->category->posts()->where('id', '!=', $post->id)->limit(4)->get() as $similar)
                    <div class="post-card">
                        <div class="post-card__image">
                            <i class="fas fa-camera"></i>
                        </div>
                        <div class="post-card__content">
                            <span class="post-card__status {{ $similar->status == 'lost' ? 'status-lost' : 'status-found' }}">
                                {{ $similar->status == 'lost' ? 'Пропал' : 'Найден' }}
                            </span>
                            <h3 class="post-card__title">{{ $similar->name ?: 'Без имени' }}</h3>
                            <div class="post-card__meta">
                                <div><i class="fas fa-paw"></i> {{ $similar->category->name }}</div>
                                <div><i class="far fa-calendar"></i> {{ $similar->lost_date->format('d.m.Y') }}</div>
                            </div>
                            <a href="{{ route('posts.show', $similar) }}" class="post-card__btn">Подробнее</a>
                        </div>
                    </div>
                @empty
                    <p class="empty-message">Похожих объявлений не найдено</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Форма ответа -->
<div id="response-modal-overlay" class="response-modal-overlay" style="display: none;">
    <div id="response-form-container" class="response-form-container">
        <button type="button" class="response-modal-close" id="response-modal-close">&times;</button>
        <h3>Откликнуться на объявление</h3>
    <form id="response-form" action="#" method="POST">
        @csrf
        <input type="hidden" name="post_id" value="{{ $post->id }}">
        
        @auth
            <!-- Для авторизованных пользователей -->
            <div class="form-group">
                <label for="message">Ваше сообщение:</label>
                <textarea name="message" id="message" required rows="4" placeholder="Опишите, что вы знаете об этом питомце..."></textarea>
            </div>
        @else
            <!-- Для гостей -->
            <div class="form-row">
                <div class="form-group">
                    <label for="guest_name">Ваше имя:</label>
                    <input type="text" name="guest_name" id="guest_name" required>
                </div>
                <div class="form-group">
                    <label for="guest_phone">Телефон:</label>
                    <input type="tel" name="guest_phone" id="guest_phone" required>
                </div>
            </div>
            <div class="form-group">
                <label for="guest_social">Соцсети (VK, Telegram и т.д.):</label>
                <input type="text" name="guest_social" id="guest_social" placeholder="Необязательно">
            </div>
            <div class="form-group">
                <label for="message">Ваше сообщение:</label>
                <textarea name="message" id="message" required rows="4" placeholder="Опишите, что вы знаете об этом питомце..."></textarea>
            </div>
            <div class="form-group">
                <label for="preferred_time">Предпочтительное время связи:</label>
                <input type="text" name="preferred_time" id="preferred_time" placeholder="Например: вечера по будням">
            </div>
        @endauth
        
        <button type="submit" class="btn btn--primary">Отправить отклик</button>
    </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, initializing modal...');
    
    function toggleFavorite(postId) {
        fetch(`/posts/${postId}/favorite`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            document.querySelector('.btn--favorite').classList.toggle('active');
        });
    }

    // Модальное окно формы ответа
    const modalOverlay = document.getElementById('response-modal-overlay');
    const showFormBtn = document.getElementById('show-response-form');
    const closeModalBtn = document.getElementById('response-modal-close');

    console.log('Modal elements:', { modalOverlay, showFormBtn, closeModalBtn });

    if (!modalOverlay || !showFormBtn || !closeModalBtn) {
        console.error('Modal elements not found!');
        return;
    }

    // Перемещаем модальное окно в конец body для правильного позиционирования
    document.body.appendChild(modalOverlay);
    console.log('Modal moved to body end, body children:', document.body.children.length);

    // Принудительно устанавливаем стили
    modalOverlay.style.position = 'fixed';
    modalOverlay.style.top = '0';
    modalOverlay.style.left = '0';
    modalOverlay.style.width = '100%';
    modalOverlay.style.height = '100%';
    modalOverlay.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
    modalOverlay.style.zIndex = '9999';
    modalOverlay.style.display = 'none';
    modalOverlay.style.alignItems = 'center';
    modalOverlay.style.justifyContent = 'center';

    // Стили для контейнера формы
    const formContainer = modalOverlay.querySelector('.response-form-container');
    if (formContainer) {
        formContainer.style.background = 'white';
        formContainer.style.padding = '30px';
        formContainer.style.borderRadius = '16px';
        formContainer.style.border = '1px solid #e0d6cc';
        formContainer.style.maxWidth = '500px';
        formContainer.style.width = '90%';
        formContainer.style.maxHeight = '90vh';
        formContainer.style.overflowY = 'auto';
        formContainer.style.position = 'relative';
        formContainer.style.zIndex = '10000';
    }

    console.log('Modal styles set:', {
        position: modalOverlay.style.position,
        zIndex: modalOverlay.style.zIndex,
        display: modalOverlay.style.display
    });

    console.log('Modal initialized successfully');

    // Открытие модального окна
    showFormBtn.addEventListener('click', function(e) {
        e.preventDefault();
        console.log('Show form button clicked');
        console.log('Modal overlay before:', modalOverlay.style.display);
        modalOverlay.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        console.log('Modal overlay after:', modalOverlay.style.display);
    });

    // Закрытие модального окна
    closeModalBtn.addEventListener('click', function() {
        console.log('Close button clicked');
        modalOverlay.style.display = 'none';
        document.body.style.overflow = '';
    });

    // Закрытие по клику на overlay
    modalOverlay.addEventListener('click', function(e) {
        if (e.target === modalOverlay) {
            console.log('Overlay clicked');
            modalOverlay.style.display = 'none';
            document.body.style.overflow = '';
        }
    });

    // Закрытие по нажатию Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modalOverlay.style.display === 'flex') {
            console.log('Escape pressed');
            modalOverlay.style.display = 'none';
            document.body.style.overflow = '';
        }
    });

    // Обработка формы ответа
    const responseForm = document.getElementById('response-form');
    if (responseForm) {
        responseForm.addEventListener('submit', function(e) {
            e.preventDefault();
            console.log('Form submitted');
            
            const formData = new FormData(this);
            
            fetch('/responses', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Ваш отклик отправлен!');
                    modalOverlay.style.display = 'none';
                    document.body.style.overflow = '';
                    location.reload();
                } else {
                    alert('Ошибка: ' + (data.message || 'Не удалось отправить отклик'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Произошла ошибка при отправке отклика');
            });
        });
    } else {
        console.error('Response form not found!');
    }
});
</script>
@endsection
