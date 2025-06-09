<?php

namespace App\Http\Controllers;

// use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with(['user', 'category', 'likes', 'comments'])
            ->latest()
            ->paginate(10);
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category_id' => 'nullable|exists:categories,id'
        ]);

        $post = new Post();
        $post->title = $request->title;
        $post->content = $request->content;
        $post->user_id = Auth::id();
        $post->category_id = $request->category_id;
        $post->save();

        return redirect()->route('posts.show', $post)->with('success', '投稿を作成しました。');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $post->load(['user', 'category', 'comments.user', 'likes']);
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        if (Auth::id() !== $post->user_id) {
            return redirect()->route('posts.show', $post)->with('error', '編集権限がありません。');
        }
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        if (Auth::id() !== $post->user_id) {
            return redirect()->route('posts.show', $post)->with('error', '編集権限がありません。');
        }

        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category_id' => 'nullable|exists:categories,id'
        ]);

        $post->update([
            'title' => $request->title,
            'content' => $request->content,
            'category_id' => $request->category_id
        ]);

        return redirect()->route('posts.show', $post)->with('success', '投稿を更新しました。');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if (Auth::id() !== $post->user_id) {
            return redirect()->route('posts.show', $post)->with('error', '削除権限がありません。');
        }

        $post->delete();
        return redirect()->route('posts.index')->with('success', '投稿を削除しました。');
    }
}
