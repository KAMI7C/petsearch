@extends('layouts.app')

@section('title', 'Админ-панель — PetSearch')

@section('content')
<div class="container">
    <div class="admin-page">
        <div class="page-header">
            <h1>Административная панель</h1>
            <p>Управление сайтом PetSearch</p>
            <form method="POST" action="{{ route('logout') }}" style="margin-top: 10px;">
                @csrf
                <button type="submit" class="btn btn-danger">Выйти из админки</button>
            </form>
        </div>

        <!-- Статистика -->
        <div class="admin-stats">
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-number">{{ $stats['total_users'] }}</div>
                        <div class="stat-label">Пользователей</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-paw"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-number">{{ $stats['total_posts'] }}</div>
                        <div class="stat-label">Объявлений</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-comments"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-number">{{ $stats['total_responses'] }}</div>
                        <div class="stat-label">Откликов</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-ban"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-number">{{ $stats['banned_users'] }}</div>
                        <div class="stat-label">Заблокированных</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-tags"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-number">{{ $stats['categories_count'] }}</div>
                        <div class="stat-label">Категорий</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-dog"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-number">{{ $stats['breeds_count'] }}</div>
                        <div class="stat-label">Пород</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Меню админки -->
        <div class="admin-menu">
            <div class="admin-menu-grid">
                <a href="{{ route('admin.users') }}" class="admin-menu-item">
                    <i class="fas fa-users"></i>
                    <span>Пользователи</span>
                </a>

                <a href="{{ route('admin.posts') }}" class="admin-menu-item">
                    <i class="fas fa-paw"></i>
                    <span>Объявления</span>
                </a>

                <a href="{{ route('admin.responses') }}" class="admin-menu-item">
                    <i class="fas fa-comments"></i>
                    <span>Отклики</span>
                </a>

                <a href="{{ route('admin.categories') }}" class="admin-menu-item">
                    <i class="fas fa-tags"></i>
                    <span>Категории</span>
                </a>

                <a href="{{ route('admin.breeds') }}" class="admin-menu-item">
                    <i class="fas fa-dog"></i>
                    <span>Породы</span>
                </a>

                <a href="{{ route('admin.colors') }}" class="admin-menu-item">
                    <i class="fas fa-palette"></i>
                    <span>Цвета</span>
                </a>

                <a href="{{ route('admin.districts') }}" class="admin-menu-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>Районы</span>
                </a>

                <a href="{{ route('home') }}" class="admin-menu-item">
                    <i class="fas fa-home"></i>
                    <span>На сайт</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection