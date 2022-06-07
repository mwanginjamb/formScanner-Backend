<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 5/26/2022
 * Time: 12:54 AM
 */

namespace app\modules\apiV1\controllers;


use app\models\Candidate;
use app\models\Counties;
use app\models\PollingCenter;
use app\models\Wards;
use yii\filters\Cors;
use yii\rest\ActiveController;

class WardController extends ActiveController
{
    public $modelClass = Wards::class;

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

        return $behaviours;
    }

    protected function verbs()
    {
        return [
            'index' => ['GET', 'HEAD'],
            'view' => ['GET', 'HEAD'],
            'create' => ['POST'],
            'update' => ['PUT', 'PATCH'],
            'delete' => ['DELETE'],
            'weekly-sales' => ['GET']
        ];
    }
}