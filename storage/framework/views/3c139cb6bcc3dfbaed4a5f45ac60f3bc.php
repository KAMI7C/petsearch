<?php $__env->startSection('title', 'Редактирование профиля'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="profile-edit-page">
        <div class="page-header">
            <h1>Редактирование профиля</h1>
            <p>Обновите свою личную информацию</p>
        </div>

        <div class="edit-form-container">
            <form method="POST" action="<?php echo e(route('profile.update')); ?>" class="profile-form">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PATCH'); ?>

                <?php if(session('status') === 'profile-updated'): ?>
                    <div class="alert alert--success">
                        <i class="fas fa-check-circle"></i>
                        Профиль успешно обновлен!
                    </div>
                <?php endif; ?>

                <?php if($errors->any()): ?>
                    <div class="alert alert--error">
                        <i class="fas fa-exclamation-triangle"></i>
                        <ul>
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <div class="form-grid">
                    <div class="form-section">
                        <h3>Основная информация</h3>

                        <div class="form-group">
                            <label for="name" class="form-label">Имя *</label>
                            <input type="text" id="name" name="name" value="<?php echo e(old('name', $user->name)); ?>"
                                   class="form-input <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-input--error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="form-error"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label">Email *</label>
                            <input type="email" id="email" name="email" value="<?php echo e(old('email', $user->email)); ?>"
                                   class="form-input <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-input--error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="form-error"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="form-group">
                            <label for="phone" class="form-label">Телефон</label>
                            <input type="tel" id="phone" name="phone" value="<?php echo e(old('phone', $user->phone)); ?>"
                                   class="form-input <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-input--error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   placeholder="+7 (999) 123-45-67">
                            <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="form-error"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3>Дополнительная информация</h3>

                        <div class="form-group">
                            <label for="city" class="form-label">Город</label>
                            <input type="text" id="city" name="city" value="<?php echo e(old('city', $user->city)); ?>"
                                   class="form-input <?php $__errorArgs = ['city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-input--error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   placeholder="Например: Москва">
                            <?php $__errorArgs = ['city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="form-error"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="form-group">
                            <label for="about" class="form-label">О себе</label>
                            <textarea id="about" name="about" class="form-textarea <?php $__errorArgs = ['about'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-textarea--error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                      rows="4" placeholder="Расскажите немного о себе..."><?php echo e(old('about', $user->about)); ?></textarea>
                            <?php $__errorArgs = ['about'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="form-error"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn--primary">
                        <i class="fas fa-save"></i> Сохранить изменения
                    </button>
                    <a href="<?php echo e(route('profile.show')); ?>" class="btn btn--outline">
                        <i class="fas fa-arrow-left"></i> Вернуться в профиль
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.profile-edit-page {
    padding: 40px 0;
    max-width: 1000px;
    margin: 0 auto;
}

.page-header {
    text-align: center;
    margin-bottom: 40px;
}

.page-header h1 {
    color: #4a3729;
    margin-bottom: 10px;
}

.page-header p {
    color: #6b5a4c;
    font-size: 18px;
}

.edit-form-container {
    background: white;
    padding: 32px;
    border-radius: 16px;
    border: 1px solid #e0d6cc;
}

.profile-form {
    width: 100%;
}

.alert {
    padding: 16px;
    border-radius: 8px;
    margin-bottom: 24px;
    display: flex;
    align-items: flex-start;
    gap: 12px;
}

.alert--success {
    background-color: #e6f7e6;
    border: 1px solid #166534;
    color: #166534;
}

.alert--error {
    background-color: #fee2e2;
    border: 1px solid #b91c1c;
    color: #b91c1c;
}

.alert i {
    font-size: 18px;
    margin-top: 2px;
}

.alert ul {
    margin: 0;
    padding-left: 20px;
}

.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 32px;
    margin-bottom: 32px;
}

.form-section h3 {
    color: #4a3729;
    margin-bottom: 24px;
    font-size: 18px;
    border-bottom: 2px solid #f0eae4;
    padding-bottom: 8px;
}

.form-group {
    margin-bottom: 20px;
}

.form-label {
    display: block;
    margin-bottom: 6px;
    color: #4a3729;
    font-weight: 500;
}

.form-input,
.form-textarea {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid #e0d6cc;
    border-radius: 8px;
    font-size: 16px;
    transition: border-color 0.2s;
}

.form-input:focus,
.form-textarea:focus {
    outline: none;
    border-color: #d97c4a;
}

.form-input--error,
.form-textarea--error {
    border-color: #b91c1c;
}

.form-textarea {
    resize: vertical;
    min-height: 100px;
}

.form-error {
    display: block;
    color: #b91c1c;
    font-size: 14px;
    margin-top: 4px;
}

.form-actions {
    display: flex;
    gap: 16px;
    justify-content: center;
    padding-top: 24px;
    border-top: 1px solid #e0d6cc;
}

/* Адаптивность */
@media (max-width: 768px) {
    .form-grid {
        grid-template-columns: 1fr;
        gap: 24px;
    }

    .edit-form-container {
        padding: 24px;
    }

    .form-actions {
        flex-direction: column;
    }

    .form-actions .btn {
        width: 100%;
    }
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\OSPanel\home\petsearch_new\resources\views\profile\edit.blade.php ENDPATH**/ ?>