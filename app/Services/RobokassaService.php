<?php


namespace App\Services;


use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class RobokassaService
{
    private $userRepository;
    private $OutSum;
    private $OutSumCurrency;

    public function __construct()
    {

        $this->userRepository = new UserRepository();
        $this->OutSum = 5;
        $this->OutSumCurrency = 'USD';
    }

    public function collectData($user, $type_device = 0)
    {
        $mrh_login = "itcase.com";      // your login here
        $mrh_pass1 = "W5bH592Dv1uvSDkuvydb";   // merchant pass1 here PASSWORD HERE
        // (unique for shop's lifetime)
        $inv_id = $this->userRepository->createUniqueTransaction($user->id);
        // invoice desc
        $out_summ = $this->OutSum;   // invoice summ
        $Shp_device = $type_device;

        $crc = md5("$mrh_login:$out_summ:$inv_id:$this->OutSumCurrency:$mrh_pass1:Shp_device=$Shp_device");
        // build URL
        $url = "https://auth.robokassa.ru/Merchant/Index.aspx?MerchantLogin=$mrh_login&" .
            "OutSum=$out_summ&InvId=$inv_id&OutSumCurrency=$this->OutSumCurrency&Shp_device=$Shp_device&SignatureValue=$crc";
        return $url;
    }

    public function checkData(Request $request)
    {
        $transaction = $this->userRepository->findTransaction($request->InvId);
        if ($this->OutSum != $request->OutSum) {
            throw new \Exception();
        }
        return $transaction;
    }

    public function fail(Request $request)
    {
        $transaction = $this->userRepository->findTransaction($request->InvId);
        $transaction->user()->update(['account_paid_at' => null]);
    }
}