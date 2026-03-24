

<?php $__env->startSection('title', 'О проекте PetSearch'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="about-page">
        <h1 class="about__title">О проекте PetSearch</h1>
        
        <div class="about__card">
            <p class="about__intro">
                PetSearch — это бесплатный сервис, который помогает людям быстро находить потерявшихся питомцев 
                и возвращать их домой.
            </p>
            
            <h2 class="about__subtitle">Как это работает</h2>
            <ul class="about__list">
                <li class="about__list-item">
                    <i class="fas fa-paw about__icon"></i>
                    Разместите объявление о пропавшем или найденном животном
                </li>
                <li class="about__list-item">
                    <i class="fas fa-paw about__icon"></i>
                    Пользователи могут откликнуться, если видели животное
                </li>
                <li class="about__list-item">
                    <i class="fas fa-paw about__icon"></i>
                    Добавляйте объявления в избранное, чтобы не потерять
                </li>
            </ul>
            
            <h2 class="about__subtitle">Правила</h2>
            <ul class="about__rules">
                <li>• Публикуйте только реальные объявления</li>
                <li>• Не указывайте чужие контактные данные</li>
                <li>• Если животное нашлось — закройте объявление</li>
            </ul>
            
            <div class="about__emergency">
                <i class="fas fa-phone-alt about__phone-icon"></i>
                Экстренная помощь: 8 (800) 123-45-67
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\OSPanel\home\petsearch_new\resources\views/about.blade.php ENDPATH**/ ?>