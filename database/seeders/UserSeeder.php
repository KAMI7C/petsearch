<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
