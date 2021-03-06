<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comments;
use Validator,Redirect,Response,File;
use App\Helpers\SlugHelper;
class CommentController extends Controller
{
  public function index()
  {
      $user = auth()->user();
      if ($user->hasRole('contractor')) {
        $accountPage = 'personal';
          return response()->json([
              'user'=>$user,
              'accountPage'=>$accountPage
          ]);

      }else if ($user->hasRole('customer')) {
          if ($user->customer_type == 'legal_entity') $accountPage = 'company';
          else $accountPage = 'personal';
          return response()->json([
              'user'=>$user,
              'accountPage'=>$accountPage
          ]);
      }else{
        abort(403);
      }

  }

  public function createCommentAll(Request $request){
    $user = auth()->user();
    $validationMessages = [
        'comment' => 'Поле является обязательным',
    ];
    $validatedData = Validator::make($request->all(), [
      'comment' => 'required',

  ], $validationMessages)->validate();



  $save_comment = new Comments;
  $save_comment->who_set = $user->name;
  $save_comment->comment = $request->comment;
  $save_comment->save();
      return response()->json([
          'success'=>'Комментарий успешно добавлен',
      ]);
  }

  public function createCommentContractor(Request $request){
    $user = auth()->user();
    $save_comment = new Comments;
    $save_comment->who_set = $user->name;
    $save_comment->comment = $request->comment;
    $save_comment->for_set  = $request->for_comment_id;
    $save_comment->assessment  = $request->rating;
    $save_comment->theme = $request->theme;
    $save_comment->save();
    return response()->json([
          'success'=>'Ваша оценка сохранена!',
      ]);

  }

}
