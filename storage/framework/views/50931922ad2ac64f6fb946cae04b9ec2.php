

<?php $__env->startSection('title', 'PetSearch — главная'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <section class="hero">
        <div class="hero__content">
            <h1 class="hero__title">Потеряли питомца?</h1>
            <p class="hero__subtitle">PetSearch помогает находить потерянных животных и возвращать их домой</p>
            <div class="hero__buttons">
                <a href="<?php echo e(route('posts.create')); ?>?status=lost" class="btn btn--primary">
                    <i class="fas fa-exclamation-triangle"></i> Я потерял(а)
                </a>
                <a href="<?php echo e(route('posts.create')); ?>?status=found" class="btn btn--outline">
                    <i class="fas fa-heart"></i> Я нашёл(ла)
                </a>
            </div>
        </div>
        <div class="hero__image">
            <img src="<?php echo e(asset('images/hero-pet.png')); ?>" alt="Потерянный питомец" class="hero__img">
        </div>
    </section>

    <section class="filters">
        <form action="<?php echo e(route('posts.index')); ?>" method="GET" class="filters__form">
            <div class="form-group">
                <label for="search">Кличка</label>
                <input type="text" id="search" name="search" placeholder="Например, Барсик">
            </div>
            <div class="form-group">
                <label for="category">Вид</label>
                <select id="category" name="category_id">
                    <option value="">Все</option>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="form-group">
                <label for="district">Район</label>
                <select id="district" name="district_id">
                    <option value="">Все</option>
                    <?php $__currentLoopData = $districts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $district): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($district->id); ?>"><?php echo e($district->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <button type="submit" class="btn btn--primary">Найти</button>
        </form>
    </section>

    <section>
        <h2 class="section-title">Последние объявления</h2>
        <div class="posts-grid">
            <?php $__empty_1 = true; $__currentLoopData = $recentPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="post-card">
                    <div class="post-card__image">
                        <?php if($post->photos && count($post->photos)): ?>
                            <img src="<?php echo e(asset('storage/'.$post->photos[0])); ?>" alt="<?php echo e($post->name ?: 'Фото объявления'); ?>">
                        <?php else: ?>
                            <i class="fas fa-camera"></i>
                        <?php endif; ?>
                    </div>
                    <div class="post-card__content">
                        <span class="post-card__status <?php echo e($post->status == 'lost' ? 'status-lost' : 'status-found'); ?>">
                            <?php echo e($post->status == 'lost' ? 'Пропал' : 'Найден'); ?>

                        </span>
                        <h3 class="post-card__title"><?php echo e($post->name ?: 'Без имени'); ?></h3>
                        <div class="post-card__meta">
                            <div><i class="fas fa-paw"></i> <?php echo e($post->category->name); ?></div>
                            <div><i class="fas fa-map-marker-alt"></i> <?php echo e($post->district->name ?? '—'); ?></div>
                            <div><i class="far fa-calendar"></i> <?php echo e($post->lost_date->format('d.m.Y')); ?></div>
                        </div>
                        <a href="<?php echo e(route('posts.show', $post)); ?>" class="post-card__btn">Подробнее</a>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="empty-message">Пока нет объявлений</p>
            <?php endif; ?>
        </div>
    </section>

    <section class="stats-grid">
        <div class="stat-card">
            <div class="stat-card__number"><?php echo e($stats['total']); ?></div>
            <div class="stat-card__label">Всего объявлений</div>
        </div>
        <div class="stat-card">
            <div class="stat-card__number"><?php echo e($stats['lost']); ?></div>
            <div class="stat-card__label">Ищут хозяев</div>
        </div>
        <div class="stat-card">
            <div class="stat-card__number"><?php echo e($stats['found']); ?></div>
            <div class="stat-card__label">Найдены</div>
        </div>
        <div class="stat-card">
            <div class="stat-card__number"><?php echo e($stats['users']); ?></div>
            <div class="stat-card__label">Пользователей</div>
        </div>
    </section>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\OSPanel\home\petsearch_new\resources\views/home.blade.php ENDPATH**/ ?>