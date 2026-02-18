<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Models\Response;
use App\Models\Category;
use App\Models\Breed;
use App\Models\Color;
use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_posts' => Post::count(),
            'total_responses' => Response::count(),
            'banned_users' => User::where('banned', true)->count(),
            'categories_count' => Category::count(),
            'breeds_count' => Breed::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function users(Request $request)
    {
        $query = User::query()->withCount('posts');

        if ($request->filled('search')) {
            $search = trim((string) $request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->input('role'));
        }

        if ($request->input('status') === 'active') {
            $query->where('banned', false);
        } elseif ($request->input('status') === 'banned') {
            $query->where('banned', true);
        }

        $users = $query->latest('id')->paginate(20)->appends($request->query());
        return view('admin.users.index', compact('users'));
    }

    public function showUser(User $user)
    {
        return response()->json($user);
    }

    public function banUser(User $user)
    {
        $user->update(['banned' => true]);
        return back()->with('success', 'Пользователь заблокирован');
    }

    public function unbanUser(User $user)
    {
        $user->update(['banned' => false, 'ban_reason' => null]);
        return back()->with('success', 'Пользователь разблокирован');
    }

    public function updateUser(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:user,admin',
            'banned' => 'boolean',
            'ban_reason' => 'nullable|string|max:500',
        ]);

        $user->update($data);
        return back()->with('success', 'Пользователь обновлен');
    }

    public function makeAdmin(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Нельзя изменить свою собственную роль.');
        }

        if ($user->role === 'admin') {
            return back()->with('error', 'Пользователь уже является администратором.');
        }
        
        $user->update(['role' => 'admin']);
        
        return back()->with('success', 'Пользователь назначен администратором.');
    }

    public function revokeAdmin(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Нельзя забрать права администратора у самого себя.');
        }

        if ($user->role !== 'admin') {
            return back()->with('error', 'Пользователь не является администратором.');
        }

        $user->update(['role' => 'user']);

        return back()->with('success', 'Права администратора сняты.');
    }

    public function posts(Request $request)
    {
        $query = Post::query()->with(['user', 'category']);

        if ($request->filled('search')) {
            $search = trim((string) $request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($uq) use ($search) {
                        $uq->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->input('category'));
        }

        if ($request->input('status') === 'active') {
            $query->where('is_active', true);
        } elseif ($request->input('status') === 'inactive') {
            $query->where('is_active', false);
        }

        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');

        if ($dateFrom && $dateTo && $dateFrom > $dateTo) {
            [$dateFrom, $dateTo] = [$dateTo, $dateFrom];
        }

        if ($dateFrom) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }

        if ($dateTo) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        if ($request->filled('date_from') || $request->filled('date_to')) {
            $request->merge(['date_from' => $dateFrom, 'date_to' => $dateTo]);
        }

        $posts = $query->latest('id')->paginate(20)->appends($request->query());
        $categories = Category::orderBy('name')->get();

        return view('admin.posts.index', compact('posts', 'categories'));
    }

    public function showPost(Post $post)
    {
        $post->load(['user', 'category', 'breed', 'district', 'colors']);

        $photos = [];
        if (is_array($post->photos)) {
            $photos = $post->photos;
        } elseif (!empty($post->photo)) {
            $photos = [$post->photo];
        }

        return response()->json([
            'id' => $post->id,
            'title' => $post->name ?: "Объявление #{$post->id}",
            'description' => $post->description,
            'category' => $post->category,
            'breed' => $post->breed,
            'color' => $post->colors->first(),
            'district' => $post->district,
            'user' => $post->user,
            'active' => (bool) $post->is_active,
            'created_at' => $post->created_at,
            'images' => collect($photos)->map(fn($path) => ['path' => $path])->values(),
        ]);
    }

    public function activatePost(Post $post)
    {
        $post->update(['is_active' => true]);
        return back()->with('success', 'Объявление активировано');
    }

    public function deactivatePost(Post $post)
    {
        $post->update(['is_active' => false]);
        return back()->with('success', 'Объявление деактивировано');
    }

    public function deletePost(Post $post)
    {
        if ($post->photos) {
            foreach ($post->photos as $photo) {
                Storage::disk('public')->delete($photo);
            }
        }

        $post->delete();
        return back()->with('success', 'Объявление удалено');
    }

    public function responses(Request $request)
    {
        $query = Response::query()->with(['post.user', 'user']);

        if ($request->filled('search')) {
            $search = trim((string) $request->input('search'));
            $query->where('message', 'like', "%{$search}%");
        }

        if ($request->input('status') === 'active') {
            $query->where('is_archived', false);
        } elseif ($request->input('status') === 'inactive') {
            $query->where('is_archived', true);
        }

        $responses = $query->latest('id')->paginate(20)->appends($request->query());
        return view('admin.responses.index', compact('responses'));
    }

    public function showResponse(Response $response)
    {
        $response->load(['post.user', 'user']);

        return response()->json([
            'id' => $response->id,
            'message' => $response->message,
            'post' => $response->post,
            'user' => $response->user,
            'active' => !$response->is_archived,
            'created_at' => $response->created_at,
        ]);
    }

    public function activateResponse(Response $response)
    {
        $response->update(['is_archived' => false]);
        return back()->with('success', 'Отклик активирован');
    }

    public function deactivateResponse(Response $response)
    {
        $response->update(['is_archived' => true]);
        return back()->with('success', 'Отклик деактивирован');
    }

    public function deleteResponse(Response $response)
    {
        $response->delete();
        return back()->with('success', 'Отклик удален');
    }

    public function categories()
    {
        $categories = Category::withCount('posts')->latest('id')->paginate(20);
        return view('admin.categories.index', compact('categories'));
    }

    public function createCategory()
    {
        return view('admin.categories.create');
    }

    public function storeCategory(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string|max:1000',
        ]);

        Category::create($data);
        return back()->with('success', 'Категория добавлена');
    }

    public function editCategory(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function updateCategory(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string|max:1000',
        ]);

        $category->update($data);
        return redirect()->route('admin.categories')->with('success', 'Категория обновлена');
    }

    public function deleteCategory(Category $category)
    {
        if ($category->posts()->count() > 0) {
            return back()->with('error', 'Нельзя удалить категорию с объявлениями');
        }

        $category->delete();
        return back()->with('success', 'Категория удалена');
    }

    public function breeds(Request $request)
    {
        $query = Breed::query()->with(['category'])->withCount('posts');

        if ($request->filled('category')) {
            $query->where('category_id', $request->input('category'));
        }

        $breeds = $query->latest('id')->paginate(20)->appends($request->query());
        $categories = Category::all();
        return view('admin.breeds.index', compact('breeds', 'categories'));
    }

    public function createBreed()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.breeds.create', compact('categories'));
    }

    public function storeBreed(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
        ]);

        Breed::create($request->only(['name', 'category_id']));
        return back()->with('success', 'Порода добавлена');
    }

    public function editBreed(Breed $breed)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.breeds.edit', compact('breed', 'categories'));
    }

    public function updateBreed(Request $request, Breed $breed)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
        ]);

        $breed->update($request->only(['name', 'category_id']));
        return redirect()->route('admin.breeds')->with('success', 'Порода обновлена');
    }

    public function deleteBreed(Breed $breed)
    {
        if ($breed->posts()->count() > 0) {
            return back()->with('error', 'Нельзя удалить породу с объявлениями');
        }

        $breed->delete();
        return back()->with('success', 'Порода удалена');
    }

    public function colors()
    {
        $colors = Color::withCount('posts')->latest('id')->paginate(20);
        return view('admin.colors.index', compact('colors'));
    }

    public function createColor()
    {
        return view('admin.colors.create');
    }

    public function storeColor(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:colors',
            'hex_code' => ['nullable', 'regex:/^#[a-fA-F0-9]{6}$/'],
        ]);

        Color::create($data);
        return back()->with('success', 'Цвет добавлен');
    }

    public function editColor(Color $color)
    {
        return view('admin.colors.edit', compact('color'));
    }

    public function updateColor(Request $request, Color $color)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:colors,name,' . $color->id,
            'hex_code' => ['nullable', 'regex:/^#[a-fA-F0-9]{6}$/'],
        ]);

        $color->update($data);
        return redirect()->route('admin.colors')->with('success', 'Цвет обновлен');
    }

    public function deleteColor(Color $color)
    {
        if ($color->posts()->count() > 0) {
            return back()->with('error', 'Нельзя удалить цвет с объявлениями');
        }

        $color->delete();
        return back()->with('success', 'Цвет удален');
    }

    public function districts()
    {
        $districts = District::withCount('posts')->latest('id')->paginate(20);
        return view('admin.districts.index', compact('districts'));
    }

    public function createDistrict()
    {
        return view('admin.districts.create');
    }

    public function storeDistrict(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:districts',
        ]);

        District::create($request->only('name'));
        return back()->with('success', 'Район добавлен');
    }

    public function editDistrict(District $district)
    {
        return view('admin.districts.edit', compact('district'));
    }

    public function updateDistrict(Request $request, District $district)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:districts,name,' . $district->id,
        ]);

        $district->update($data);
        return redirect()->route('admin.districts')->with('success', 'Район обновлен');
    }

    public function deleteDistrict(District $district)
    {
        if ($district->posts()->count() > 0) {
            return back()->with('error', 'Нельзя удалить район с объявлениями');
        }

        $district->delete();
        return back()->with('success', 'Район удален');
    }
}