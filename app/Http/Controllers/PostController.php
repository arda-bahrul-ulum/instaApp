<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use App\Services\PostService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PostController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $posts = Post::with(['user', 'likes', 'comments.user'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();
        return Inertia::render('Posts/Index', [
            'posts' => $posts,
        ]);
    }

    public function create()
    {
        return Inertia::render('Posts/Create');
    }

    public function store(Request $request, PostService $postService)
    {
        $data = $request->validate([
            'caption' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $post = $postService->create($data, auth()->user());
            DB::commit();
            return redirect()->route('posts.index')->with('success', 'Post created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to create post: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $this->authorize('update', $post);
        return Inertia::render('Posts/Edit', [
            'post' => $post,
        ]);
    }

    public function update(Request $request, Post $post, PostService $postService)
    {
        $this->authorize('update', $post);
        $data = $request->validate([
            'caption' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->file('image')) {
            $data['image'] = $request->file('image');
        } else {
            unset($data['image']);
        }

        DB::beginTransaction();
        try {
            $postService->update($post, $data);
            DB::commit();
            return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to update post: ' . $e->getMessage());
        }
    }

    public function destroy($id, PostService $postService)
    {
        $post = Post::findOrFail($id);
        $this->authorize('delete', $post);

        DB::beginTransaction();
        try {
            $postService->delete($post);
            DB::commit();
            return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to delete post: ' . $e->getMessage());
        }
    }

    public function dashboard()
    {
        $posts = Post::with(['user', 'likes', 'comments.user'])->latest()->get();
        return Inertia::render('Dashboard', [
            'posts' => $posts,
        ]);
    }
}
