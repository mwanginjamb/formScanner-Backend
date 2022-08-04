<?php

/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 5/26/2022
 * Time: 12:54 AM
 */

namespace app\modules\apiV1\controllers;


use app\models\Candidate;
use app\models\LoginForm;
use app\models\Summaryviewall;
use app\models\User;
use app\modules\apiV1\resources\UserResource;
use Yii;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\rest\ActiveController;
use yii\rest\Controller;

class UserController extends Controller
{
    // public $modelClass = Candidate::class;

    public function behaviors()
    {
        $behaviours =  parent::behaviors(); // TODO: Change the autogenerated stub

        $behaviours['cors'] = [
            'class' => Cors::class,
            'cors' => [
                // restrict access to
                //'Origin' => ['*'],
                //  methods to allow
                'Access-Control-Request-Method' => ['POST', 'PUT', 'GET'],
                // Allow only headers 'X-Wsse'
                'Access-Control-Request-Headers' => ['*'],
                // Allow credentials (cookies, authorization headers, etc.) to be exposed to the browser
                'Access-Control-Allow-Credentials' => false,
                // Allow OPTIONS caching
                'Access-Control-Max-Age' => 3600,
                // Allow the X-Pagination-Current-Page header to be exposed to the browser.
                'Access-Control-Expose-Headers' => ['X-Pagination-Current-Page'],
            ],
        ];

        $behaviours['verbs'] = [
            'class' => VerbFilter::class,
            'actions' => [
                'login' => ['post'],
            ],
        ];



        return $behaviours;
    }


    public function actionLogin()
    {
        /* if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }*/

        $model = new \app\modules\apiV1\models\LoginForm();
        if ($model->load(Yii::$app->request->post(), '') && $model->login()) {
            return $model->getUser();
        }

        Yii::$app->response->statusCode = 422;
        return [
            'errors' => $model->errors,
        ];
    }


    public function actionSignup()
    {
        $model = new \app\modules\apiV1\models\SignupForm();
        if ($model->load(Yii::$app->request->post(), '') && $model->signup()) {
            return $model->_user;
        }

        Yii::$app->response->statusCode = 422;
        return [
            'errors' => $model->errors,
        ];
    }

    // Agent SUmmary

    public function actionAgent()
    {

        $model = new Summaryviewall();
        if ($model->load(Yii::$app->request->post(), '') && $model->fetch()) {
            //return User::findByPhone($model->phone_number)->station;
            return $model->_summary;
        }
        //return $model;

        Yii::$app->response->statusCode = 422;
        return [
            'errors' => $model->errors,
        ];
    }

    public function actionAgents()
    {
        //$model = new Summaryviewall();
        $agents = Summaryviewall::find()->all();
        return $agents;
    }

    public function actionRequestOtp()
    {
        $model = new \app\models\OtpRequestForm();
        if ($model->load(Yii::$app->request->post(), '') && $model->sendOtp()) {
            return ['otp' => $model->_otp];
        }

        Yii::$app->response->statusCode = 422;
        return [
            'errors' => $model->errors,
        ];
    }

    public function actionOtpLogin()
    {
        $model = new \app\modules\apiV1\models\OtpLoginForm();
        if ($model->load(Yii::$app->request->post(), '') && $model->login()) {
            return $model->getUser();
        }

        Yii::$app->response->statusCode = 422;
        return [
            'errors' => $model->errors,
        ];
    }

    public function actionClient()
    {
        print_r(file_get_contents('php://input'));
    }

    public function actionIncident()
    {
        print_r(file_get_contents('php://input'));
    }
}
