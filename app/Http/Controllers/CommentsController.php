<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentDetailResource;
use App\Http\Resources\CommentsResource;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    public function index()
    {
        $comments = Comment::all();
        return CommentsResource::collection($comments);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'post_id' => 'required|exists:posts,id',
            'content' => 'required|string',
        ]);

        $request['user_id'] = Auth::user()->id;

        $comment = Comment::create($request->all());

        return new CommentDetailResource($comment);

    }

    public function show($id)
    {
        $comment = Comment::findOrFail($id)->with('user', 'post')->first();
        return new CommentDetailResource($comment);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'content' => 'sometimes|required|string',
        ]);

        $comment = Comment::findOrFail($id);
        $comment->update($request->only(keys: 'content'));

        return new CommentDetailResource($comment->loadMissing( 'user:id,username'));
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return response()->json(['message' => 'Comment deleted successfully.']);
    }

}
