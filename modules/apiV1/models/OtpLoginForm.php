<?php

namespace app\modules\apiV1\models;

use app\modules\apiV1\resources\UserResource;
use Yii;
use yii\base\Model;

/**
 * Login form
 */
class OtpLoginForm extends \app\models\OtpLoginForm
{


    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === null) {
            $this->_user = UserResource::findByOtp($this->otp);
        }

        return $this->_user;
    }
}
