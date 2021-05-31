<?php
//
//
//namespace App\Notifications;
//
//
//trait SendNotificationFireBase
//{
//    public function sendToApp($instance)
//    {
//        foreach ($this->messageTokens as $messageToken)
//            $this->sendCurl($messageToken, $instance->toArray, 0);
//    }
//
//    private function sendCurl($token, $data, $check)
//    {
//        $curl = curl_init();
//        $fields = [
//            "to" => $token,
//            "data" => $data
//        ];
//        $fields_string = http_build_query($fields);
//        curl_setopt_array($curl, array(
//            CURLOPT_URL => 'https://fcm.googleapis.com/fcm/send',
//            CURLOPT_RETURNTRANSFER => true,
//            CURLOPT_ENCODING => '',
//            CURLOPT_MAXREDIRS => 10,
//            CURLOPT_TIMEOUT => 0,
//            CURLOPT_FOLLOWLOCATION => true,
//            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//            CURLOPT_CUSTOMREQUEST => 'POST',
//            CURLOPT_POSTFIELDS => $fields_string,
//            CURLOPT_HTTPHEADER => array(
//                'Content - Type: application / json'
//            ),
//        ));
//        $response = curl_exec($curl);
//        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
//        curl_close($curl);
//        if ($httpcode != 200 && check < 2) {
//            $this->sendCurl($token,$data, $check + 1);
//        }
//
//    }
//}
