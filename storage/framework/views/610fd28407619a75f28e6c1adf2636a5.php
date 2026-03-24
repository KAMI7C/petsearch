

<?php $__env->startSection('title', ($post->name ?: 'Объявление') . ' — PetSearch'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="post-detail">
        <!-- Хлебные крошки -->
        <div class="breadcrumb">
            <a href="<?php echo e(route('posts.index')); ?>">Все объявления</a>
            <span class="breadcrumb__separator">/</span>
            <span><?php echo e($post->name ?: 'Объявление'); ?></span>
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
                            <span class="post-status <?php echo e($post->status == 'lost' ? 'status-lost' : 'status-found'); ?>">
                                <?php echo e($post->status == 'lost' ? 'Пропал' : 'Найден'); ?>

                            </span>
                            <h1 class="post-title"><?php echo e($post->name ?: 'Без имени'); ?></h1>
                        </div>
                        <?php if(auth()->guard()->check()): ?>
                            <?php if(Auth::user()->id !== $post->user_id): ?>
                                <button class="btn btn--favorite <?php echo e($post->favoritedBy->contains(auth()->id()) ? 'active' : ''); ?>" onclick="toggleFavorite(<?php echo e($post->id); ?>)">
                                    <i class="fa<?php echo e($post->favoritedBy->contains(auth()->id()) ? 's' : 'r'); ?> fa-heart"></i>
                                </button>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>

                    <div class="post-meta-row">
                        <div class="post-meta-item">
                            <strong>Вид животного:</strong>
                            <span><?php echo e($post->category->name); ?></span>
                        </div>
                        <?php if($post->breed): ?>
                            <div class="post-meta-item">
                                <strong>Порода:</strong>
                                <span><?php echo e($post->breed->name); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="post-meta-row">
                        <div class="post-meta-item">
                            <strong>Дата события:</strong>
                            <span><?php echo e($post->lost_date->format('d.m.Y')); ?></span>
                        </div>
                        <div class="post-meta-item">
                            <strong>Опубликовано:</strong>
                            <span><?php echo e($post->created_at->format('d.m.Y H:i')); ?></span>
                        </div>
                    </div>

                    <?php if($post->gender || $post->age): ?>
                        <div class="post-meta-row">
                            <?php if($post->gender): ?>
                                <div class="post-meta-item">
                                    <strong>Пол:</strong>
                                    <span>
                                        <?php if($post->gender == 'male'): ?> Самец
                                        <?php elseif($post->gender == 'female'): ?> Самка
                                        <?php else: ?> Неизвестно <?php endif; ?>
                                    </span>
                                </div>
                            <?php endif; ?>
                            <?php if($post->age): ?>
                                <div class="post-meta-item">
                                    <strong>Возраст:</strong>
                                    <span><?php echo e($post->age); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <?php if($post->colors->count()): ?>
                        <div class="post-colors">
                            <strong>Окрас:</strong>
                            <div class="colors-tags">
                                <?php $__currentLoopData = $post->colors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="color-tag"><?php echo e($color->name); ?></span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if($post->district): ?>
                        <div class="post-location">
                            <strong><i class="fas fa-map-marker-alt"></i> Местоположение:</strong>
                            <span><?php echo e($post->district->name); ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if($post->description): ?>
                        <div class="post-description">
                            <h2>Описание</h2>
                            <p><?php echo e(nl2br($post->description)); ?></p>
                        </div>
                    <?php endif; ?>
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
                            <p class="author-name"><?php echo e($post->user->name); ?></p>
                            <p class="author-role">Опубликовано объявление</p>
                        </div>
                    </div>

                    <?php if($post->contact_phone): ?>
                        <div class="contact-phone">
                            <i class="fas fa-phone"></i>
                            <a href="tel:<?php echo e($post->contact_phone); ?>"><?php echo e($post->contact_phone); ?></a>
                        </div>
                    <?php endif; ?>

                    <?php if($post->user->email): ?>
                        <div class="contact-email">
                            <i class="fas fa-envelope"></i>
                            <a href="mailto:<?php echo e($post->user->email); ?>"><?php echo e($post->user->email); ?></a>
                        </div>
                    <?php endif; ?>

                    <?php if(auth()->guard()->check()): ?>
                        <?php if(Auth::user()->id === $post->user_id): ?>
                            <div class="post-actions">
                                <a href="<?php echo e(route('posts.edit', $post)); ?>" class="btn btn--secondary btn--block">
                                    Редактировать
                                </a>
                                <form action="<?php echo e(route('posts.destroy', $post)); ?>" method="POST" style="display: inline;">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn--danger btn--block"
                                            onclick="return confirm('Вы уверены?')">
                                        Удалить объявление
                                    </button>
                                </form>
                            </div>
                        <?php endif; ?>
                </div>

                <?php endif; ?>

                <!-- Кнопка для открытия формы ответа -->
                <button id="show-response-form" class="btn btn--primary btn--block" type="button">
                    Откликнуться на объявление
                </button>

                <?php if($post->responses->count() > 0): ?>
                    <div class="post-responses">
                        <h3>Ответы (<?php echo e($post->responses->count()); ?>)</h3>
                        <div class="responses-list">
                            <?php $__currentLoopData = $post->responses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $response): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="response-item">
                                    <p class="response-author">
                                        <?php echo e($response->responder_name); ?>

                                        <?php if($response->isFromRegisteredUser() && $response->user->phone): ?>
                                            <small>(<?php echo e($response->user->phone); ?>)</small>
                                        <?php elseif($response->guest_phone): ?>
                                            <small>(<?php echo e($response->guest_phone); ?>)</small>
                                        <?php endif; ?>
                                    </p>
                                    <p class="response-message"><?php echo e($response->message); ?></p>
                                    <?php if($response->preferred_time): ?>
                                        <p class="response-time">Предпочтительное время связи: <?php echo e($response->preferred_time); ?></p>
                                    <?php endif; ?>
                                    <?php if($response->guest_social && !$response->isFromRegisteredUser()): ?>
                                        <p class="response-social">Соцсети: <?php echo e($response->guest_social); ?></p>
                                    <?php endif; ?>
                                    <p class="response-date"><?php echo e($response->created_at->format('d.m.Y H:i')); ?></p>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                <?php endif; ?>
            </aside>
        </div>

        <!-- Похожие объявления -->
        <div class="similar-posts">
            <h2>Похожие объявления</h2>
            <div class="posts-grid">
                <?php $__empty_1 = true; $__currentLoopData = $post->category->posts()->where('id', '!=', $post->id)->limit(4)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $similar): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="post-card">
                        <div class="post-card__image">
                            <i class="fas fa-camera"></i>
                        </div>
                        <div class="post-card__content">
                            <span class="post-card__status <?php echo e($similar->status == 'lost' ? 'status-lost' : 'status-found'); ?>">
                                <?php echo e($similar->status == 'lost' ? 'Пропал' : 'Найден'); ?>

                            </span>
                            <h3 class="post-card__title"><?php echo e($similar->name ?: 'Без имени'); ?></h3>
                            <div class="post-card__meta">
                                <div><i class="fas fa-paw"></i> <?php echo e($similar->category->name); ?></div>
                                <div><i class="far fa-calendar"></i> <?php echo e($similar->lost_date->format('d.m.Y')); ?></div>
                            </div>
                            <a href="<?php echo e(route('posts.show', $similar)); ?>" class="post-card__btn">Подробнее</a>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="empty-message">Похожих объявлений не найдено</p>
                <?php endif; ?>
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
        <?php echo csrf_field(); ?>
        <input type="hidden" name="post_id" value="<?php echo e($post->id); ?>">
        
        <?php if(auth()->guard()->check()): ?>
            <!-- Для авторизованных пользователей -->
            <div class="form-group">
                <label for="message">Ваше сообщение:</label>
                <textarea name="message" id="message" required rows="4" placeholder="Опишите, что вы знаете об этом питомце..."></textarea>
            </div>
        <?php else: ?>
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
        <?php endif; ?>
        
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

    function clearFormErrors(form) {
        form.querySelectorAll('.form-error').forEach(el => el.remove());
    }

    function showFormError(input, message) {
        const error = document.createElement('div');
        error.className = 'form-error';
        error.innerText = message;
        input.closest('.form-group')?.appendChild(error) || input.parentElement?.appendChild(error);
    }

    function validateResponseForm(form) {
        clearFormErrors(form);
        let valid = true;

        const message = form.querySelector('[name="message"]');
        if (!message || !message.value.trim()) {
            showFormError(message || form, 'Пожалуйста, укажите сообщение.');
            valid = false;
        }

        const guestName = form.querySelector('[name="guest_name"]');
        const guestPhone = form.querySelector('[name="guest_phone"]');

        if (guestName) {
            const nameValue = guestName.value.trim();
            const nameDigits = /\d/;
            if (!nameValue) {
                showFormError(guestName, 'Пожалуйста, укажите имя.');
                valid = false;
            } else if (nameDigits.test(nameValue)) {
                showFormError(guestName, 'Имя не должно содержать цифр.');
                valid = false;
            }
        }

        if (guestPhone) {
            const phone = guestPhone.value.trim();
            const phoneRegex = /^\+?[0-9\s\-()]{6,}$/;
            if (!phone) {
                showFormError(guestPhone, 'Пожалуйста, укажите телефон.');
                valid = false;
            } else if (!phoneRegex.test(phone)) {
                showFormError(guestPhone, 'Формат телефона некорректный.');
                valid = false;
            }
        }

        return valid;
    }

    if (responseForm) {
        responseForm.addEventListener('submit', function(e) {
            e.preventDefault();
            if (!validateResponseForm(this)) {
                console.warn('Validation failed');
                return;
            }

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

// Функция для добавления/удаления из избранного
function toggleFavorite(postId) {
    const button = document.querySelector('.btn--favorite');
    const icon = button.querySelector('i');

    fetch(`/posts/${postId}/favorite`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (data.isFavorited) {
                button.classList.add('active');
                icon.classList.remove('far');
                icon.classList.add('fas');
            } else {
                button.classList.remove('active');
                icon.classList.remove('fas');
                icon.classList.add('far');
            }
        } else {
            alert(data.message || 'Ошибка при изменении избранного');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Ошибка при изменении избранного');
    });
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\OSPanel\home\petsearch_new\resources\views/posts/show.blade.php ENDPATH**/ ?>