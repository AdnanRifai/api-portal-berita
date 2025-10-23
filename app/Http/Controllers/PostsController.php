<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostDetailResource;
use App\Http\Resources\PostResource;
use App\Models\Posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    public function index()
    {
        $post = Posts::all();
        // return response()->json(['data' => $post], 200);
        return PostResource::collection($post);
    }

    public function show($id)
    {
        $post = Posts::findOrFail($id)->with('writer')->first();
        return new PostDetailResource($post);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'title' => 'required|string|max:255',
            'news_content' => 'required|string',
        ]);

        $request['author'] = Auth::user()->id;
        $post = Posts::create($request->all());
        return new PostDetailResource($post->loadMissing('writer:id,username'));
    }

    public function update(Request $request, $id)
    {
        $post = Posts::findOrFail($id);

        // Check if the authenticated user is the author of the post
        if ($post->author !== Auth::user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validate = $request->validate([
            'title' => 'required|string|max:255',
            'news_content' => 'required|string',
        ]);

        $post->update($request->all());
        return new PostDetailResource($post->loadMissing('writer:id,username'));
    }

    public function destroy($id)
    {
        $post = Posts::findOrFail($id);

        // Check if the authenticated user is the author of the post
        if ($post->author !== Auth::user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $post->delete();
        return response()->json(['message' => 'Post deleted successfully'], 200);
    }
}

