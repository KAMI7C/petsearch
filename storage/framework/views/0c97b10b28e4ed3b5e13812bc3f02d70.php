<?php $__env->startSection('title', 'Управление цветами — PetSearch'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="admin-page">
        <div class="page-header">
            <h1>Управление цветами</h1>
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-secondary">← Назад в админку</a>
            <a href="<?php echo e(route('admin.colors.create')); ?>" class="btn btn-primary">Добавить цвет</a>
        </div>

        <!-- Таблица цветов -->
        <div class="admin-table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Название</th>
                        <th>Отображение</th>
                        <th>Количество объявлений</th>
                        <th>Дата создания</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $colors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($color->id); ?></td>
                        <td><?php echo e($color->name); ?></td>
                        <td>
                            <span class="color-circle" style="background-color: <?php echo e($color->hex_code ?? '#cccccc'); ?>;"></span>
                            <small><?php echo e($color->hex_code ?? '#cccccc'); ?></small>
                        </td>
                        <td><?php echo e($color->posts_count ?? 0); ?></td>
                        <td><?php echo e($color->created_at->format('d.m.Y H:i')); ?></td>
                        <td class="actions-cell">
                            <div class="action-buttons">
                                <a href="<?php echo e(route('admin.colors.edit', $color)); ?>" class="btn btn-info btn-sm">Редактировать</a>

                                <form method="POST" action="<?php echo e(route('admin.colors.destroy', $color)); ?>" class="inline-form">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Удалить цвет?')">Удалить</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="no-data">Цвета не найдены</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Пагинация -->
        <?php if($colors->hasPages()): ?>
            <div class="pagination">
                <?php echo e($colors->links()); ?>

            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\OSPanel\home\petsearch_new\resources\views\admin\colors\index.blade.php ENDPATH**/ ?>