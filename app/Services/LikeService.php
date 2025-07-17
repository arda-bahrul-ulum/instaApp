<?php

namespace App\Services;

use App\Models\Like;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class LikeService
{
    public function like(int $postId, User $user): void
    {
        $like = Like::where('user_id', $user->id)->where('post_id', $postId)->first();
        if ($like) {
            throw new \Exception('You have already liked this post.');
        }
        Like::create([
            'user_id' => $user->id,
            'post_id' => $postId,
        ]);
    }

    public function unlike(int $postId, User $user): void
    {
        $like = Like::where('user_id', $user->id)->where('post_id', $postId)->first();
        if (!$like) {
            throw new \Exception('You have not liked this post.');
        }
        $like->delete();
    }
}
