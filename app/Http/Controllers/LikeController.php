<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function store(Post $post)
    {
        $like = new Like();
        $like->user_id = Auth::id();
        $like->post_id = $post->id;
        $like->save();

        return redirect()->back()->with('success', 'いいねしました。');
    }

    public function destroy(Post $post)
    {
        $like = Like::where('user_id', Auth::id())
            ->where('post_id', $post->id)
            ->first();

        if ($like) {
            $like->delete();
            return redirect()->back()->with('success', 'いいねを取り消しました。');
        }

        return redirect()->back()->with('error', 'いいねが見つかりません。');
    }
} 