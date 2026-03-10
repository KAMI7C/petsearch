<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\District;

class HomeController extends Controller
{
    public function index()
    {
        $recentPosts = Post::with(['category', 'district'])
                           ->active()
                           ->latest()
                           ->limit(6)
                           ->get();
        
        $categories = Category::all();
        $districts = District::all();
        
        $stats = [
            'total' => Post::count(),
            'lost' => Post::where('status', 'lost')->count(),
            'found' => Post::where('status', 'found')->count(),
            'users' => \App\Models\User::count(),
        ];

        return view('home', compact('recentPosts', 'categories', 'districts', 'stats'));
    }

    public function about()
    {
        return view('about');
    }
}