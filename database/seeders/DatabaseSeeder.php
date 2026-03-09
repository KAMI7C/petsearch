<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Breed;
use App\Models\City;
use App\Models\District;
use App\Models\Color;
use App\Models\Post;
use App\Models\Response;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Создаем пользователей
        $admin = User::create([
            'name' => 'Администратор',
            'email' => 'admin@petsearch.ru',
            'password' => Hash::make('password'),
            'phone' => '+375 29 123-45-67',
            'social' => 'https://t.me/admin_petsearch',
            'role' => 'admin',
            'banned' => false,
        ]);

        $user1 = User::create([
            'name' => 'Анна Петрова',
            'email' => 'anna@mail.ru',
            'password' => Hash::make('password'),
            'phone' => '+375 29 888-77-66',
            'social' => 'https://t.me/anna_pet',
            'role' => 'user',
            'banned' => false,
        ]);

        $user2 = User::create([
            'name' => 'Иван Сидоров',
            'email' => 'ivan@mail.ru',
            'password' => Hash::make('password'),
            'phone' => '+375 29 555-44-33',
            'social' => 'https://vk.com/ivan_s',
            'role' => 'user',
            'banned' => false,
        ]);

        $user3 = User::create([
            'name' => 'Мария Иванова',
            'email' => 'maria@mail.ru',
            'password' => Hash::make('password'),
            'phone' => '+375 29 222-33-44',
            'social' => 'https://t.me/maria',
            'role' => 'user',
            'banned' => false,
        ]);

        // 2. Создаем города (НОВОЕ)
        $cities = [
            ['name' => 'Минск', 'region' => 'Минская область'],
            ['name' => 'Москва', 'region' => 'Московская область'],
            ['name' => 'Санкт-Петербург', 'region' => 'Ленинградская область'],
            ['name' => 'Гомель', 'region' => 'Гомельская область'],
            ['name' => 'Брест', 'region' => 'Брестская область'],
        ];

        foreach ($cities as $cityData) {
            City::create($cityData);
        }

        // 3. Категории (виды животных)
        $categories = [
            ['name' => 'Кошка', 'icon' => 'cat.svg'],
            ['name' => 'Собака', 'icon' => 'dog.svg'],
            ['name' => 'Птица', 'icon' => 'bird.svg'],
            ['name' => 'Грызун', 'icon' => 'rodent.svg'],
            ['name' => 'Другое', 'icon' => 'other.svg'],
        ];

        foreach ($categories as $catData) {
            Category::create($catData);
        }

        // 4. Цвета
        $colors = [
            ['name' => 'Белый', 'hex_code' => '#FFFFFF'],
            ['name' => 'Черный', 'hex_code' => '#000000'],
            ['name' => 'Рыжий', 'hex_code' => '#FF4500'],
            ['name' => 'Серый', 'hex_code' => '#808080'],
            ['name' => 'Коричневый', 'hex_code' => '#8B4513'],
            ['name' => 'Пятнистый', 'hex_code' => null],
            ['name' => 'Полосатый', 'hex_code' => null],
            ['name' => 'Трехцветный', 'hex_code' => null],
            ['name' => 'Голубой', 'hex_code' => '#87CEEB'],
            ['name' => 'Зеленый', 'hex_code' => '#008000'],
            ['name' => 'Розовый', 'hex_code' => '#FFC0CB'],
            ['name' => 'Золотистый', 'hex_code' => '#FFD700'],
        ];

        foreach ($colors as $colorData) {
            Color::create($colorData);
        }

        // 5. Районы с привязкой к городам (ОБНОВЛЕНО)
        $minsk = City::where('name', 'Минск')->first();
        $moscow = City::where('name', 'Москва')->first();
        $spb = City::where('name', 'Санкт-Петербург')->first();
        $gomel = City::where('name', 'Гомель')->first();

        $districts = [
            // Минск
            ['name' => 'Центральный', 'city_id' => $minsk->id],
            ['name' => 'Советский', 'city_id' => $minsk->id],
            ['name' => 'Первомайский', 'city_id' => $minsk->id],
            ['name' => 'Партизанский', 'city_id' => $minsk->id],
            ['name' => 'Заводской', 'city_id' => $minsk->id],
            ['name' => 'Ленинский', 'city_id' => $minsk->id],
            ['name' => 'Октябрьский', 'city_id' => $minsk->id],
            ['name' => 'Московский', 'city_id' => $minsk->id],
            ['name' => 'Фрунзенский', 'city_id' => $minsk->id],
            // Москва
            ['name' => 'Центральный', 'city_id' => $moscow->id],
            ['name' => 'Северный', 'city_id' => $moscow->id],
            ['name' => 'Южный', 'city_id' => $moscow->id],
            ['name' => 'Западный', 'city_id' => $moscow->id],
            ['name' => 'Восточный', 'city_id' => $moscow->id],
            // СПб
            ['name' => 'Адмиралтейский', 'city_id' => $spb->id],
            ['name' => 'Василеостровский', 'city_id' => $spb->id],
            ['name' => 'Петроградский', 'city_id' => $spb->id],
            // Гомель
            ['name' => 'Центральный', 'city_id' => $gomel->id],
            ['name' => 'Железнодорожный', 'city_id' => $gomel->id],
            ['name' => 'Новобелицкий', 'city_id' => $gomel->id],
            ['name' => 'Советский', 'city_id' => $gomel->id],
        ];

        foreach ($districts as $distData) {
            District::create($distData);
        }

        // 6. Породы
        $catCategory = Category::where('name', 'Кошка')->first();
        $dogCategory = Category::where('name', 'Собака')->first();
        $birdCategory = Category::where('name', 'Птица')->first();
        $rodentCategory = Category::where('name', 'Грызун')->first();

        $breeds = [
            // Кошки
            ['category_id' => $catCategory->id, 'name' => 'Британская', 'is_verified' => true],
            ['category_id' => $catCategory->id, 'name' => 'Мейн-кун', 'is_verified' => true],
            ['category_id' => $catCategory->id, 'name' => 'Сиамская', 'is_verified' => true],
            ['category_id' => $catCategory->id, 'name' => 'Персидская', 'is_verified' => true],
            ['category_id' => $catCategory->id, 'name' => 'Сфинкс', 'is_verified' => true],
            ['category_id' => $catCategory->id, 'name' => 'Дворовая', 'is_verified' => true],
            // Собаки
            ['category_id' => $dogCategory->id, 'name' => 'Спаниель', 'is_verified' => true],
            ['category_id' => $dogCategory->id, 'name' => 'Лабрадор', 'is_verified' => true],
            ['category_id' => $dogCategory->id, 'name' => 'Овчарка', 'is_verified' => true],
            ['category_id' => $dogCategory->id, 'name' => 'Хаски', 'is_verified' => true],
            ['category_id' => $dogCategory->id, 'name' => 'Такса', 'is_verified' => true],
            ['category_id' => $dogCategory->id, 'name' => 'Дворняга', 'is_verified' => true],
            // Птицы
            ['category_id' => $birdCategory->id, 'name' => 'Волнистый попугай', 'is_verified' => true],
            ['category_id' => $birdCategory->id, 'name' => 'Канарейка', 'is_verified' => true],
            ['category_id' => $birdCategory->id, 'name' => 'Корелла', 'is_verified' => true],
            // Грызуны
            ['category_id' => $rodentCategory->id, 'name' => 'Хомяк', 'is_verified' => true],
            ['category_id' => $rodentCategory->id, 'name' => 'Морская свинка', 'is_verified' => true],
            ['category_id' => $rodentCategory->id, 'name' => 'Шиншилла', 'is_verified' => true],
        ];

        foreach ($breeds as $breedData) {
            Breed::create($breedData);
        }

        // 7. Создаем объявления
        $districts = District::all();
        $breeds = Breed::all();
        $colors = Color::all();
        
        // Пропавший кот Барсик
        $lostCat = Post::create([
            'user_id' => $user1->id,
            'status' => 'lost',
            'category_id' => $catCategory->id,
            'breed_id' => $breeds->where('name', 'Британская')->first()->id,
            'district_id' => $districts->where('name', 'Центральный')->where('city_id', $minsk->id)->first()->id,
            'name' => 'Барсик',
            'gender' => 'male',
            'age' => 'взрослый',
            'description' => 'Серый полосатый кот, очень пушистый, зеленые глаза. Отзывается на имя Барсик. Особые приметы: белое пятно на груди и белые "носочки" на лапах. Был в ошейнике синего цвета с жетоном. Очень домашний, на улице боится собак и машин.',
            'lost_date' => '2026-02-20',
            'photo' => null,
            'contact_phone' => '+375 29 888-77-66',
            'is_active' => true,
            'views' => 45,
        ]);

        $lostCat->colors()->attach([
            $colors->where('name', 'Серый')->first()->id,
            $colors->where('name', 'Белый')->first()->id,
        ]);

        // Найденная собака Бим
        $foundDog = Post::create([
            'user_id' => $user2->id,
            'status' => 'found',
            'category_id' => $dogCategory->id,
            'breed_id' => $breeds->where('name', 'Спаниель')->first()->id,
            'district_id' => $districts->where('name', 'Советский')->where('city_id', $minsk->id)->first()->id,
            'name' => 'Бим',
            'gender' => 'male',
            'age' => 'взрослый',
            'description' => 'Найден спаниель рыжего цвета с белым пятном на груди. Очень ласковый, сразу подбежал к людям. При осмотре обнаружены следы старой травмы на левой задней лапе. Скорее всего, потерялся недавно - чистый и ухоженный. Ждет хозяина, временно находится у нас дома.',
            'lost_date' => '2026-02-19',
            'photo' => null,
            'contact_phone' => '+375 29 555-44-33',
            'is_active' => true,
            'views' => 78,
        ]);

        $foundDog->colors()->attach([
            $colors->where('name', 'Рыжий')->first()->id,
            $colors->where('name', 'Белый')->first()->id,
        ]);

        // Пропавший попугай Кеша
        $lostBird = Post::create([
            'user_id' => $user1->id,
            'status' => 'lost',
            'category_id' => $birdCategory->id,
            'breed_id' => $breeds->where('name', 'Волнистый попугай')->first()->id,
            'district_id' => $districts->where('name', 'Московский')->where('city_id', $minsk->id)->first()->id,
            'name' => 'Кеша',
            'gender' => 'male',
            'age' => 'взрослый',
            'description' => 'Улетел волнистый попугайчик зеленого цвета. Особые приметы: правая лапка немного повреждена (сломанный коготь). Очень ручной, садится на руки. Может говорить слово "Кеша". Улетел в открытое окно, возможно, находится где-то в соседних дворах.',
            'lost_date' => '2026-02-15',
            'photo' => null,
            'contact_phone' => '+375 29 888-77-66',
            'is_active' => true,
            'views' => 32,
        ]);

        $lostBird->colors()->attach([
            $colors->where('name', 'Зеленый')->first()->id,
        ]);

        // Пропавшая кошка Муся
        $lostCat2 = Post::create([
            'user_id' => $user3->id,
            'status' => 'lost',
            'category_id' => $catCategory->id,
            'breed_id' => $breeds->where('name', 'Дворовая')->first()->id,
            'district_id' => $districts->where('name', 'Фрунзенский')->where('city_id', $minsk->id)->first()->id,
            'name' => 'Муся',
            'gender' => 'female',
            'age' => 'взрослый',
            'description' => 'Трехцветная кошка (белый, рыжий, черный). Очень пугливая, к чужим не подходит. На левом ухе маленькая залысина от старой травмы. Стерилизована. Убежала из дома 3 дня назад, очень скучаем.',
            'lost_date' => '2026-02-22',
            'photo' => null,
            'contact_phone' => '+375 29 222-33-44',
            'is_active' => true,
            'views' => 12,
        ]);

        $lostCat2->colors()->attach([
            $colors->where('name', 'Белый')->first()->id,
            $colors->where('name', 'Рыжий')->first()->id,
            $colors->where('name', 'Черный')->first()->id,
        ]);

        // Найден хомяк
        $foundHamster = Post::create([
            'user_id' => $user2->id,
            'status' => 'found',
            'category_id' => $rodentCategory->id,
            'breed_id' => $breeds->where('name', 'Хомяк')->first()->id,
            'district_id' => $districts->where('name', 'Первомайский')->where('city_id', $minsk->id)->first()->id,
            'name' => null,
            'gender' => 'unknown',
            'age' => 'щенок',
            'description' => 'Найден маленький хомячок в подъезде. Рыже-белого окраса, очень активный. Временно в коробке с опилками. Ищем старых или новых хозяев.',
            'lost_date' => '2026-02-23',
            'photo' => null,
            'contact_phone' => '+375 29 555-44-33',
            'is_active' => true,
            'views' => 8,
        ]);

        $foundHamster->colors()->attach([
            $colors->where('name', 'Рыжий')->first()->id,
            $colors->where('name', 'Белый')->first()->id,
        ]);

        // 8. Создаем отклики (ОБНОВЛЕНО с разделением на авторизованных и гостей)
        
        // Отклик от авторизованного пользователя (user_id заполнен, guest_* = null)
        Response::create([
            'user_id' => $user2->id,
            'post_id' => $lostCat->id,
            'guest_name' => null,
            'guest_phone' => null,
            'guest_social' => null,
            'message' => 'Видел похожего кота вчера в парке около пруда. Сидел на дереве и мяукал. Когда подошел поближе - убежал в сторону домов на улице Ленина.',
            'preferred_time' => 'вечер',
            'status' => 'pending',
            'is_archived' => false,
        ]);

        // Отклик от гостя (user_id = null, заполнены guest_* поля)
        Response::create([
            'user_id' => null,
            'post_id' => $foundDog->id,
            'guest_name' => 'Елена',
            'guest_phone' => '+375 29 111-22-33',
            'guest_social' => null,
            'message' => 'Здравствуйте! Кажется, это собака моей соседки. У нее недавно потерялся спаниель по кличке Бим. Можете связаться со мной для уточнения деталей? Я могу показать фото соседкиной собаки.',
            'preferred_time' => 'в любое время до 21:00',
            'status' => 'contacted',
            'is_archived' => false,
        ]);

        // Отклик от авторизованного пользователя
        Response::create([
            'user_id' => $user1->id,
            'post_id' => $foundDog->id,
            'guest_name' => null,
            'guest_phone' => null,
            'guest_social' => null,
            'message' => 'Очень похож на нашего пропавшего спаниеля! Мы уже потеряли надежду. Есть возможность встретиться и посмотреть на него? Мы можем приехать в любое удобное для вас время.',
            'preferred_time' => 'завтра после 15:00',
            'status' => 'pending',
            'is_archived' => false,
        ]);

        // Отклик от гостя с соцсетью
        Response::create([
            'user_id' => null,
            'post_id' => $lostBird->id,
            'guest_name' => 'Дмитрий',
            'guest_phone' => null,
            'guest_social' => 'https://t.me/dmitry_birds',
            'message' => 'Видел зеленого попугайчика в сквере на Западной улице. Пытался подойти, но он улетел в сторону парка. Там много деревьев, возможно, он там.',
            'preferred_time' => 'утро',
            'status' => 'pending',
            'is_archived' => false,
        ]);

        // Отклик от авторизованного пользователя
        Response::create([
            'user_id' => $user3->id,
            'post_id' => $lostCat2->id,
            'guest_name' => null,
            'guest_phone' => null,
            'guest_social' => null,
            'message' => 'Держитесь! Мы тоже ищем свою кошку уже неделю. Напишу в наш чат соседей, может кто-то видел вашу Мусю.',
            'preferred_time' => null,
            'status' => 'pending',
            'is_archived' => false,
        ]);

        // 9. Добавляем в избранное
        $user1->favoritePosts()->attach([$foundDog->id, $foundHamster->id]);
        $user2->favoritePosts()->attach([$lostCat->id, $lostBird->id, $lostCat2->id]);
        $user3->favoritePosts()->attach([$foundDog->id, $lostCat->id]);

        $this->command->info('🎉 База данных PetSearch успешно заполнена тестовыми данными!');
        $this->command->info('📊 Создано:');
        $this->command->info('   - ' . User::count() . ' пользователей');
        $this->command->info('   - ' . City::count() . ' городов');
        $this->command->info('   - ' . Category::count() . ' категорий');
        $this->command->info('   - ' . Breed::count() . ' пород');
        $this->command->info('   - ' . District::count() . ' районов');
        $this->command->info('   - ' . Color::count() . ' цветов');
        $this->command->info('   - ' . Post::count() . ' объявлений');
        $this->command->info('   - ' . Response::count() . ' откликов');
        $this->command->info('   - ' . \DB::table('favorites')->count() . ' записей в избранном');
    }
}