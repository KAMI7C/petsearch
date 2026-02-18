<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResponseController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/{user}', [AdminController::class, 'showUser'])->name('users.show');
    Route::patch('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::patch('/users/{user}/ban', [AdminController::class, 'banUser'])->name('users.ban');
    Route::patch('/users/{user}/unban', [AdminController::class, 'unbanUser'])->name('users.unban');
    Route::patch('/users/{user}/make-admin', [AdminController::class, 'makeAdmin'])->name('users.make-admin');
    Route::patch('/users/{user}/revoke-admin', [AdminController::class, 'revokeAdmin'])->name('users.revoke-admin');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->middleware('super_admin')->name('users.destroy');

    Route::get('/posts', [AdminController::class, 'posts'])->name('posts');
    Route::get('/posts/{post}', [AdminController::class, 'showPost'])->name('posts.show');
    Route::patch('/posts/{post}/activate', [AdminController::class, 'activatePost'])->name('posts.activate');
    Route::patch('/posts/{post}/deactivate', [AdminController::class, 'deactivatePost'])->name('posts.deactivate');
    Route::delete('/posts/{post}', [AdminController::class, 'deletePost'])->name('posts.destroy');

    Route::get('/responses', [AdminController::class, 'responses'])->name('responses');
    Route::get('/responses/{response}', [AdminController::class, 'showResponse'])->name('responses.show');
    Route::patch('/responses/{response}/activate', [AdminController::class, 'activateResponse'])->name('responses.activate');
    Route::patch('/responses/{response}/deactivate', [AdminController::class, 'deactivateResponse'])->name('responses.deactivate');
    Route::delete('/responses/{response}', [AdminController::class, 'deleteResponse'])->name('responses.destroy');

    Route::get('/categories', [AdminController::class, 'categories'])->name('categories');
    Route::get('/categories/create', [AdminController::class, 'createCategory'])->name('categories.create');
    Route::post('/categories', [AdminController::class, 'storeCategory'])->name('categories.store');
    Route::get('/categories/{category}/edit', [AdminController::class, 'editCategory'])->name('categories.edit');
    Route::put('/categories/{category}', [AdminController::class, 'updateCategory'])->name('categories.update');
    Route::delete('/categories/{category}', [AdminController::class, 'deleteCategory'])->name('categories.destroy');

    Route::get('/breeds', [AdminController::class, 'breeds'])->name('breeds');
    Route::get('/breeds/create', [AdminController::class, 'createBreed'])->name('breeds.create');
    Route::post('/breeds', [AdminController::class, 'storeBreed'])->name('breeds.store');
    Route::get('/breeds/{breed}/edit', [AdminController::class, 'editBreed'])->name('breeds.edit');
    Route::put('/breeds/{breed}', [AdminController::class, 'updateBreed'])->name('breeds.update');
    Route::delete('/breeds/{breed}', [AdminController::class, 'deleteBreed'])->name('breeds.destroy');

    Route::get('/colors', [AdminController::class, 'colors'])->name('colors');
    Route::get('/colors/create', [AdminController::class, 'createColor'])->name('colors.create');
    Route::post('/colors', [AdminController::class, 'storeColor'])->name('colors.store');
    Route::get('/colors/{color}/edit', [AdminController::class, 'editColor'])->name('colors.edit');
    Route::put('/colors/{color}', [AdminController::class, 'updateColor'])->name('colors.update');
    Route::delete('/colors/{color}', [AdminController::class, 'deleteColor'])->name('colors.destroy');

    Route::get('/districts', [AdminController::class, 'districts'])->name('districts');
    Route::get('/districts/create', [AdminController::class, 'createDistrict'])->name('districts.create');
    Route::post('/districts', [AdminController::class, 'storeDistrict'])->name('districts.store');
    Route::get('/districts/{district}/edit', [AdminController::class, 'editDistrict'])->name('districts.edit');
    Route::put('/districts/{district}', [AdminController::class, 'updateDistrict'])->name('districts.update');
    Route::delete('/districts/{district}', [AdminController::class, 'deleteDistrict'])->name('districts.destroy');
});

Route::prefix('posts')->name('posts.')->group(function () {
    Route::get('/', [PostController::class, 'index'])->name('index');
    Route::get('/create', [PostController::class, 'create'])->name('create');
    Route::get('/{post}', [PostController::class, 'show'])->name('show');

    Route::middleware('auth')->group(function () {
        Route::post('/', [PostController::class, 'store'])->name('store');
        Route::get('/{post}/edit', [PostController::class, 'edit'])->name('edit');
        Route::put('/{post}', [PostController::class, 'update'])->name('update');
        Route::delete('/{post}', [PostController::class, 'destroy'])->name('destroy');
        Route::post('/{post}/favorite', [PostController::class, 'toggleFavorite'])->name('favorite');
    });
});

Route::post('/responses', [ResponseController::class, 'store'])->name('responses.store');

Route::middleware('auth')->group(function () {
    Route::patch('/responses/{response}', [ResponseController::class, 'update'])->name('responses.update');
    Route::delete('/responses/{response}', [ResponseController::class, 'destroy'])->name('responses.destroy');
});

Route::middleware('auth')->prefix('profile')->name('profile.')->group(function () {
    Route::get('/', [ProfileController::class, 'show'])->name('show');
    Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
    Route::patch('/', [ProfileController::class, 'update'])->name('update');
    Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    Route::post('/posts/{post}/close', [ProfileController::class, 'closePost'])->name('close-post');
});


Route::get('/teste', function () {
    return view('teste');
});