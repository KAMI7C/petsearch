<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\District;
use App\Models\Color;
use App\Models\Breed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{

    public function index(Request $request)
    {
        $query = Post::with(['user', 'category', 'district', 'colors'])
                     ->active()
                     ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('district_id')) {
            $query->where('district_id', $request->district_id);
        }
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $posts = $query->paginate(12);
        $categories = Category::all();
        $districts = District::all();

        return view('posts.index', compact('posts', 'categories', 'districts'));
    }

    public function show(Post $post)
    {
        $post->increment('views');
        $post->load(['user', 'category', 'breed', 'district', 'colors', 'responses.user']);
        
        return view('posts.show', compact('post'));
    }

    public function create()
    {
        $categories = Category::all();
        $districts = District::all();
        $colors = Color::all();
        $breeds = Breed::all();
        
        return view('posts.create', compact('categories', 'districts', 'colors', 'breeds'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'status' => 'required|in:lost,found',
            'category_id' => 'required|exists:categories,id',
            'breed_id' => 'nullable|exists:breeds,id',
            'district_id' => 'nullable|exists:districts,id',
            'name' => 'nullable|string|max:100',
            'gender' => 'nullable|in:male,female,unknown',
            'age' => 'nullable|in:щенок,взрослый',
            'description' => 'nullable|string',
            'lost_date' => 'required|date',
            'contact_phone' => 'nullable|string|max:20',
            'colors' => 'nullable|array',
        ]);

        $data['user_id'] = Auth::id();
        $data['is_active'] = true;

        $post = Post::create($data);
        
        if ($request->has('colors')) {
            $post->colors()->attach($request->colors);
        }

        return redirect()->route('posts.show', $post)
                         ->with('success', 'Объявление создано!');
    }

    public function toggleFavorite(Post $post)
    {
        $user = Auth::user();
        
        if ($user->favoritePosts()->where('post_id', $post->id)->exists()) {
            $user->favoritePosts()->detach($post->id);
            $message = 'Удалено из избранного';
        } else {
            $user->favoritePosts()->attach($post->id);
            $message = 'Добавлено в избранное';
        }

        return back()->with('success', $message);
    }
}