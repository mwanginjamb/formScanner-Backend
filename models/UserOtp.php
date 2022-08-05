<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;

class UserOtp extends ActiveRecord
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
            ['full_names', 'string', 'max' => '150'],
            ['phone_number', 'string'],
            ['username', 'string', 'min' => 2, 'max' => 255],


        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [];
    }



    /**
     * Generates OTP
     */
    public function GenerateOtp()
    {
        $number = time();
        $random = rand(1535, 3555);
        $prod = ($number * $random);
        $otp = substr($prod, 0, 4);
        $this->otp = $otp;
    }


    public function getAssignment()
    {
        return $this->hasOne(AgentCenters::class, ['agent_id' => 'id']);
    }
}
