<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use Validator;
use Redirect;
use Response;
use File;
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
        } elseif ($user->hasRole('customer')) {
            if ($user->customer_type == 'legal_entity') {
                $accountPage = 'company';
            } else {
                $accountPage = 'personal';
            }
            return response()->json([
                'user'=>$user,
                'accountPage'=>$accountPage
            ]);
        } else {
            abort(403);
        }
    }
    public function getCommentsOfUser(int $user_id){
        $comments = Comment::where('for_set', '=', $user_id)->get()->map(function ($com){
            $author = $com->author;
            $com->who_set = $author->first_name . " " . $author->last_name;
            $com->images = $author->image;
            return $com;
        });
        return response()->json([
            'comments'=>$comments,
        ]);
    }
    public function createCommentAll(Request $request)
    {
        $user = auth()->user();
        $validatedData = Validator::make($request->all(), [
            'comment' => 'required'
        ])->validate();

        $comment = Comment::create([
            'who_set' => $user->id,
            'comment' => $request->comment
        ]);
        return response()->json([
            'success'=>'Комментарий успешно добавлен',
        ]);
    }

    public function createCommentContractor(Request $request)
    {
        $user = auth()->user();
        $comment = Comment::create([
            'who_set' => $user->id,
            'for_set' => $request->for_comment_id,
            'assessment' => $request->rating,
            'comment' => $request->comment
        ]);
        return response()->json([
            'success'=>'Ваша оценка сохранена!',
        ]);
    }
}
