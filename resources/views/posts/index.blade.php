@extends('layouts.app')

@section('title', 'Все объявления')

@section('content')
<div class="container">
    <h1 class="page-title">Все объявления</h1>

    <section class="filters">
        <form action="{{ route('posts.index') }}" method="GET" class="filters__form">
            <div class="form-group filters__top-row">
                <label for="search">Поиск</label>
                <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="Кличка или описание">
            </div>
            <div class="form-group filters__top-row">
                <label for="status">Статус</label>
                <select id="status" name="status">
                    <option value="">Все</option>
                    <option value="lost" {{ request('status') == 'lost' ? 'selected' : '' }}>Пропал</option>
                    <option value="found" {{ request('status') == 'found' ? 'selected' : '' }}>Найден</option>
                </select>
            </div>
            <div class="form-group filters__top-row">
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
            <div class="form-group filters__top-row">
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
            <div class="form-group filters__top-row">
                <label for="sort">Сортировка</label>
                <select id="sort" name="sort">
                    <option value="latest" {{ request('sort', 'latest') === 'latest' ? 'selected' : '' }}>Новые сначала</option>
                    <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Старые сначала</option>
                    <option value="popular" {{ request('sort') === 'popular' ? 'selected' : '' }}>По популярности</option>
                </select>
            </div>
            <div class="form-group colors-filter">
                <label>Цвет питомца</label>
                <div class="colors-checkboxes">
                    @foreach($colors as $color)
                        <label class="checkbox-label">
                            <input type="checkbox" name="colors[]" value="{{ $color->id }}" 
                                {{ in_array($color->id, (array)request('colors', [])) ? 'checked' : '' }}>
                            <span class="color-circle" style="background-color: {{ $color->hex_code ?? '#cccccc' }};"></span>
                            <span class="checkbox-text">{{ $color->name }}</span>
                        </label>
                    @endforeach
                </div>
                <button type="submit" class="btn btn--primary filters__btn">Применить</button>
            </div>
        </form>
    </section>

    <div class="main-content">
        <aside class="filters-sidebar">
            <!-- All filters are now in the main form above -->
        </aside>

        <div class="posts-wrapper">
            <div class="posts-grid">
                @forelse($posts as $post)
                    <div class="post-card">
                        <div class="post-card__image">
                            <i class="fas fa-camera"></i>
                        </div>
                        <div class="post-card__content">
                            <div class="post-card__header">
                                <span class="post-card__status {{ $post->status == 'lost' ? 'status-lost' : 'status-found' }}">
                                    {{ $post->status == 'lost' ? 'Пропал' : 'Найден' }}
                                </span>
                                @auth
                                    <form action="{{ route('posts.favorite', $post) }}" method="POST" class="favorite-form post-card__favorite-form">
                                        @csrf
                                        <button type="submit" class="post-card__favorite {{ $post->favoritedBy->contains(auth()->id()) ? 'active' : '' }}" title="Добавить в избранное">
                                            <i class="fas fa-heart"></i>
                                        </button>
                                    </form>
                                @endauth
                            </div>
                            <h3 class="post-card__title">{{ $post->name ?: 'Без имени' }}</h3>
                            <div class="post-card__meta">
                                <div><i class="fas fa-paw"></i> {{ $post->category->name }}</div>
                                <div><i class="fas fa-map-marker-alt"></i> {{ $post->district->name ?? '—' }}</div>
                                <div><i class="far fa-calendar"></i> {{ $post->lost_date->format('d.m.Y') }}</div>
                            </div>
                            @if($post->colors->count() > 0)
                                <div class="post-card__colors">
                                    @foreach($post->colors as $color)
                                        <div class="color-item">
                                            <span class="color-circle" title="{{ $color->name }}" style="background-color: {{ $color->hex_code ?? '#cccccc' }};"></span>
                                            <span class="color-name">{{ $color->name }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                            <div class="post-card__actions">
                                <a href="{{ route('posts.show', $post) }}" class="post-card__btn">Подробнее</a>
                            </div>
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
    </div>
</div>
@endsection