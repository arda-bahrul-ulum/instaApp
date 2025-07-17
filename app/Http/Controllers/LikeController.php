<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use Illuminate\Support\Facades\DB;
use App\Services\LikeService;

class LikeController extends Controller
{
    public function store(Request $request, LikeService $likeService)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
        ]);

        $user = auth()->user();
        $postId = $request->post_id;

        DB::beginTransaction();
        try {
            $likeService->like($postId, $user);
            DB::commit();
            return redirect()->back()->with('success', 'Post liked successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function destroy(Request $request, LikeService $likeService)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
        ]);

        $user = auth()->user();
        $postId = $request->post_id;

        DB::beginTransaction();
        try {
            $likeService->unlike($postId, $user);
            DB::commit();
            return redirect()->back()->with('success', 'Like removed successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
