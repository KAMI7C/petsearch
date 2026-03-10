@extends('layouts.app')

@section('title', 'Все объявления')

@section('content')
<div class="container">
    <h1 class="page-title">Все объявления</h1>

    <section class="filters">
        <form action="{{ route('posts.index') }}" method="GET" class="filters__form">
            <div class="form-group">
                <label for="search">Поиск</label>
                <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="Кличка или описание">
            </div>
            <div class="form-group">
                <label for="status">Статус</label>
                <select id="status" name="status">
                    <option value="">Все</option>
                    <option value="lost" {{ request('status') == 'lost' ? 'selected' : '' }}>Пропал</option>
                    <option value="found" {{ request('status') == 'found' ? 'selected' : '' }}>Найден</option>
                </select>
            </div>
            <div class="form-group">
                <label for="category">Вид</label>
                <select id="category" name="category_id">
                    <option value="">Все</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="district">Район</label>
                <select id="district" name="district_id">
                    <option value="">Все</option>
                    @foreach($districts as $district)
                        <option value="{{ $district->id }}" {{ request('district_id') == $district->id ? 'selected' : '' }}>
                            {{ $district->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn--primary">Применить</button>
        </form>
    </section>

    <div class="posts-grid">
        @forelse($posts as $post)
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
            <p class="empty-message">Объявлений не найдено</p>
        @endforelse
    </div>

    <div style="margin: 40px 0;">
        {{ $posts->withQueryString()->links() }}
    </div>
</div>
@endsection