<?php $__env->startSection('title', 'Создание цвета — PetSearch'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="admin-page">
        <div class="page-header">
            <h1>Создание цвета</h1>
            <a href="<?php echo e(route('admin.colors')); ?>" class="btn btn-secondary">← Назад к цветам</a>
        </div>

        <div class="admin-form-container">
            <form method="POST" action="<?php echo e(route('admin.colors.store')); ?>" class="admin-form">
                <?php echo csrf_field(); ?>

                <div class="form-group">
                    <label for="name">Название цвета *</label>
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

                <div class="form-group">
                    <label for="hex_code">Цвет кружка (HEX)</label>
                    <input type="color" id="hex_code" value="<?php echo e(old('hex_code', '#cccccc')); ?>" oninput="document.getElementById('hex_code_text').value = this.value">
                    <input type="text" name="hex_code" id="hex_code_text" value="<?php echo e(old('hex_code', '#cccccc')); ?>" placeholder="#RRGGBB" pattern="^#[A-Fa-f0-9]{6}$">
                    <?php $__errorArgs = ['hex_code'];
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
                    <button type="submit" class="btn btn-primary">Создать цвет</button>
                    <a href="<?php echo e(route('admin.colors')); ?>" class="btn btn-secondary">Отмена</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\OSPanel\home\petsearch_new\resources\views\admin\colors\create.blade.php ENDPATH**/ ?>