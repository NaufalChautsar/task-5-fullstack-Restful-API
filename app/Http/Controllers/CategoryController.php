<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::paginate(10);

        return response()->json([
            'result' => [
                'succes' => true,
                'message' => 'Get all post success',
                'data' => $categories
            ]
        ]);
    }

    public function show($id)
    {
        $post = auth()->user()->categories()->find($id);

        if (!$post) {
            return response()->json([
                'code' => 404,
                'result' => [
                    'succes' => false,
                    'message' => 'Post not found'
                ]
            ], 404);
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
            'name' => 'required'
        ]);

        $post = new Category();
        $post->name = $request->name;

        if (auth()->user()->categories()->save($post))
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
        $post = auth()->user()->categories()->find($id);

        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found'
            ], 404);
        }

        $updated = $post->fill($request->all())->save();

        if ($updated)
            return response()->json([
                'success' => true
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Post can not be updated'
            ], 500);
    }

    public function destroy($id)
    {
        $post = auth()->user()->categories()->find($id);

        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found'
            ], 404);
        }

        if ($post->delete()) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Post can not be deleted'
            ], 500);
        }
    }
}
