<?php

namespace App\Models\Traits;

use App\Services\SmsService;

trait MustVerifyPhone
{

    public function hasVerifiedPhone()
    {
        return !is_null($this->phone_confirmed_at);
    }

    public function verifyPhoneCode($code)
    {
        return $this->phone_confirmation_code && $this->phone_confirmation_code == $code;
    }

    public function markPhoneAsVerified()
    {
        return $this->forceFill([
            'phone_confirmed_at' => $this->freshTimestamp(),
        ])->save();
    }

    public function sendPhoneVerificationMessage()
    {
        if ($this->hasVerifiedPhone()) {
            return;
        }

        $sms = resolve(SmsService::class);
        $code = rand(100000, 999999);
        $this->forceFill([
            'phone_confirmation_code' => $code,
        ])->save();
        $message = __('auth.code', ['code' => $code]);
        $sms->send($this->getPhoneForVerification(), $message);
    }

    public function getPhoneForVerification()
    {
        return !is_null($this->phone_number)
            ? ($this->phone_number[0] == '+' ? substr($this->phone_number, 1) : $this->phone_number)
            : null;
    }
}
