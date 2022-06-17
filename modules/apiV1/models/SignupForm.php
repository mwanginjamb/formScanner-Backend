<?php

namespace app\modules\apiV1\models;

use app\models\User;
use Yii;
use yii\base\Model;


/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $password_confirm;
    public $phone_number;
    public $full_names;

    public $_user;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This National ID has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
           // ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],
            ['password_confirm', 'required'],
            ['password_confirm', 'compare','compareAttribute' => 'password'],

            ['phone_number', 'required'],
            ['phone_number', 'string', 'max' => 10],
            ['phone_number', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This Phone Number has already been taken.'],

            ['full_names', 'required'],
            ['full_names', 'string', 'max' => '150']

        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
        if (!$this->validate()) {
            return false;
        }
        
        $this->_user = new User();
        $this->_user->username = $this->username;
        $this->_user->email = $this->email;
        $this->_user->setPassword($this->password);
        $this->_user->generateAuthKey();
        $this->_user->generateEmailVerificationToken();
        $this->_user->generateOtp();
        $this->_user->access_token = \Yii::$app->security->generateRandomString(255);
        $this->_user->status = 10;
        $this->_user->phone_number = $this->phone_number;
        $this->full_names = $this->full_names;

        if($this->_user->save() && $this->sendSms($this->_user)){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }

    // Send OTP SMS
    protected function sendSms(User $user)
    {
        $number = $user->phone_number;
        $message = "Agent Authentication OTP: ".$user->otp."\r\n";
        Yii::$app->africasms->sendSms($number,$message);
    }
}
