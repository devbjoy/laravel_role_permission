<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view article',only:['index']),
            new Middleware('permission:edit article',only:['edit']),
            new Middleware('permission:create article',only:['create']),
            new Middleware('permission:delete article',only:['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::orderBy('id','desc')->paginate(10);
        return view('articles.index',['articles' => $articles]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        return view('articles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title' => 'required|min:5|string',
            'author' => 'required|min:3|string'
        ]);

        if($validator->fails()){
            return redirect()->route('articles.create')->withInput()->withErrors($validator);
        }

        $article = new Article();

        $article->title = $request->title;
        $article->content = $request->content;
        $article->author = $request->author;
        $article->save();

        return redirect()->route('articles.index')->with('success','Article Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $article = Article::find($id);

        if(empty($article)){
            return redirect()->route('articles.index')->with('error','Article Not Found');
        }
        return view('articles.edit',['article' => $article]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $article = Article::find($id);

        if(empty($article)){
            return redirect()->route('articles.index')->with('error','Article Not Found');
        }
        $validator = Validator::make($request->all(),[
            'title' => 'required|min:5|string',
            'author' => 'required|min:3|string'
        ]);

        if($validator->fails()){
            return redirect()->route('articles.edit',$id)->withInput()->withErrors($validator);
        }

        $article->title = $request->title;
        $article->content = $request->content;
        $article->author = $request->author;
        $article->save();

        return redirect()->route('articles.index')->with('success','Article Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $article = Article::find($id);

        if(empty($article)){
            return redirect()->route('articles.index')->with('error','Article Not Found');
        }

        $article->delete();

        return redirect()->route('articles.index')->with('success','Article Deleted Successfully');
    }
}
