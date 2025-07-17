<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CommentService
{
    public function create(array $data, User $user): Comment
    {
        return Comment::create([
            'user_id' => $user->id,
            'post_id' => $data['post_id'],
            'body' => $data['body'],
        ]);
    }
}
