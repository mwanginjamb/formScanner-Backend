<?php

namespace app\models;

use Yii;


class UserOtp extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['otp'], 'integer'],
           
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            
        ];
    }


    
    /**
     * Generates OTP
     */
    public function generateOtp()
    {
        $number = time();
        $random = rand(1535,3555);
        $prod = ($number * $random);
        $otp = substr($prod,0,4);
        $this->otp = $otp;
    }




}
