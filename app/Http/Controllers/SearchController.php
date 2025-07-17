<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Post;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');
        $postsQuery = Post::with(['user', 'likes', 'comments.user'])->latest();

        if ($query) {
            $postsQuery->where(function($q) use ($query) {
                $q->where('caption', 'like', "%$query%")
                  ->orWhereHas('user', function($uq) use ($query) {
                      $uq->where('name', 'like', "%$query%")
                        ->orWhere('email', 'like', "%$query%") ;
                  });
            });
        }

        $posts = $postsQuery->get();
        return Inertia::render('Search', [
            'posts' => $posts,
            'search' => $query,
        ]);
    }
}
