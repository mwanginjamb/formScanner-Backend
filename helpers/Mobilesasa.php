<?php

namespace app\helpers;

use yii;
use yii\base\Component;

class Mobilesasa extends Component
{
    public function sendsms($number, $message)
    {
        $curl = curl_init();
        $data_string = json_encode([
            "senderID" => "23359",
            "message" => $message . " STOP *456*9*5#",
            "phone" => $number
        ]);
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.mobilesasa.com/v1/send/message',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYPEER => false, // DON'T VERIFY SSL CERTIFICATE
            CURLOPT_SSL_VERIFYHOST => 0, // DON'T VERIFY HOST NAME
            CURLOPT_CUSTOMREQUEST => 'POST',
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string),
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'Content-Type: application/json',
                'Authorization: Bearer RxXuzVHOlW8n82q1eiACUs13xFRieW8QpZ0n3CavWAWfWohfSkI71z5MO8P8'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        // echo $response;

        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
            //echo $error_msg;
            Yii::$app->utilities->logger($error_msg);
        }
        Yii::$app->utilities->logger($response);
        curl_close($curl);
        //echo $response
    }
}
//CURLOPT_SSL_VERIFYPEER => false, // DON'T VERIFY SSL CERTIFICATE
  //          CURLOPT_SSL_VERIFYHOST => 0, // DON'T VERIFY HOST NAME