<?php

namespace app\models;

use app\models\User;
use Yii;
use yii\base\Model;


/**
 * Password reset request form
 */
class OtpRequestForm extends Model
{
    public $username;
    public $_otp;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'exist',
                'targetClass' => User::class,
                //'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => 'Enter National ID No. of a valid Agent.'
            ],
        ];
    }

    // Send OTP TO USERS No

    public function sendOtp()
    {
        /* @var $user User */
        $user = UserOtp::findOne([
            'username' => $this->username,
        ]);

        if (!$user) {
            return false;
        }

        if ($user) {
            $user->generateOtp();
            if (!$user->save(false)) {
                return false;
            }
        }
        $this->_otp = $user->otp;

        $number = $user->phone_number;
        $message = "Agent Authentication OTP: ".$user->otp."\r\n";
        Yii::$app->africasms->sendSms($number,$message);
        return $user->true;
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return bool whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user User */
        $user = User::findOne([
            'status' => User::STATUS_ACTIVE,
            'email' => $this->email,
        ]);

        if (!$user) {
            return false;
        }
        
        if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            if (!$user->save()) {
                return false;
            }
        }

        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Password reset for ' . Yii::$app->name)
            ->send();
    }
}
