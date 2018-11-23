<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Post;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::orderBy('created_at', 'desc');

        if ($request->has('q')) {
            $posts = $posts->where('title', 'like', '%' . $request->input('q') . '%');
        }

        $posts = $posts->paginate(30);

        return view('post/list', compact('posts'));
    }

    public function add(Request $request)
    {
        return view('post/add');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $post = new Post($data);
        $post->save();

        return redirect()->route('post::list')->withStatus('Đã thêm bài viết mới');
    }

    public function edit(Post $post)
    {
        return view('post/edit', compact('post'));
    }

    public function update(Post $post, Request $request)
    {
        $data = $request->all();
        $post->update($data);

        return redirect()->back()->withStatus('Cập nhật bài viết thành công');
    }

    public function delete(Post $post, Request $request)
    {
        $post->delete();

        if ($request->ajax()) {
            return ['success' => true];
        }

        return redirect()->back()->withStatus('Đã xoá');
    }
}
