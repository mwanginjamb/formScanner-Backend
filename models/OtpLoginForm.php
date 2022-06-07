<?php

namespace app\models;

use app\modules\apiV1\resources\UserResource;
use Yii;
use yii\base\Model;

/**
 * Login form
 */
class OtpLoginForm extends Model
{
    public $otp;

    protected $_user;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['otp'], 'required']
        ];
    }



    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
        
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */


    public function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByOtp($this->otp);
        }

        return $this->_user;
    }
}
