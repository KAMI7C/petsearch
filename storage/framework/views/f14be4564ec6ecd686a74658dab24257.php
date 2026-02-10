

<?php $__env->startSection('title', 'Вход в систему'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="auth-page">
        <div class="auth-card">
            <h1 class="auth-title">Вход в систему</h1>

            <?php if($errors->any()): ?>
                <div class="alert alert--error">
                    <ul>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('login')); ?>" method="POST" class="auth-form">
                <?php echo csrf_field(); ?>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-input"
                           value="<?php echo e(old('email')); ?>" required autofocus>
                </div>

                <div class="form-group">
                    <label for="password">Пароль</label>
                    <input type="password" id="password" name="password" class="form-input" required>
                </div>

                <div class="form-group">
                    <label class="checkbox-label">
                        <input type="checkbox" name="remember" class="checkbox-input">
                        <span class="checkbox-text">Запомнить меня</span>
                    </label>
                </div>

                <button type="submit" class="btn btn--primary btn--full">
                    <i class="fas fa-sign-in-alt"></i> Войти
                </button>
            </form>

            <div class="auth-links">
                <p>Нет аккаунта? <a href="<?php echo e(route('register')); ?>">Зарегистрироваться</a></p>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\OSPanel\home\petsearch_new\resources\views\auth\login.blade.php ENDPATH**/ ?>