

<?php $__env->startSection('title', 'Редактировать объявление'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="form-page">
        <h1 class="form-page__title">Редактировать объявление</h1>

        <div class="form-card">
            <form action="<?php echo e(route('posts.update', $post)); ?>" method="POST" enctype="multipart/form-data" class="form">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="form-section">
                    <h2 class="form-section__title">Основная информация</h2>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="status">Статус *</label>
                            <select id="status" name="status" class="form-input" required>
                                <option value="">Выберите статус</option>
                                <option value="lost" <?php echo e($post->status == 'lost' ? 'selected' : ''); ?>>Пропал</option>
                                <option value="found" <?php echo e($post->status == 'found' ? 'selected' : ''); ?>>Найден</option>
                            </select>
                            <?php $__errorArgs = ['status'];
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
                            <label for="lost_date">Дата события *</label>
                            <input type="date" id="lost_date" name="lost_date" class="form-input"
                                   value="<?php echo e(old('lost_date', $post->lost_date->format('Y-m-d'))); ?>" required>
                            <?php $__errorArgs = ['lost_date'];
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

                <div class="form-section">
                    <h2 class="form-section__title">Информация о животном</h2>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="name">Имя (кличка)</label>
                            <input type="text" id="name" name="name" class="form-input"
                                   placeholder="Например, Барсик" value="<?php echo e(old('name', $post->name)); ?>">
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
                            <label for="category_id">Вид животного *</label>
                            <select id="category_id" name="category_id" class="form-input" required>
                                <option value="" disabled <?php echo e(old('category_id', $post->category_id) ? '' : 'selected'); ?>>Выберите вид</option>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($category->id); ?>"
                                            <?php echo e(old('category_id', $post->category_id) == $category->id ? 'selected' : ''); ?>>
                                        <?php echo e($category->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['category_id'];
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

                    <div class="form-row">
                        <div class="form-group">
                            <label for="breed_search">Порода</label>
                            <input type="text" id="breed_search" name="breed_search" class="form-input" list="breed_list"
                                   placeholder="Начните ввод..." value="<?php echo e(old('breed_search', $post->breed?->name)); ?>">
                            <datalist id="breed_list">
                                <?php $__currentLoopData = $breeds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $breed): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($breed->name); ?>" data-category="<?php echo e($breed->category_id); ?>"></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </datalist>
                            <input type="hidden" id="breed_id" name="breed_id" value="<?php echo e(old('breed_id', $post->breed_id)); ?>">
                            <div class="form-hint">Выберите породу из списка, соответствующую виду</div>
                            <?php $__errorArgs = ['breed_id'];
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
                            <label for="gender">Пол</label>
                            <select id="gender" name="gender" class="form-input">
                                <option value="">Выберите пол</option>
                                <option value="male" <?php echo e(old('gender', $post->gender) == 'male' ? 'selected' : ''); ?>>Самец</option>
                                <option value="female" <?php echo e(old('gender', $post->gender) == 'female' ? 'selected' : ''); ?>>Самка</option>
                                <option value="unknown" <?php echo e(old('gender', $post->gender) == 'unknown' ? 'selected' : ''); ?>>Неизвестно</option>
                            </select>
                            <?php $__errorArgs = ['gender'];
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
                            <label for="age">Возраст</label>
                            <select id="age" name="age" class="form-input">
                                <option value="" disabled <?php echo e(old('age', $post->age) ? '' : 'selected'); ?>>Выберите возраст</option>
                                <option value="щенок" <?php echo e(old('age', $post->age) == 'щенок' ? 'selected' : ''); ?>>Детёныш</option>
                                <option value="взрослый" <?php echo e(old('age', $post->age) == 'взрослый' ? 'selected' : ''); ?>>Взрослый</option>
                                <option value="unknown" <?php echo e(old('age', $post->age) == 'unknown' ? 'selected' : ''); ?>>Неизвестно</option>
                            </select>
                            <?php $__errorArgs = ['age'];
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

                    <div class="form-group">
                        <label for="colors">Окрас(ы)</label>
                        <div class="colors-group">
                            <?php $__currentLoopData = $colors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <label class="checkbox-label">
                                    <input type="checkbox" name="colors[]" value="<?php echo e($color->id); ?>"
                                           <?php echo e(in_array($color->id, old('colors', $post->colors->pluck('id')->toArray())) ? 'checked' : ''); ?>

                                           class="checkbox-input">
                                    <span class="checkbox-text"><?php echo e($color->name); ?></span>
                                </label>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <?php $__errorArgs = ['colors'];
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
                        <label for="photos">Фото (изображения)</label>
                        <?php if($post->photos && count($post->photos)): ?>
                            <div class="current-photos" style="margin-bottom: 10px;">
                                <p>Текущие фото:</p>
                                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                                    <?php $__currentLoopData = $post->photos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $photo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <img src="<?php echo e(asset('storage/'.$photo)); ?>" alt="Фото" style="max-width: 100px; height: 100px; object-fit: cover;">
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                                <p>Выберите новые фото, чтобы заменить все текущие.</p>
                            </div>
                        <?php endif; ?>
                        <input type="file" id="photos" name="photos[]" class="form-input" accept="image/*" multiple>
                        <?php $__errorArgs = ['photos'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="form-error"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <?php $__errorArgs = ['photos.*'];
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
                    <h2 class="form-section__title">Место происшествия</h2>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="district_id">Район</label>
                            <select id="district_id" name="district_id" class="form-input">
                                <option value="" disabled <?php echo e(old('district_id', $post->district_id) ? '' : 'selected'); ?>>Неизвестно</option>
                                <?php $__currentLoopData = $districts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $district): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($district->id); ?>"
                                            <?php echo e(old('district_id', $post->district_id) == $district->id ? 'selected' : ''); ?>>
                                        <?php echo e($district->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['district_id'];
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

                <div class="form-section">
                    <h2 class="form-section__title">Описание</h2>

                    <div class="form-group">
                        <label for="description">Описание</label>
                        <textarea id="description" name="description" class="form-input form-textarea"
                                  placeholder="Подробное описание животного, что произошло, особые приметы..."><?php echo e(old('description', $post->description)); ?></textarea>
                        <?php $__errorArgs = ['description'];
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
                        <label for="contact_phone">Ваш номер телефона</label>
                        <input type="tel" id="contact_phone" name="contact_phone" class="form-input"
                               placeholder="+375 (XX) XXX-XX-XX" value="<?php echo e(old('contact_phone', $post->contact_phone)); ?>">
                        <?php $__errorArgs = ['contact_phone'];
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

                <div class="form-actions">
                    <button type="submit" class="btn btn--primary">
                        <i class="fas fa-save"></i> Сохранить изменения
                    </button>
                    <a href="<?php echo e(route('posts.show', $post)); ?>" class="btn btn--outline">
                        <i class="fas fa-times"></i> Отмена
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const breeds = <?php echo json_encode($breeds->toArray(), 15, 512) ?>;

    const categorySelect = document.getElementById('category_id');
    const breedSearchInput = document.getElementById('breed_search');
    const breedIdInput = document.getElementById('breed_id');

    function syncBreedOptions() {
        const selectedCategory = categorySelect.value;
        const dataList = document.getElementById('breed_list');
        dataList.innerHTML = '';

        const options = breeds
            .filter(b => selectedCategory ? String(b.category_id) === selectedCategory : true)
            .map(b => {
                const option = document.createElement('option');
                option.value = b.name;
                option.dataset.category = b.category_id;
                return option;
            });

        options.forEach(o => dataList.appendChild(o));
    }

    categorySelect.addEventListener('change', () => {
        breedSearchInput.value = '';
        breedIdInput.value = '';
        syncBreedOptions();
    });

    breedSearchInput.addEventListener('change', () => {
        const selected = breedSearchInput.value.trim();
        if (!selected) {
            breedIdInput.value = '';
            return;
        }
        const selectedCategory = categorySelect.value;
        const match = breeds.find(b => b.name === selected && (!selectedCategory || String(b.category_id) === selectedCategory));
        if (match) {
            breedIdInput.value = match.id;
        } else {
            breedIdInput.value = '';
            alert('Выберите породу из списка (подходящую для выбранного вида).');
        }
    });

    document.querySelector('form').addEventListener('submit', function(e) {
        if (breedSearchInput.value && !breedIdInput.value) {
            e.preventDefault();
            alert('Выберите доступную породу из списка.');
        }
    });

    window.addEventListener('DOMContentLoaded', syncBreedOptions);
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\OSPanel\home\petsearch_new\resources\views\posts\edit.blade.php ENDPATH**/ ?>