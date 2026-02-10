<?php $__env->startSection('title', 'Управление пользователями — PetSearch'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="admin-page">
        <div class="page-header">
            <h1>Управление пользователями</h1>
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-secondary">← Назад в админку</a>
        </div>

        <div class="admin-filters">
            <form method="GET" class="filters-form">
                <div class="filter-group">
                    <label for="search">Поиск по email или имени:</label>
                    <input type="text" name="search" id="search" value="<?php echo e(request('search')); ?>" placeholder="Введите email или имя">
                </div>

                <div class="filter-group">
                    <label for="role">Роль:</label>
                    <select name="role" id="role">
                        <option value="">Все роли</option>
                        <option value="user" <?php echo e(request('role') === 'user' ? 'selected' : ''); ?>>Пользователь</option>
                        <option value="admin" <?php echo e(request('role') === 'admin' ? 'selected' : ''); ?>>Администратор</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="status">Статус:</label>
                    <select name="status" id="status">
                        <option value="">Все статусы</option>
                        <option value="active" <?php echo e(request('status') === 'active' ? 'selected' : ''); ?>>Активные</option>
                        <option value="banned" <?php echo e(request('status') === 'banned' ? 'selected' : ''); ?>>Заблокированные</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Фильтровать</button>
                <a href="<?php echo e(route('admin.users')); ?>" class="btn btn-secondary">Сбросить</a>
            </form>
        </div>

        <div class="admin-table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Имя</th>
                        <th>Email</th>
                        <th>Роль</th>
                        <th>Статус</th>
                        <th>Дата регистрации</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($user->id); ?></td>
                        <td><?php echo e($user->name); ?></td>
                        <td><?php echo e($user->email); ?></td>
                        <td>
                            <span class="role-badge role-<?php echo e($user->role); ?>">
                                <?php echo e($user->role === 'admin' ? 'Администратор' : 'Пользователь'); ?>

                            </span>
                        </td>
                        <td>
                            <?php if($user->banned): ?>
                                <span class="status-badge status-banned">Заблокирован</span>
                            <?php else: ?>
                                <span class="status-badge status-active">Активен</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo e($user->created_at->format('d.m.Y H:i')); ?></td>
                        <td class="actions-cell">
                            <div class="action-buttons">
                                <?php if(!$user->banned): ?>
                                    <form method="POST" action="<?php echo e(route('admin.users.ban', $user)); ?>" class="inline-form">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PATCH'); ?>
                                        <input type="hidden" name="action" value="ban">
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Заблокировать пользователя?')">Заблокировать</button>
                                    </form>
                                <?php else: ?>
                                    <form method="POST" action="<?php echo e(route('admin.users.unban', $user)); ?>" class="inline-form">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PATCH'); ?>
                                        <input type="hidden" name="action" value="unban">
                                        <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Разблокировать пользователя?')">Разблокировать</button>
                                    </form>
                                <?php endif; ?>

                                <?php if($user->role !== 'admin'): ?>
                                    <form method="POST" action="<?php echo e(route('admin.users.make-admin', $user)); ?>" class="inline-form">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PATCH'); ?>
                                        <input type="hidden" name="action" value="make_admin">
                                        <button type="submit" class="btn btn-warning btn-sm" onclick="return confirm('Назначить администратором?')">Сделать админом</button>
                                    </form>
                                <?php elseif($user->id !== auth()->id()): ?>
                                    <form method="POST" action="<?php echo e(route('admin.users.revoke-admin', $user)); ?>" class="inline-form">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PATCH'); ?>
                                        <button type="submit" class="btn btn-secondary btn-sm" onclick="return confirm('Забрать права администратора?')">Забрать администратора</button>
                                    </form>
                                <?php endif; ?>

                                <button type="button" class="btn btn-info btn-sm" onclick="showUserDetails(<?php echo e($user->id); ?>)">Подробно</button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="no-data">Пользователи не найдены</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if($users->hasPages()): ?>
            <div class="pagination">
                <?php echo e($users->appends(request()->query())->links()); ?>

            </div>
        <?php endif; ?>
    </div>
</div>

<div id="userDetailsModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Информация о пользователе</h3>
            <span class="modal-close">&times;</span>
        </div>
        <div class="modal-body" id="userDetailsContent"></div>
    </div>
</div>

<script>
function showUserDetails(userId) {
    fetch(`/admin/users/${userId}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('userDetailsContent').innerHTML = `
                <div class="user-details">
                    <p><strong>ID:</strong> ${data.id}</p>
                    <p><strong>Имя:</strong> ${data.name}</p>
                    <p><strong>Email:</strong> ${data.email}</p>
                    <p><strong>Роль:</strong> ${data.role === 'admin' ? 'Администратор' : 'Пользователь'}</p>
                    <p><strong>Статус:</strong> ${data.banned ? 'Заблокирован' : 'Активен'}</p>
                    <p><strong>Дата регистрации:</strong> ${new Date(data.created_at).toLocaleString('ru-RU')}</p>
                    <p><strong>Последний вход:</strong> ${data.last_login ? new Date(data.last_login).toLocaleString('ru-RU') : 'Неизвестно'}</p>
                    ${data.ban_reason ? `<p><strong>Причина блокировки:</strong> ${data.ban_reason}</p>` : ''}
                </div>
            `;
            document.getElementById('userDetailsModal').style.display = 'block';
        })
        .catch(error => {
            alert('Ошибка загрузки данных пользователя');
        });
}

document.querySelector('.modal-close').addEventListener('click', function() {
    document.getElementById('userDetailsModal').style.display = 'none';
});

window.addEventListener('click', function(event) {
    if (event.target === document.getElementById('userDetailsModal')) {
        document.getElementById('userDetailsModal').style.display = 'none';
    }
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\OSPanel\home\petsearch_new\resources\views\admin\users\index.blade.php ENDPATH**/ ?>