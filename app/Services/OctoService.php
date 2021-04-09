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
            'shop_transaction_id' => 'user:' . $user->id,
            'currency' => 'UZS',
            'total_sum' => '5000',
            'test' => (config('app.env') != 'production'),
            'description' => 'Оплата аккаунта на itcase.com',
            'init_time' => now()->format('Y-m-d H:i:s'),
            'notify_url' => 'https://itcase.com/endpoint/octo',
            'return_url' => 'https://itcase.com'
        ]]);
        $data = json_decode($response->getBody(), true);
        return $data;
    }

    public function process(array $data)
    {
        return $this->status($data);
    }
    
    public function status(array $data)
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
        $check = json_decode($response->getBody());

        if ($check['status'] == 'succeeded') {
            $user = User::find($userId);
            $user->forceFill([
                'account_paid_at' => now()
            ])->save();

            return ['accept_status' => 'completed'];
        }

        return ['status' => 'error', 'message' => 'unsupported request'];
    }
}
