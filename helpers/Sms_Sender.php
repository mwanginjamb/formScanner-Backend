<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/20/2020
 * Time: 10:52 AM
 */

namespace app\helpers;

use yii\di\Container;

class Sms_Sender
{
    /**
     * @param $to
     * @param $msg
     * @return bool
     */

    //Was a static method
    public function sendSms($to, $msg)
    {
        $container = new Container;

        $container->set('sms', [
            'class' => 'app\components\Sms',
            'params' => [
                'username' => 'maserati',//'sandbox',
                'key' => '8923b21f48d935f12ed4e99035e9ffe6f5b0970c2cebe95f5f5864b856dc2d77',
                ],
        ]);
        $class = $container->get('sms');

        try{
            return $class->sendMessage([
                'to'      => $to,
                'sms' => $msg,
            ]);
        }
        catch (\AfricasTalkingGatewayException $e){
            return false;
        }
    }

}