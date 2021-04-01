<?php

namespace App\Models\Traits;

use App\Services\SmsService;

trait MustVerifyPhone
{

    public function hasVerifiedPhone()
    {
        return !is_null($this->phone_verified_at);
    }

    public function markPhoneAsVerified()
    {
        return $this->forceFill([
            'phone_verified_at' => $this->freshTimestamp(),
        ])->save();
    }

    public function sendPhoneVerificationMessage(SmsService $sms)
    {
        $code = rand(100000, 999999);
        $message = __('auth.code', ['code' => $code]);
        $sms->send($this->getPhoneForVerification(), $message);
    }

    public function getPhoneForVerification()
    {
        return $this->phone;
    }
}
