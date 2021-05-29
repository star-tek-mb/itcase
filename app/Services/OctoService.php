<?php

namespace App\Services;

use GuzzleHttp\Client;
use App\Models\User;

class OctoService
{

    public function requestPayment(User $user)
    {
        $client = new Client();
        $response = $client->post('https://secure.octo.uz/prepare_payment', ['json' => [
            'octo_shop_id' => config('services.octo.shop_id'),
            'octo_secret' => config('services.octo.secret'),
            'auto_capture' => true,
            'shop_transaction_id' => 'user:' . $user->id,
            'currency' => 'UZS',
            'total_sum' => 53000,
            'test' => (config('app.env') != 'production'),
            'description' => 'Оплата аккаунта на itcase.com',
            'init_time' => now()->format('Y-m-d H:i:s'),
            'notify_url' => 'https://itcase.com/endpoint/octo',
            'return_url' => $user->dynamic ? 'https://itcase.page.link/qL6j' : 'https://itcase.com/thanks'
        ]]);
        $data = json_decode($response->getBody(), true);
        return $data['octo_pay_url'];
    }

    public function process(array $data)
    {
        try {
            return $this->notify($data);
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => 'shop_transaction_id find failed?'];
        }
    }

    public function notify(array $data)
    {
        if (strpos($data['shop_transaction_id'], 'user:') === false) {
            return ['status' => 'error', 'message' => 'shop_transaction_id not found'];
        }
        $userId = substr($data['shop_transaction_id'], strlen('user:'));

        $client = new Client();
        $response = $client->post('https://secure.octo.uz/prepare_payment', ['json' => [
            'octo_shop_id' => config('services.octo.shop_id'),
            'octo_secret' => config('services.octo.secret'),
            'shop_transaction_id' => $data['shop_transaction_id'],
            'octo_payment_UUID' => $data['octo_payment_UUID'],
        ]]);
        $check = json_decode($response->getBody(), true);
        
        if ($check['status'] == 'succeeded') {
            $user = User::find($userId);
            $user->forceFill([
                'account_paid_at' => now()
            ])->save();

            return ['accept_status' => 'completed'];
        } else if ($check['status'] == 'waiting_for_capture') {
            return ['accept_status' => 'capture'];
        } else if ($check['status'] == 'canceled') {
            $user = User::find($userId);
            $user->forceFill([
                'account_paid_at' => null
            ])->save();

            return ['accept_status' => 'canceled'];
        }

        return ['status' => 'error', 'message' => 'unsupported request'];
    }

}
