<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\District;
use App\Models\Color;
use App\Models\Breed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class PostController extends Controller
{

    public function index(Request $request)
    {
        $query = Post::active();

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
        
        if ($request->filled('colors')) {
            $colors = is_array($request->colors) ? $request->colors : [$request->colors];
            $colorCount = count($colors);
            
            $query->join('post_colors', 'posts.id', '=', 'post_colors.post_id')
                  ->join('colors', 'post_colors.color_id', '=', 'colors.id')
                  ->whereIn('colors.id', $colors)
                  ->select('posts.*')
                  ->groupBy('posts.id')
                  ->havingRaw('COUNT(DISTINCT post_colors.color_id) = ?', [$colorCount]);
        }
        
        $sort = $request->get('sort', 'latest');
        switch($sort) {
            case 'oldest':
                $query->oldest();
                break;
            case 'popular':
                $query->orderBy('views', 'desc');
                break;
            case 'latest':
            default:
                $query->latest();
        }

        $posts = $query->with(['user', 'category', 'district', 'colors', 'favoritedBy'])
                       ->paginate(12);
        $categories = Category::all();
        $districts = District::all();
        $colors = Color::all();

        return view('posts.index', compact('posts', 'categories', 'districts', 'colors'));
    }

    public function show(Post $post)
    {
        $post->increment('views');
        $post->load(['user', 'category', 'breed', 'district', 'colors', 'responses.user', 'favoritedBy']);
        
        return view('posts.show', compact('post'));
    }

    public function create(Request $request)
    {
        $categories = Category::all();
        $districts = District::all();
        $colors = Color::all();
        $breeds = Breed::all();
        
        $preselectedStatus = $request->query('status');
        
        return view('posts.create', compact('categories', 'districts', 'colors', 'breeds', 'preselectedStatus'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'status' => 'required|in:lost,found',
            'category_id' => 'required|exists:categories,id',
            'breed_id' => 'nullable|exists:breeds,id',
            'district_id' => 'nullable|exists:districts,id',
            'name' => 'nullable|string|max:100',
            'gender' => 'required|in:male,female,unknown',
            'age' => 'nullable|in:щенок,взрослый,unknown',
            'description' => 'nullable|string',
            'lost_date' => [
                'required',
                'date',
                'before_or_equal:today',
                'after_or_equal:' . Carbon::today()->subYears(3)->toDateString(),
            ],
            'contact_phone' => 'nullable|string|max:20',
            'colors' => 'nullable|array',
            'photos' => 'nullable|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:10240',
        ], [
            'lost_date.required' => 'Поле дата обязательно для заполнения.',
            'lost_date.date' => 'Поле дата должно быть датой.',
            'lost_date.before_or_equal' => 'Поле дата должно быть датой не позже сегодня.',
            'lost_date.after_or_equal' => 'Поле дата должно быть датой не древнее 3 лет назад.',
        ]);

        $data['user_id'] = Auth::id();
        $data['is_active'] = true;

        if ($request->hasFile('photos')) {
            $photos = [];
            foreach ($request->file('photos') as $file) {
                $photos[] = $file->store('post_photos', 'public');
            }
            $data['photos'] = $photos;
        }

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
            $isFavorited = false;
        } else {
            $user->favoritePosts()->attach($post->id);
            $message = 'Добавлено в избранное';
            $isFavorited = true;
        }

        
        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'isFavorited' => $isFavorited
            ]);
        }

        return back()->with('success', $message);
    }

    public function edit(Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403, 'У вас нет прав на редактирование этого объявления');
        }

        $categories = Category::all();
        $districts = District::all();
        $colors = Color::all();
        $breeds = Breed::all();
        
        return view('posts.edit', compact('post', 'categories', 'districts', 'colors', 'breeds'));
    }

    public function update(Request $request, Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403, 'У вас нет прав на редактирование этого объявления');
        }

        $data = $request->validate([
            'status' => 'required|in:lost,found',
            'category_id' => 'required|exists:categories,id',
            'breed_id' => 'nullable|exists:breeds,id',
            'district_id' => 'nullable|exists:districts,id',
            'name' => 'nullable|string|max:100',
            'gender' => 'nullable|in:male,female,unknown',
            'age' => 'nullable|in:щенок,взрослый,unknown',
            'description' => 'nullable|string',
            'lost_date' => [
                'required',
                'date',
                'before_or_equal:today',
                'after_or_equal:' . Carbon::today()->subYears(3)->toDateString(),
            ],
            'contact_phone' => 'nullable|string|max:20',
            'colors' => 'nullable|array',
            'photos' => 'nullable|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:10240',
        ], [
            'lost_date.required' => 'Поле дата обязательно для заполнения.',
            'lost_date.date' => 'Поле дата должно быть датой.',
            'lost_date.before_or_equal' => 'Поле дата должно быть датой не позже сегодня.',
            'lost_date.after_or_equal' => 'Поле дата должно быть датой не древнее 3 лет назад.',
        ]);

        if ($request->hasFile('photos')) {
            if ($post->photos) {
                foreach ($post->photos as $oldPhoto) {
                    Storage::disk('public')->delete($oldPhoto);
                }
            }
            $photos = [];
            foreach ($request->file('photos') as $file) {
                $photos[] = $file->store('post_photos', 'public');
            }
            $data['photos'] = $photos;
        }

        $post->update($data);
        
        if ($request->has('colors')) {
            $post->colors()->sync($request->colors);
        } else {
            $post->colors()->detach();
        }

        return redirect()->route('posts.show', $post)
                         ->with('success', 'Объявление обновлено!');
    }

    public function destroy(Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403, 'У вас нет прав на удаление этого объявления');
        }

        if ($post->photo) {
            Storage::disk('public')->delete($post->photo);
        }

        $post->delete();

        return redirect()->route('profile.show')
                         ->with('success', 'Объявление удалено!');
    }
}