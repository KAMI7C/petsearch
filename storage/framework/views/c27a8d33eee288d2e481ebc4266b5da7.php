

<?php $__env->startSection('title', 'Создание района — PetSearch'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="admin-page">
        <div class="page-header">
            <h1>Создание района</h1>
            <a href="<?php echo e(route('admin.districts')); ?>" class="btn btn-secondary">← Назад к районам</a>
        </div>

        <div class="admin-form-container">
            <form method="POST" action="<?php echo e(route('admin.districts.store')); ?>" class="admin-form">
                <?php echo csrf_field(); ?>

                <div class="form-group">
                    <label for="name">Название района *</label>
                    <input type="text" name="name" id="name" value="<?php echo e(old('name')); ?>" required>
                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="error-message"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Создать район</button>
                    <a href="<?php echo e(route('admin.districts')); ?>" class="btn btn-secondary">Отмена</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\OSPanel\home\petsearch_new\resources\views\admin\districts\create.blade.php ENDPATH**/ ?>