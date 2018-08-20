<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Article; // Article Model
use App\Http\Resources\Article as ArticleResource;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() // We are getting the articles to display them
    {
        $articles = Article::Paginate(15); // Paginate - We are getting 15 articles that we seeded, from the Article Data model

        return $articles; // We are returning them as a collection from the article resource class
    }



    public function store(Request $request)
    {
      $article = $request->isMethod('put') ? Article::findOrFail($request->article_id) : new Article;

      $article->id = $request->input('article_id');
      $article->title = $request->input('title');
      $article->body = $request->input('body');

      if($article->save()) {

        return new ArticleResource($article);
      }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = Article::findOrFail($id);

        return new ArticleResource($article); // we do new because we are only requesting a single entry

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $article = Article::findOrFail($id);

        if($article->delete()) {

          return new ArticleResource($article);
        }
    }
}
