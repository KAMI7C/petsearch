

<?php $__env->startSection('title', 'Регистрация'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="auth-page">
        <div class="auth-card">
            <h1 class="auth-title">Регистрация</h1>

            <?php if($errors->any()): ?>
                <div class="alert alert--error">
                    <ul>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('register')); ?>" method="POST" class="auth-form">
                <?php echo csrf_field(); ?>

                <div class="form-group">
                    <label for="name">Имя</label>
                    <input type="text" id="name" name="name" class="form-input"
                           value="<?php echo e(old('name')); ?>" required>
                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="form-error"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-input"
                           value="<?php echo e(old('email')); ?>" required>
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="form-error"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-group">
                    <label for="password">Пароль</label>
                    <input type="password" id="password" name="password" class="form-input" required>
                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="form-error"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Подтверждение пароля</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" required>
                    <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="form-error"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <button type="submit" class="btn btn--primary btn--full">
                    <i class="fas fa-user-plus"></i> Зарегистрироваться
                </button>
            </form>

            <div class="auth-links">
                <p>Уже есть аккаунт? <a href="<?php echo e(route('login')); ?>">Войти</a></p>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('.auth-form');
    if (!form) return;

    function setErrorMessage(input, message) {
        input.setCustomValidity(message);
        input.reportValidity();
    }

    function clearErrorMessage(input) {
        input.setCustomValidity('');
    }

    const nameInput = form.querySelector('#name');
    const emailInput = form.querySelector('#email');
    const passwordInput = form.querySelector('#password');
    const confirmInput = form.querySelector('#password_confirmation');

    if (nameInput) {
        nameInput.addEventListener('input', function () {
            clearErrorMessage(this);
        });
        nameInput.addEventListener('invalid', function (e) {
            e.preventDefault();
            if (!this.value.trim()) {
                setErrorMessage(this, 'Пожалуйста, введите ваше имя.');
            } else if (/[0-9]/.test(this.value)) {
                setErrorMessage(this, 'Имя не должно содержать цифры.');
            }
        });
    }

    if (emailInput) {
        emailInput.addEventListener('input', function () {
            clearErrorMessage(this);
        });
        emailInput.addEventListener('invalid', function (e) {
            e.preventDefault();
            if (!this.value.trim()) {
                setErrorMessage(this, 'Пожалуйста, введите ваш email.');
            } else {
                setErrorMessage(this, 'Пожалуйста, введите корректный email.');
            }
        });
    }

    if (passwordInput) {
        passwordInput.addEventListener('input', function () {
            clearErrorMessage(this);
        });
        passwordInput.addEventListener('invalid', function (e) {
            e.preventDefault();
            if (!this.value.trim()) {
                setErrorMessage(this, 'Пожалуйста, введите пароль.');
            }
        });
    }

    if (confirmInput) {
        confirmInput.addEventListener('input', function () {
            clearErrorMessage(this);
            if (passwordInput && this.value !== passwordInput.value) {
                setErrorMessage(this, 'Пароли не совпадают.');
            }
        });
        confirmInput.addEventListener('invalid', function (e) {
            e.preventDefault();
            if (!this.value.trim()) {
                setErrorMessage(this, 'Пожалуйста, подтвердите пароль.');
            }
        });
    }

    form.addEventListener('submit', function (e) {
        if (passwordInput && confirmInput && passwordInput.value !== confirmInput.value) {
            e.preventDefault();
            setErrorMessage(confirmInput, 'Пароли не совпадают.');
            return;
        }
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\OSPanel\home\petsearch_new\resources\views/auth/register.blade.php ENDPATH**/ ?>