<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\User;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Console;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionAddUser($username, $password, $phonenumber, $email)
    {
        $user = new User();
        $user->username = $username;
        $user->setPassword($password);
        $user->phone_number = $phonenumber;
        $user->email = $email;
        $user->generateAuthKey();
        $user->generateOtp();
        $user->access_token = \Yii::$app->security->generateRandomString(255);
        $user->status = 10;

        if($user->save())
        {
            Console::output('User Created Successfully.');
        }else{
            Console::output(print_r($user->getErrorSummary()));
            Console::error('User not saved');
        }
    }
}
