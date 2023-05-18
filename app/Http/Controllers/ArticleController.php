<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArticleDetailResource;
use App\Http\Resources\ArticleResource; 
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::all();
        
        return ArticleResource::collection($articles->loadMissing('writer:id,name'));
    }

    public function show($id)
    {
        $article = Article::with('writer:id,name')->findOrFail($id);
        
        return new ArticleDetailResource($article);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'synopsis' => 'required',
            'content' => 'required',
        ]);

        $image = null;
        if($request->file) {
            $fileName = $this->generateRandomString();
            $extension = $request->file->extension();

            $image = $fileName.'.'.$extension;

            Storage::putFileAs('image', $request->file, $image);
        }

        $request['image'] = $image;

        $request['user_id'] = Auth::user()->id;

        $article = Article::create($request->all());
        
        return new ArticleDetailResource($article->loadMissing('writer:id,name'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'synopsis' => 'required',
            'content' => 'required',
        ]);

        $article = Article::findOrFail($id);
        $article->update($request->all());

        return new ArticleDetailResource($article->loadMissing('writer:id,name'));
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $article->delete();

        return new ArticleDetailResource($article->loadMissing('writer:id,name'));
    }

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
