<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Dropbox\Exception;
use Illuminate\Http\Request;


class PaymentController extends Controller
{
    /**
     * @var UserRepository
     */
    private $userRepository;


    public function __construct(UserRepository $userRepository)
    {

        $this->userRepository = $userRepository;
    }

    public function checkUser(Request $request)
    {
        try {
            $exists = $this->userRepository->get($request->user_id);

            return response()->json(
                [
                    'status' => 0,
                    "message" => "",
                    "full_name" => $exists->first_name . $exists->last_name,
                    "amount" => 50000,
                ],
                200
            );
        } catch (\Exception $e) {

            return response()->json(
                [
                    'status' => -1,
                    "message" => "Не существует аккаунта",
                    "full_name" => "",
                    "amount" => 0,
                ],
                400
            );
        }
    }

    public function makePayment(Request $request)
    {
        if (!$request->has('user_id') || !$request->has('transaction_id') || !$request->has('amount')) {
            return response()->json(
                [
                    'status' => -1,
                    "message" => "Недостаточно данных",
                    "full_name" => "",
                    "amount" => 0,
                ],
                400
            );
        } else if ($request->amount != 50000) {
            return response()->json(
                [
                    'status' => -1,
                    "message" => "Неправильная сумма",
                    "full_name" => "",
                    "amount" => 0,
                ],
                400
            );
        } else {
            try {
                $user = $this->userRepository->get($request->user_id);
                if ($user->account_paid_at == null) {
                    $transaction = $this->userRepository->createTransaction($user->id, $request->transaction_id);
                    $user->account_paid_at = Carbon::now();
                    $user->save();
                    return response()->json(
                        [
                            'status' => 0,
                            "message" => "",
                        ],
                        200
                    );
                }
                else {
                    return response()->json(
                        [
                            'status' => -1,
                            "message" => "Пользователь уже заплатил",
                        ],
                        200
                    );
                }
            }
            catch (\Exception $e) {

                return response()->json(
                    [
                        'status' => -1,
                        "message" => "Не существует аккаунта",
                        "full_name" => "",
                        "amount" => 0,
                    ],
                    400
                );
            }

        }
    }

    public function cancelPayment(Request $request)
    {
        if (!$request->has('user_id') || !$request->has('transaction_id')) {
            return response()->json(
                [
                    'status' => -1,
                    "message" => "Недостаточно данных",
                    "full_name" => "",
                    "amount" => 0,
                ],
                400
            );
        } else {
            try {
                $transaction = $this->userRepository->findTransaction($request->transaction_id);
                $user = $this->userRepository->get($request->user_id);
                if ($transaction->user == $user) {
                    $user->account_paid_at = null;
                    $user->save();
                    $transaction->delete();
                    return response()->json( [
                        'status' => 0,
                        'message' => ""
                    ],200);
                }
                else {
                    return response()->json([
                        'status' => -1,
                        'message' => "Аккаунт не имеет такой транзакции"
                    ], 400);
                }

            } catch (\Exception $e) {
                    return response()->json(
                        [
                            'status'=>-1,
                            'message'=>"Аккаунт или Транзакция не были найдены"
                        ],
                        400
                    );
            }

        }
    }

}
