<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index()
    {
        $categories = Category::withCount('posts')->get();
        return view('categories.index', compact('categories'));
    }

    public function show(Category $category)
    {
        $posts = $category->posts()->with('user')->latest()->paginate(10);
        return view('categories.show', compact('category', 'posts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|unique:categories',
            'description' => 'nullable|max:1000'
        ]);

        Category::create($request->all());
        return redirect()->route('categories.index')->with('success', 'カテゴリーを作成しました。');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'カテゴリーを削除しました。');
    }
} 