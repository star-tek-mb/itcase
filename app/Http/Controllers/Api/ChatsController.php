<?php

namespace App\Http\Controllers\Api;

use App\Events\MessageSent;
use Illuminate\Support\Facades\Validator;
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
        $this->middleware(['auth:sanctum', 'account.completed']);

        $this->chatRepository = $chatRepository;
    }

    public function index(Request $request, int $chat_id)
    {
        $user = auth()->user();

        $chat = $this->chatRepository->getById($chat_id);
        if ($chat) {
            return response()->json([
                'chat' => $chat->messages()->orderBy('id', 'DESC')->paginate(30),
            ], 200);
        }
        return response()->json([
            'errors' => "Чата не сущевствует",
        ], 400);
    }

    public function allChats()
    {
        $user = auth()->user();
        $result = $user->chats->all();
        $response = [];
        foreach ($result as $res) {
            $other_user = $res->getAnotherUser();
            $last_message = $res->messages();
            array_push($response, [
                'chat_id' => $res->id,
                'user' => [
                    'id' => $other_user->id,
                    'first_name' => $other_user->first_name,
                    'last_name' => $other_user->last_name,
                    'last_online_at' => $other_user->last_online_at,
                    'image' => $other_user->image,
                ],
                'unread' => $last_message->where('read', 0)->where('user_id', '!=', $user->id)->count(),
                'last_message' => $last_message->orderBy('id', 'DESC')->first(),
            ]);
        }
        return response()->json(
            $response, 200);
    }

//    public function index(Request $request)
//    {
//        $user = auth()->user();
//        $accountPage = 'chat';
//        if ($request->has('chat_id')) {
//            $chat = $this->chatRepository->getById($request->get('chat_id'));
//            $other_user  = $chat->participants->where('id',"!=", $user->id);
//            return response()->json([
//                'user' => $other_user,
//                'accountPage' => $accountPage,
//                'chat' => $chat,
//            ]);
//        }
//        return response()->json([
//            'user' => $user,
//            'accountPage' => $accountPage,
//        ]);
//    }
    public function sendMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'chat_id' => 'required',
            'text' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $currentUser = auth()->user();
        $chatId = $request->get('chat_id');
        $message = $request->get('text');
        $messageData = [
            'user_id' => $currentUser->id,
            'chat_id' => $chatId,
            'text' => $message
        ];
        $message = Message::create($messageData);
        return response()->json([
            'id' => $message->id,
            'created_at' => $message->created_at,
        ], 200);
    }

    //FOR NOTIFICATION
    public function notificationLastMessages()
    {
        $user = auth()->user();
        $id = $user->id;
        $chats = $user->chats()->get()->map(function (Chat $chat) use ($id) {
            $message = $chat->messages()->where('user_id', '!=', $id)->where('read', '=', 0)->orderBy('id', 'DESC')->first();
            return [
                'chat_id' => $message->chat_id,
                'user' => [
                    'id' => $message->user->id,
                    'first_name' => $message->user->first_name,
                    'last_name' => $message->user->last_name,
                    'last_online_at' => $message->user->last_online_at,
                    'image' => $message->user->image,
                ],
                    'last_message'=> $message,
                'unread' =>0,
                ];
        });
        return response()->json($chats, 200);
    }

    // checking message was read or not
    public function messagesIsRead(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'messages_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $messages_id = $request->messages_id;

        $response = Message::whereIn('id', $messages_id)->get()->map(function (Message $message) {
            return [
                'id' => $message->id,
                'read' => $message->read,
            ];
        });
        return response()->json($response, 200);
    }

    public function updateChat(int $chat_id, int $message_id)
    {
        $chat = Chat::find($chat_id);
        $user = auth()->user();
        $message = $chat->messages()->where('id', '>', $message_id)->where('user_id', '!=', $user->id)->where('read', '=', 0)->orderBy('id', 'DESC')->get();
        return response()->json($message, 200);
    }

    public function fetchMessages(Request $request, int $chat_id)
    {

        $chat = Chat::find($chat_id);
        if ($chat) {
            $otherUser = $chat->getAnotherUser();

            $messages = $chat->messages()->where('read', false)->where('user_id', $otherUser->id)->with('user')->get();
            foreach ($messages as $message) {
                $message->read = true;
                $message->save();
            }
            return response()->json([], 200);

        }
        return response()->json([], 400);
//        $messages = $chat->messages()->with('user')->get();
//        foreach ($messages as $message) {
//            if ($message->user_id == $otherUser->id) {
//                $message->read = true;
//                $message->save();
//            }
//        }
//        return response()->json([
//            'messages'=>$messages
//        ]);
    }

    public function createChat(Request $request)
    {
        $withUserId = $request->get('with_user_id');
        $currentUser = auth()->user();
        foreach ($currentUser->chats as $chat) {
            if ($chat->getAnotherUser()->id == $withUserId) {
                return response()->json([
                    'chat_id' => $chat->id
                ]);
            }
        }
        $chat = Chat::create();
        $chat->participants()->attach([$currentUser->id, $withUserId]);
        return response()->json([
            'chat_id' => $chat->id
        ]);
    }
}
