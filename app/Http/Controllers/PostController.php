<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $data = Post::paginate(10);

        return response()->json([
            'result' => [
                'succes' => true,
                'message' => 'Get all post success',
                'data' => $data
            ]
        ]);
    }

    public function show($id)
    {
        $post = auth()->user()->posts()->find($id);

        if (!$post) {
            return response()->json([
                'code' => 400,
                'result' => [
                    'succes' => false,
                    'message' => 'Post not found'
                ]
            ]);
        }

        return response()->json([
            'success' => true,
            'result' => [
                'succes' => true,
                'message' => 'Post finded',
                'data' => $post->toArray()
            ]
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'content' => 'required',
            'image' => 'required'
        ]);

        $post = new Post();
        $post->title = $request->title;
        $post->content = $request->content;
        $post->image = $request->image;

        if (auth()->user()->posts()->save($post))
            return response()->json([
                'success' => true,
                'data' => $post->toArray()
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Post not added'
            ], 500);
    }

    public function update(Request $request, $id)
    {
        $post = auth()->user()->posts()->find($id);

        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found'
            ], 404);
        }

        $updated = $post->fill($request->all())->save();

        if ($updated)
            return response()->json([
                'success' => true,
                'message' => 'Post success upadated'
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Post can not be updated'
            ], 500);
    }

    public function destroy($id)
    {
        $post = auth()->user()->posts()->find($id);

        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found'
            ], 404);
        }

        if ($post->delete()) {
            return response()->json([
                'success' => true,
                'message' => 'Post success deleted'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Post can not be deleted'
            ], 500);
        }
    }
}
