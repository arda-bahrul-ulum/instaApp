<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;
use App\Models\User;

class PostService
{
    public function create(array $data, User $user): Post
    {
        $imagePath = $data['image']->store('posts', 'public');
        return $user->posts()->create([
            'caption' => $data['caption'] ?? null,
            'image_path' => $imagePath,
        ]);
    }

    public function update(Post $post, array $data): Post
    {
        $updateData = [
            'caption' => $data['caption'] ?? $post->caption,
        ];
        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            if ($post->image_path && \Storage::disk('public')->exists($post->image_path)) {
                \Storage::disk('public')->delete($post->image_path);
            }
            $imagePath = $data['image']->store('posts', 'public');
            $updateData['image_path'] = $imagePath;
        }
        $post->update($updateData);
        return $post;
    }

    public function delete(Post $post): void
    {
        $post->delete();
    }
}
