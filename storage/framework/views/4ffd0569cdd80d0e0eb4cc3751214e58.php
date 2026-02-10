

<?php $__env->startSection('title', 'Управление породами — PetSearch'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="admin-page">
        <div class="page-header">
            <h1>Управление породами</h1>
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-secondary">← Назад в админку</a>
            <a href="<?php echo e(route('admin.breeds.create')); ?>" class="btn btn-primary">Добавить породу</a>
        </div>

        <!-- Фильтры -->
        <div class="admin-filters">
            <form method="GET" class="filters-form">
                <div class="filter-group">
                    <label for="category">Категория:</label>
                    <select name="category" id="category">
                        <option value="">Все категории</option>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($category->id); ?>" <?php echo e(request('category') == $category->id ? 'selected' : ''); ?>>
                                <?php echo e($category->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Фильтровать</button>
                <a href="<?php echo e(route('admin.breeds')); ?>" class="btn btn-secondary">Сбросить</a>
            </form>
        </div>

        <!-- Таблица пород -->
        <div class="admin-table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Название</th>
                        <th>Категория</th>
                        <th>Количество объявлений</th>
                        <th>Дата создания</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $breeds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $breed): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($breed->id); ?></td>
                        <td><?php echo e($breed->name); ?></td>
                        <td><?php echo e($breed->category->name ?? 'Без категории'); ?></td>
                        <td><?php echo e($breed->posts_count ?? 0); ?></td>
                        <td><?php echo e($breed->created_at->format('d.m.Y H:i')); ?></td>
                        <td class="actions-cell">
                            <div class="action-buttons">
                                <a href="<?php echo e(route('admin.breeds.edit', $breed)); ?>" class="btn btn-info btn-sm">Редактировать</a>

                                <form method="POST" action="<?php echo e(route('admin.breeds.destroy', $breed)); ?>" class="inline-form">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Удалить породу?')">Удалить</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="no-data">Породы не найдены</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Пагинация -->
        <?php if($breeds->hasPages()): ?>
            <div class="pagination">
                <?php echo e($breeds->appends(request()->query())->links()); ?>

            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\OSPanel\home\petsearch_new\resources\views\admin\breeds\index.blade.php ENDPATH**/ ?>