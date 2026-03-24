<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'PetSearch'); ?> — найти друга</title>
    
   
    <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
  
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz@14..32&display=swap" rel="stylesheet">
  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header class="header">
        <div class="container header__inner">
            <a href="<?php echo e(route('home')); ?>" class="logo">
                <i class="fas fa-paw logo__icon"></i>
                <span class="logo__text">PetSearch</span>
            </a>
            
            <nav class="nav">
                <ul class="nav__list">
                    <li class="nav__item"><a href="<?php echo e(route('posts.index')); ?>" class="nav__link">Объявления</a></li>
                    <li class="nav__item"><a href="<?php echo e(route('about')); ?>" class="nav__link">О проекте</a></li>
                    
                    <?php if(auth()->guard()->check()): ?>
                        <li class="nav__item"><a href="<?php echo e(route('posts.create')); ?>" class="nav__link nav__link--accent">+ Добавить</a></li>
                        <li class="nav__item nav__item--dropdown">
                            <span class="nav__link nav__link--user">
                                <i class="far fa-user-circle"></i> <?php echo e(Auth::user()->name); ?>

                            </span>
                            <ul class="dropdown">
                                <li><a href="<?php echo e(route('profile.show')); ?>" class="dropdown__link">Личный кабинет</a></li>
                                <li>
                                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="dropdown__link dropdown__link--logout">Выйти</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav__item"><a href="<?php echo e(route('login')); ?>" class="nav__link">Вход</a></li>
                        <li class="nav__item"><a href="<?php echo e(route('register')); ?>" class="nav__link nav__link--accent">Регистрация</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <?php if(session('success')): ?>
        <div class="alert alert--success container">
            <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <main class="main">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <footer class="footer">
        <div class="container footer__inner">
            <div class="footer__col">
                <h4 class="footer__title">PetSearch</h4>
                <p class="footer__text">Помогаем воссоединять семьи с питомцами с 2026 года</p>
            </div>
            <div class="footer__col">
                <h4 class="footer__title">Навигация</h4>
                <ul class="footer__list">
                    <li><a href="<?php echo e(route('posts.index')); ?>">Все объявления</a></li>
                    <li><a href="<?php echo e(route('about')); ?>">О проекте</a></li>
                    <li><a href="#">Правила</a></li>
                </ul>
            </div>
            <div class="footer__col">
                <h4 class="footer__title">Контакты</h4>
                <p><i class="far fa-envelope"></i> help@petsearch.ru</p>
                <p><i class="fas fa-phone"></i> 8 (800) 123-45-67</p>
            </div>
        </div>
        <div class="footer__bottom">
            <p>© <?php echo e(date('Y')); ?> PetSearch. Сделано с заботой.</p>
        </div>
    </footer>
</body>
</html><?php /**PATH C:\OSPanel\home\petsearch_new\resources\views/layouts/app.blade.php ENDPATH**/ ?>