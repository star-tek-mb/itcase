<?php

namespace App\Http\Controllers\Site;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Models\Chat\Chat;
use App\Models\Chat\Message;
use App\Repositories\ChatRepositoryInterface;
use Illuminate\Http\Request;

class ChatsController extends Controller
{
    /**
     * @var ChatRepositoryInterface
     */
    private $chatRepository;

    /**
     * ChatsController constructor.
     * @param ChatRepositoryInterface $chatRepository
     */
    public function __construct(ChatRepositoryInterface $chatRepository)
    {
        $this->middleware(['auth', 'account.completed']);

        $this->chatRepository = $chatRepository;
    }

    public function index(Request $request)
    {
        $user = auth()->user();
        $accountPage = 'chat';
        if ($request->has('chat_id')) {
            $chat = $this->chatRepository->getById($request->get('chat_id'));

            return view('site.pages.account.chat.show', compact('user', 'chat', 'accountPage'));
        }
        return view('site.pages.account.chat.index', compact('user', 'accountPage'));
    }

    public function sendMessage(Request $request)
    {
        $currentUser = auth()->user();
        $chatId = $request->get('chatId');
        $message = $request->get('message');
        $messageData = [
            'user_id' => $currentUser->id,
            'chat_id' => $chatId,
            'text' => $message
        ];
        $message = Message::create($messageData);
        // broadcast(new MessageSent($message->load('user')));
        return $message->load('user');
    }

    public function fetchMessages(Request $request)
    {
        $chat = Chat::find($request->get('chat_id'));
        $otherUser = $chat->getAnotherUser();
        if ($request->has('unread_only')) {
            $messages = $chat->messages()->where('read', false)->where('user_id', $otherUser->id)->with('user')->get();
            foreach ($messages as $message) {
                $message->read = true;
                $message->save();
            }
            return $messages;
        }
        $messages = $chat->messages()->with('user')->get();
        foreach ($messages as $message) {
            if ($message->user_id == $otherUser->id) {
                $message->read = true;
                $message->save();
            }
        }
        return $messages;
    }

    public function createChat(Request $request)
    {
        $withUserId = $request->get('with_user_id');
        $currentUser = auth()->user();
        foreach ($currentUser->chats as $chat) {
            if ($chat->getAnotherUser()->id == $withUserId) {
                return redirect(route('site.account.chats') . '?chat_id=' . $chat->id);
            }
        }
        $chat = Chat::create();
        $chat->participants()->attach([$currentUser->id, $withUserId]);
        return redirect(route('site.account.chats') . '?chat_id=' . $chat->id);
    }
    public function searchChat(Request $request)
    {
        $accountPage = 'chat';
        $user = auth()->user();
        $chats=Message::where('user_id', $user->id)->where('text', 'LIKE', "%{$request->search}%")
            ->orWhere('text', 'LIKE', "%{$request->search}")
            ->orWhere('text', 'LIKE', "{$request->search}%")
            ->get();

        $results=[];
        foreach ($chats as $chat) {
            $chatId = $this->chatRepository->getById($chat->chat_id);
            $results[]= [
               'id'=>$chat->chat_id,
               'text'=>$chat->text,
               'anotherUser'=>$chatId->getAnotherUser()->hasRole('customer'),
               'title'=>$chatId->getAnotherUser()->getCommonTitle(),
               'image'=>$chatId->getAnotherUser()->getImage()
           ];
        }
        return view('site.pages.account.chat.search', compact('results', 'user', 'accountPage'));
    }
}
