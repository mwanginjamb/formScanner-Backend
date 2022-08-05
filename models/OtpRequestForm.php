<?php

namespace app\models;

use app\models\User;
use Exception;
use Yii;
use yii\base\Model;


/**
 * Password reset request form
 */
class OtpRequestForm extends Model
{
    public $username;
    public $_otp;
    public $phone_number;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            [
                'username', 'exist',
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
        $user = UserOtp::find()->where([
            'username' => $this->username,
        ])->one();

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
        $this->phone_number = $user->phone_number;
        $message = "Agent Authentication OTP: " . $user->otp . "\r\n";
        // Yii::$app->africasms->sendSms($number,$message);
        try {
            $number = $this->phone_number;
            $res = $this->sendsms($number, $message);
            Yii::$app->utilities->logger($res);
        } catch (Exception $e) {
            return ('Exception: ' . $e->getMessage());
        }
        return true;
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
        //echo $response;
    }
}
