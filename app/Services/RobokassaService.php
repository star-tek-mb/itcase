<?php


namespace App\Services;


use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class RobokassaService
{
    private $userRepository;
    private $OutSum;
    public function __construct()
    {

        $this->userRepository = new UserRepository();
        $this->OutSum = 10;
    }

    public function collectData($user, $type_device = 0)
    {
        $mrh_login = "adminsulton777";      // your login here
        $mrh_pass1 = "W5bH592Dv1uvSDkuvydb";   // merchant pass1 here PASSWORD HERE
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
        $mrh_pass2 = "pX61xEZUy7JuF8ViXLw8";
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