<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{

    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'Администратор',
            'email' => 'admin@petsearch.ru',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
            'phone' => '+7 (999) 000-00-00',
        ]);

        \App\Models\User::create([
            'name' => 'Иван Петров',
            'email' => 'ivan@example.com',
            'password' => bcrypt('password'),
            'phone' => '+7 (999) 123-45-67',
            'city' => 'Москва',
            'about' => 'Люблю животных и помогаю искать пропавших питомцев.',
        ]);

        \App\Models\User::create([
            'name' => 'Мария Сидорова',
            'email' => 'maria@example.com',
            'password' => bcrypt('password'),
            'phone' => '+7 (999) 987-65-43',
            'city' => 'Санкт-Петербург',
            'about' => 'Волонтер в поиске домашних животных.',
        ]);
    }
}
