

<?php $__env->startSection('title', 'Все объявления'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <h1 class="page-title">Все объявления</h1>

    <section class="filters">
        <form action="<?php echo e(route('posts.index')); ?>" method="GET" class="filters__form">
            <div class="form-group filters__top-row">
                <label for="search">Поиск</label>
                <input type="text" id="search" name="search" value="<?php echo e(request('search')); ?>" placeholder="Кличка или описание">
            </div>
            <div class="form-group filters__top-row">
                <label for="status">Статус</label>
                <select id="status" name="status">
                    <option value="">Все</option>
                    <option value="lost" <?php echo e(request('status') == 'lost' ? 'selected' : ''); ?>>Пропал</option>
                    <option value="found" <?php echo e(request('status') == 'found' ? 'selected' : ''); ?>>Найден</option>
                </select>
            </div>
            <div class="form-group filters__top-row">
                <label for="category">Вид</label>
                <select id="category" name="category_id">
                    <option value="">Все</option>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($category->id); ?>" <?php echo e(request('category_id') == $category->id ? 'selected' : ''); ?>>
                            <?php echo e($category->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="form-group filters__top-row">
                <label for="district">Район</label>
                <select id="district" name="district_id">
                    <option value="">Все</option>
                    <?php $__currentLoopData = $districts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $district): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($district->id); ?>" <?php echo e(request('district_id') == $district->id ? 'selected' : ''); ?>>
                            <?php echo e($district->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="form-group filters__top-row">
                <label for="sort">Сортировка</label>
                <select id="sort" name="sort">
                    <option value="latest" <?php echo e(request('sort', 'latest') === 'latest' ? 'selected' : ''); ?>>Новые сначала</option>
                    <option value="oldest" <?php echo e(request('sort') === 'oldest' ? 'selected' : ''); ?>>Старые сначала</option>
                    <option value="popular" <?php echo e(request('sort') === 'popular' ? 'selected' : ''); ?>>По популярности</option>
                </select>
            </div>
            <div class="form-group colors-filter">
                <label>Цвет питомца</label>
                <div class="colors-checkboxes">
                    <?php $__currentLoopData = $colors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <label class="checkbox-label">
                            <input type="checkbox" name="colors[]" value="<?php echo e($color->id); ?>" 
                                <?php echo e(in_array($color->id, (array)request('colors', [])) ? 'checked' : ''); ?>>
                            <span class="color-circle" style="background-color: <?php echo e($color->hex_code ?? '#cccccc'); ?>;"></span>
                            <span class="checkbox-text"><?php echo e($color->name); ?></span>
                        </label>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <button type="submit" class="btn btn--primary filters__btn">Применить</button>
            </div>
        </form>
    </section>

    <div class="main-content">
        <aside class="filters-sidebar">
            <!-- All filters are now in the main form above -->
        </aside>

        <div class="posts-wrapper">
            <div class="posts-grid">
                <?php $__empty_1 = true; $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="post-card">
                        <div class="post-card__image">
                            <i class="fas fa-camera"></i>
                        </div>
                        <div class="post-card__content">
                            <div class="post-card__header">
                                <span class="post-card__status <?php echo e($post->status == 'lost' ? 'status-lost' : 'status-found'); ?>">
                                    <?php echo e($post->status == 'lost' ? 'Пропал' : 'Найден'); ?>

                                </span>
                                <?php if(auth()->guard()->check()): ?>
                                    <form action="<?php echo e(route('posts.favorite', $post)); ?>" method="POST" class="favorite-form post-card__favorite-form">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="post-card__favorite <?php echo e($post->favoritedBy->contains(auth()->id()) ? 'active' : ''); ?>" title="Добавить в избранное">
                                            <i class="fas fa-heart"></i>
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>
                            <h3 class="post-card__title"><?php echo e($post->name ?: 'Без имени'); ?></h3>
                            <div class="post-card__meta">
                                <div><i class="fas fa-paw"></i> <?php echo e($post->category->name); ?></div>
                                <div><i class="fas fa-map-marker-alt"></i> <?php echo e($post->district->name ?? '—'); ?></div>
                                <div><i class="far fa-calendar"></i> <?php echo e($post->lost_date->format('d.m.Y')); ?></div>
                            </div>
                            <?php if($post->colors->count() > 0): ?>
                                <div class="post-card__colors">
                                    <?php $__currentLoopData = $post->colors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="color-item">
                                            <span class="color-circle" title="<?php echo e($color->name); ?>" style="background-color: <?php echo e($color->hex_code ?? '#cccccc'); ?>;"></span>
                                            <span class="color-name"><?php echo e($color->name); ?></span>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php endif; ?>
                            <div class="post-card__actions">
                                <a href="<?php echo e(route('posts.show', $post)); ?>" class="post-card__btn">Подробнее</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="empty-message">Объявлений не найдено</p>
                <?php endif; ?>
            </div>

            <div style="margin: 40px 0;">
                <?php echo e($posts->withQueryString()->links()); ?>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\OSPanel\home\petsearch_new\resources\views/posts/index.blade.php ENDPATH**/ ?>