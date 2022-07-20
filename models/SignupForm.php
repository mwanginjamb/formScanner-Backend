<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;
use yii\db\ActiveRecord;

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
    public $otp;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This user ID has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            // ['email', 'required'],
            // ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],

            ['password_confirm', 'required'],
            ['password_confirm', 'compare', 'compareAttribute' => 'password'],

            ['phone_number', 'required'],
            ['phone_number', 'string', 'max' => 10],
            ['phone_number', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This phone number is already taken.'],


            ['full_names', 'required'],
            ['full_names', 'string', 'max' => '150'],
            ['otp', 'string', 'max' => '5']

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
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        $user->generateEmailVerificationToken();
        $user->generateOtp();
        $user->access_token = \Yii::$app->security->generateRandomString(255);
        $user->status = 10;
        $user->phone_number =  $this->phone_number;
        $user->full_names = $this->full_names;

        return $user->save() /*&& $this->sendEmail($user)*/;
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
}
