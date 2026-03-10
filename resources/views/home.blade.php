@extends('layouts.app')

@section('title', 'PetSearch — главная')

@section('content')
<div class="container">
    <section class="hero">
        <div class="hero__content">
            <h1 class="hero__title">Потеряли питомца?</h1>
            <p class="hero__subtitle">PetSearch помогает находить потерянных животных и возвращать их домой</p>
            <div class="hero__buttons">
                <a href="{{ route('posts.create') }}?status=lost" class="btn btn--primary">
                    <i class="fas fa-exclamation-triangle"></i> Я потерял(а)
                </a>
                <a href="{{ route('posts.create') }}?status=found" class="btn btn--outline">
                    <i class="fas fa-heart"></i> Я нашёл(ла)
                </a>
            </div>
        </div>
        <div class="hero__image">
            <img src="{{ asset('images/hero-pet.png') }}" alt="Потерянный питомец" class="hero__img">
        </div>
    </section>

    <section class="filters">
        <form action="{{ route('posts.index') }}" method="GET" class="filters__form">
            <div class="form-group">
                <label for="search">Кличка</label>
                <input type="text" id="search" name="search" placeholder="Например, Барсик">
            </div>
            <div class="form-group">
                <label for="category">Вид</label>
                <select id="category" name="category_id">
                    <option value="">Все</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="district">Район</label>
                <select id="district" name="district_id">
                    <option value="">Все</option>
                    @foreach($districts as $district)
                        <option value="{{ $district->id }}">{{ $district->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn--primary">Найти</button>
        </form>
    </section>

    <section>
        <h2 class="section-title">Последние объявления</h2>
        <div class="posts-grid">
            @forelse($recentPosts as $post)
                <div class="post-card">
                    <div class="post-card__image">
                        <i class="fas fa-camera"></i>
                    </div>
                    <div class="post-card__content">
                        <span class="post-card__status {{ $post->status == 'lost' ? 'status-lost' : 'status-found' }}">
                            {{ $post->status == 'lost' ? 'Пропал' : 'Найден' }}
                        </span>
                        <h3 class="post-card__title">{{ $post->name ?: 'Без имени' }}</h3>
                        <div class="post-card__meta">
                            <div><i class="fas fa-paw"></i> {{ $post->category->name }}</div>
                            <div><i class="fas fa-map-marker-alt"></i> {{ $post->district->name ?? '—' }}</div>
                            <div><i class="far fa-calendar"></i> {{ $post->lost_date->format('d.m.Y') }}</div>
                        </div>
                        <a href="{{ route('posts.show', $post) }}" class="post-card__btn">Подробнее</a>
                    </div>
                </div>
            @empty
                <p class="empty-message">Пока нет объявлений</p>
            @endforelse
        </div>
    </section>

    <section class="stats-grid">
        <div class="stat-card">
            <div class="stat-card__number">{{ $stats['total'] }}</div>
            <div class="stat-card__label">Всего объявлений</div>
        </div>
        <div class="stat-card">
            <div class="stat-card__number">{{ $stats['lost'] }}</div>
            <div class="stat-card__label">Ищут хозяев</div>
        </div>
        <div class="stat-card">
            <div class="stat-card__number">{{ $stats['found'] }}</div>
            <div class="stat-card__label">Найдены</div>
        </div>
        <div class="stat-card">
            <div class="stat-card__number">{{ $stats['users'] }}</div>
            <div class="stat-card__label">Пользователей</div>
        </div>
    </section>
</div>
@endsection