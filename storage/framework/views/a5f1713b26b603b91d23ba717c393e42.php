

<?php $__env->startSection('title', 'Управление категориями — PetSearch'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="admin-page">
        <div class="page-header">
            <h1>Управление категориями</h1>
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-secondary">← Назад в админку</a>
            <a href="<?php echo e(route('admin.categories.create')); ?>" class="btn btn-primary">Добавить категорию</a>
        </div>

        <!-- Таблица категорий -->
        <div class="admin-table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Название</th>
                        <th>Описание</th>
                        <th>Количество объявлений</th>
                        <th>Дата создания</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($category->id); ?></td>
                        <td><?php echo e($category->name); ?></td>
                        <td><?php echo e($category->description ?? 'Без описания'); ?></td>
                        <td><?php echo e($category->posts_count ?? 0); ?></td>
                        <td><?php echo e($category->created_at->format('d.m.Y H:i')); ?></td>
                        <td class="actions-cell">
                            <div class="action-buttons">
                                <a href="<?php echo e(route('admin.categories.edit', $category)); ?>" class="btn btn-info btn-sm">Редактировать</a>

                                <form method="POST" action="<?php echo e(route('admin.categories.destroy', $category)); ?>" class="inline-form">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Удалить категорию?')">Удалить</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="no-data">Категории не найдены</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Пагинация -->
        <?php if($categories->hasPages()): ?>
            <div class="pagination">
                <?php echo e($categories->links()); ?>

            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\OSPanel\home\petsearch_new\resources\views\admin\categories\index.blade.php ENDPATH**/ ?>