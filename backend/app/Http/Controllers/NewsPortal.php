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
          'status' => 'required|in:draft,published',
          // 'imageUrl' => 'required|string'
      ]);
      if ($validatedData->fails()) {
          return response()->json(['error' => $validatedData->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
      }
      $newsData = $validatedData->validated();
      $news = NewsModel::findOrFail($id);
      // // $newsData['author'] = '1';
      // // NewsModel::create($newsData);
      $news->update($newsData);
      // return response()->json(['message' => 'News article updated successfully', 'data' => $news], 200);
      // return $newsData;
      
  } catch (QueryException $e) {
      if ($e->getCode() == 23000) {
          return response()->json(['error' => 'Title already exists'], Response::HTTP_CONFLICT);
      } else {
          return response()->json(['error' => 'Failed to create news'], Response::HTTP_INTERNAL_SERVER_ERROR);
      }
  } catch (\Exception $e) {
      return response()->json(['error' => 'Failed to create news'], Response::HTTP_INTERNAL_SERVER_ERROR);
  }


  //   $validatedData = $request->validate([
  //     'title' => 'required|string|max:255',
  //     'content' => 'required|string',
  //     'category' => 'required|string|max:255',
  //     'status' => 'required|string|in:published,draft',
  //     'imageUrl' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
  // ]);
  // $news = NewsModel::findOrFail($id);

  // if ($request->hasFile('imageUrl')) {
  // //     // Delete the old image if it exists
  //     if ($news->imageUrl) {
  //         Storage::delete('public/' . $news->imageUrl);
  //     }

  // //     // Store the new image
  // //     $path = $request->file('imageUrl')->store('images', 'public');
  // //     $validatedData['imageUrl'] = $path;
  // }

  // // $news->update($validatedData);

  // // return response()->json(['message' => 'News article updated successfully', 'data' => $news], 200);
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
              'type' => 'required|string',
              'ntype' => 'required|string',
              'status' => 'required|in:draft,published',
              'imageUrl' => 'required|string'
          ]);
          if ($validatedData->fails()) {
              return response()->json(['error' => $validatedData->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
          }
          $newsData = $validatedData->validated();
        //   if ($request->hasFile('images')) {
        //     $imageUrls = [];
        //     foreach ($request->file('images') as $image) {
        //         // Generate a unique filename
        //         // $filename = uniqid() . '.' . $image->getClientOriginalExtension();
        //         // Save the image to the storage directory
        //         $path = $image->store('public/uploads');
        //         // Store the image URL
        //         $imageUrls[] = $path;
        //     }
        //     // Convert image URLs to JSON string
        //     // $newsData['imagePaths'] = implode(',', $imagePaths);
        //     // $newsData['imageUrl'] = json_encode($imageUrls);
        //     $newsData['imageUrl'] = implode(',', $imageUrls);
        // }
          // $newsData['imageUrl'] = isset($newsData['imgUrl']) ? json_encode($newsData['imgUrl']) : null;
          $newsData['author'] = '1';
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
  

    public function removeNews(Request $request)
    {
       $newsId = $request->input('news_id');
       $news = NewsModel::find($newsId);
       if ($news) {
           $news->delete();
           return response()->json(['message' => 'News removed successfully']);
       } else {
           return response()->json(['error' => 'News not found'], 404);
       }
   }
   public function news_article(Request $request){
    $data = NewsModel::where('status', 'published')->where('category', 'article')->get();
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
