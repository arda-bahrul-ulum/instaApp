<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\DB;
use App\Services\CommentService;

class CommentController extends Controller
{
    public function store(Request $request, CommentService $commentService)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'body' => 'required|string|max:1000',
        ]);

        $user = auth()->user();
        DB::beginTransaction();
        try {
            $commentService->create($request->only(['post_id', 'body']), $user);
            DB::commit();
            return redirect()->back()->with('success', 'Comment added successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to add comment: ' . $e->getMessage());
        }
    }
}
