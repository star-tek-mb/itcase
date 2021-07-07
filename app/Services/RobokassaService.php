<?php


namespace App\Services;


use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class RobokassaService
{
    private $userRepository;

    public function __construct()
    {

        $this->userRepository = new UserRepository();
    }

    public function collectData($user, $type_device = 0)
    {
        $mrh_login = "test";      // your login here
        $mrh_pass1 = "e3nG18gqlOsx0Ne3mUgI";   // merchant pass1 here PASSWORD HERE
        // (unique for shop's lifetime)
        $inv_id = $this->userRepository->createUniqueTransaction($user->id);
        $inv_desc = "desc";   // invoice desc
        $out_summ = 0;   // invoice summ
        $Shp_device = $type_device;

        $crc = md5("$mrh_login:$out_summ:&$inv_id:$mrh_pass1:Shp_device=$Shp_device");
        // build URL
        $url = "https://auth.robokassa.ru/Merchant/Index.aspx?MerchantLogin=$mrh_login&" .
            "OutSum=$out_summ&InvId=$inv_id&Description=$inv_desc&Shp_device=$Shp_device&SignatureValue=$crc";
        return $url;
    }

    public function checkData(Request $request)
    {
        $transaction = $this->userRepository->findTransaction($request->InvId);
        $Shp_device = 0;
        $mrh_pass2 = "jN8y6w8cdBmgN1GQxP6Z";
        $create_hash = md5("$this->OutSum:$transaction:$mrh_pass2:Shp_device=$Shp_device");
        if ($request->SignatureValue != $create_hash) {
            throw new \Exception();
        }
        return $transaction;
    }

    public function fail(Request $request)
    {
        $transaction = $this->userRepository->findTransaction($request->InvId);
        $transaction->user()->update(['account_paid_at', null]);
    }
}