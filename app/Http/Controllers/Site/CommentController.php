<?php

namespace App\Http\Controllers\Site;

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
            return view('site.pages.account.contractor.comment', compact('user', 'accountPage'));
        } elseif ($user->hasRole('customer')) {
            if ($user->customer_type == 'legal_entity') {
                $accountPage = 'company';
            } else {
                $accountPage = 'personal';
            }
            return view('site.pages.account.customer.comment', compact('user', 'accountPage'));
        } else {
            abort(403);
        }
    }

    public function createCommentAll(Request $request)
    {
        $user = auth()->user();
        $validatedData = Validator::make($request->all(), [
            'comment' => 'required',
        ])->validate();

        $comment = Comment::create([
            'who_set' => $user->id,
            'comment' => $request->comment
        ]);
        return redirect()->route('site.account.comment')->with('account.success', 'Комментарий успешно добавлен');
    }

    public function createCommentContractor(Request $request)
    {
        $user = auth()->user();
        $comment = Comment::create([
            'who_set' => $user->id,
            'for_set' => $request->for_comment_id,
            'assessment' => $request->rating,
            'theme' => $request->theme,
            'comment' => $request->comment
        ]);
        return back()->with('success', 'Ваша оценка сохранена!');
    }
}
