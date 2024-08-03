<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator; 
use Illuminate\Http\Response;
use App\Models\NewsModel;
use App\Models\ArticleViewCounter;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class NewsPortal extends Controller
{
  public function update(Request $request, $id)
  {
    try {
      $validatedData = Validator::make($request->all(), [
          'title' => 'required|string|max:255',
          'content' => 'required|string',
          'category' => 'required|string',          
          'ntype' => 'required|in:trending,article',
          'status' => 'required|in:draft,published',
      ]);
      if ($validatedData->fails()) {
          return response()->json(['error' => $validatedData->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
      }
      $newsData = $validatedData->validated();
      $news = NewsModel::findOrFail($id);
      $news->update($newsData);
  } catch (QueryException $e) {
      if ($e->getCode() == 23000) {
          return response()->json(['error' => 'Title already exists'], Response::HTTP_CONFLICT);
      } else {
          return response()->json(['error' => 'Failed to create news'], Response::HTTP_INTERNAL_SERVER_ERROR);
      }
  } catch (\Exception $e) {
      return response()->json(['error' => 'Failed to create news'], Response::HTTP_INTERNAL_SERVER_ERROR);
  }
  }
  public function getMostViewed(){
    $newsWithArticleCount = NewsModel::select('news.*', DB::raw('COUNT(articlecount.articleid) AS article_count'))
    ->join('articlecount', 'news.id', '=', 'articlecount.articleid')
    ->groupBy('news.id')
    ->orderByDesc('article_count')
    ->limit(5)
    ->get();
    return response()->json($newsWithArticleCount);
  }
  public function getTviewed()
{
    $newsWithArticleCount = NewsModel::select('news.*', DB::raw('COUNT(articlecount.articleid) AS article_count'))
        ->join('articlecount', 'news.id', '=', 'articlecount.articleid')
      ->groupBy('news.id')
        ->orderByDesc('article_count')
        ->limit(2)  // Change the limit to 2 to get the two most viewed news articles
        ->get();

    return response()->json($newsWithArticleCount);
}

  public function getArticle($id)
  {
      $article = NewsModel::findOrFail($id);
      return response()->json(['data' => $article]);
  }
  public function getTrendingArticles(){
    $data = NewsModel::where('status', 'published')
    ->where('ntype', 'article')
    ->orderBy('created_at', 'desc')
    ->limit(10)->get();
    return response()->json(['data' =>$data]);
  }
  public function getMainArticle(){
    $data = NewsModel::where('status', 'published')->where('ntype', 'article')->first();
    return response()->json(['data' =>$data]);
  }
  public function index(){
    $data = NewsModel::where('status', 'published')->where('ntype', 'article')->get();
    return response()->json(['data' =>$data]);
  }
  public function news(){
    $data = NewsModel::where('status', 'published')->get();
    return response()->json(['data' =>$data]);
  }
  
  public function getHeadLine(){
    $data = NewsModel::where('status', 'published')->where('ntype', 'headline')->latest()->first();
    return response()->json(['data' =>$data]);
  }
  public function featuredNews(){
    $data = NewsModel::where('status', 'published')->where('ntype', 'featuredNews')->latest()->first();
    return response()->json(['data' =>$data]);
  }
  // public function featuredArticle(){
  //   $articles = NewsModel::where('status', 'published')
  //   ->where('ntype', 'article')
  //   ->latest()
  //   ->take(10)
  //   ->get();
  //   return response()->json(['data' => ['article' => $articles]]);
  // }
  public function featuredArticle(Request $request) {
    $page = $request->query('page', 1); 
    $perPage = 4; 
    $offset = ($page - 1) * $perPage;
    $articles = NewsModel::where('status', 'published')
        ->where('ntype', 'article')
        ->orderBy('updated_at', 'desc')
        ->latest()
        ->skip($offset)
        ->take($perPage)
        ->get();
    $totalArticles = NewsModel::where('status', 'published')
        ->where('ntype', 'article')
        ->count();
    $totalPages = ceil($totalArticles / $perPage);
    return response()->json(['articles' => $articles, 'totalPages' => $totalPages]);
}

  public function countArticleView($articleId){
    $viewCount = ArticleViewCounter::where('articleid', $articleId)->count();
    return response()->json(['articleid' => $articleId, 'count' => $viewCount]);
  }
  public function articlecounter(Request $request){
    $request->validate([
      'id' => 'required|string',
  ]);

  $decryptedId = $request->input('id');

  // Save the decrypted ID to the database
  $decryptedArticle = new ArticleViewCounter();
  $decryptedArticle->articleid = $decryptedId;
  $decryptedArticle->type='view';
  $decryptedArticle->save();
  // Log::info('Decrypted Article ID:', ['id' => $decryptedId]);

  return response()->json(['message' => 'Decrypted ID received and saved successfully'], 200);
  }
  public function addNews(Request $request)
  {
      try {
          $validatedData = Validator::make($request->all(), [
              'title' => 'required|string|max:255|unique:news,title',
              'content' => 'required|string',
              'category' => 'required|string',
              // 'type' => 'required|string',
              // 'ntype' => 'required|string',
              'status' => 'required|in:draft,published',
              'imageUrl' => 'required|string'
          ]);
          if ($validatedData->fails()) {
              return response()->json(['error' => $validatedData->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
          }
          $newsData = $validatedData->validated();
          $newsData['author'] = '1';
          $appUrl = env('APP_URL');
          $newsData['imageUrl'] = $appUrl .'/storage/' . $newsData['imageUrl'];  
          NewsModel::create($newsData);
          return $newsData;
          return response()->json(['message' => 'News created successfully'], Response::HTTP_CREATED);
      } catch (QueryException $e) {
          if ($e->getCode() == 23000) {
              return response()->json(['error' => 'Title already exists'], Response::HTTP_CONFLICT);
          } else {
              return response()->json(['error' => 'Failed to create news'], Response::HTTP_INTERNAL_SERVER_ERROR);
          }
      } catch (\Exception $e) {
          return response()->json(['error' => 'Failed to create news'], Response::HTTP_INTERNAL_SERVER_ERROR);
      }
  }
  

    public function removeNews($id)
    {
         $newsItem = NewsModel::find($id);
         if ($newsItem) {
             $newsItem->delete();             
             return response()->json(['message' => 'News item deleted successfully.'], 200);
         } else {
             return response()->json(['message' => 'News item not found.'], 404);
         }
   }
   
   public function news_article(Request $request){
    $data = NewsModel::where('status', 'published')->where('category', 'news')->get();
    return response()->json(['data' =>$data]);
   }
   public function news_events(Request $request){
    $data = NewsModel::where('status', 'published')->where('category', 'events')->get();
    return response()->json(['data' =>$data]);
   }
   public function news_announcement(Request $request){
    $data = NewsModel::where('status', 'published')->where('category', 'announcement')->get();
    return response()->json(['data' =>$data]);
   }
   public function news_updates(Request $request){
    $data = NewsModel::where('status', 'published')->where('category', 'updates')->get();
    return response()->json(['data' =>$data]);
   }
   public function news_draft(Request $request){
    $data = NewsModel::where('status', 'draft')->get();
    return response()->json(['data' =>$data]);
   }
   
    public function displayAll(Request $request){
      $data = NewsModel::where('status', 'published')->get();
      return response()->json(['data' =>$data]);
    }
    public function getOne(Request $request){
      $newsId = $request->input('news_id');
      $data = NewsModel::find($newsId);
      return response()->json(['data' =>$data]);
    }
    public function modifyNews(Request $request){

    }
    public function postComment(Request $request){

    }
    public function removeComment(Request $request){

    }
    public function displayComment(Request $request){

    }

}
