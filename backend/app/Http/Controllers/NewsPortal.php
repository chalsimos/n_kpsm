<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Response;
use App\Models\NewsModel;
class NewsPortal extends Controller
{
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
  public function featuredArticle(){
    $data = NewsModel::where('status', 'published')->where('ntype', 'featuredArticle')->latest()->first();
    return response()->json(['data' =>$data]);
  }
  public function addNews(Request $request)
  {
    try {
      $validatedData = $request->validate([
          'title' => 'required|string|max:255|unique:news,title',
          'content' => 'required|string',
          'type' => 'required|string',
          'status' => 'required|in:draft,published',
          'author' => 'required|string',
      ]);
      NewsModel::create($validatedData);
      return response()->json(['message' => 'News created successfully'], Response::HTTP_CREATED);
    } catch (ValidationException $e) {
        return response()->json(['error' => $e->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
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
