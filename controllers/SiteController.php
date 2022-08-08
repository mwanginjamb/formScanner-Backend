<?php

namespace app\controllers;

use app\models\Documents;
use app\models\LoginForm;
use Couchbase\Document;
use Yii;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\Cors;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\ContactForm;
use app\models\PollingCenter;
use app\models\Summaryviewall;
use Exception;

class SiteController extends Controller
{


    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'add-media', 'index'],
                'rules' => [
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['add-media'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    //'logout' => ['post'],
                    'add-media' => ['post']
                ],
            ],
            'contentNegotiator' => [
                'class' => ContentNegotiator::class,
                'only' => [
                    'add-media'
                ],
                'formatParam' => '_format',
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                    //'application/xml' => Response::FORMAT_XML,
                ],
            ],
            'corsFilter' => [
                'class' => Cors::class,
                'cors' => [
                    // restrict access to
                    //'Origin' => ['capacitor://localhost','http://localhost','http://localhost:8100'],
                    // Allow only POST and PUT methods
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

            ],

        ];
    }

    public function beforeAction($action)
    {
        // return parent::beforeAction($action); // TODO: Change the autogenerated stub
        $allowedActions = ['add-media'];
        if (in_array($action->id, $allowedActions)) {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }


    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],

        ];
    }



    public function actionAddMedia()
    {
        $json = file_get_contents('php://input');

        // Convert it into a PHP object
        $data = json_decode($json);
        //throw new \yii\web\HttpException(500, 'Hello...');
        //exit();

        try {
            if ($data && isset($data->ImageBinary)) {

                $model = Documents::findOne(['id' => $data->id]);
                $model->coordinates = $data->coordinates ?? 0;
                $model->created_by = $data->created_by ?? 0;
                /*Process Media for Saving*/
                $bin = base64_decode($data->ImageBinary);
                $size = $bin ? getImageSizeFromString($bin) : null;
                $ext = $size ? substr($size['mime'], 6) : 'png';
                $img_file = Yii::$app->security->generateRandomString(5) . '.' . $ext;
                $absolute_path = Yii::getAlias('@app') . '\web\\';
                if (file_put_contents($img_file, $bin) && is_file($img_file)) {
                    //Upload to sharepoint
                    $LibraryParts = $this->getLibraryParts($model->polling_station);

                    \Yii::$app->sharepoint->sharepoint_attach($img_file, $LibraryParts);
                    // Create a record in Docs Table
                    $model->local_file_path = Url::home(true) . $img_file;
                    $pathParts = "//sites//DocumentManagementSystem//" . env('SP_LIBRARY') . '//' . $LibraryParts . '//';
                    $pathParts = str_replace('.', "", $pathParts);
                    $path = $pathParts . $img_file;
                    $model->sharepoint_path = $path;
                    if (!$model->save()) {
                        return [
                            'errors' => $model->errors
                        ];
                    }


                    return [
                        'model' => $model
                    ];
                }
            }
        } catch (Exception $e) {
            throw new \yii\web\HttpException(500, $e->getMessage());
        }



        return false;
    }

    public function getLibraryParts($pollingStationCode)
    {
        //$model->sharepoint_path = preg_replace("/\p{P}/u", "", $path);

        $model = PollingCenter::findOne(['polling_station_code' => $pollingStationCode]);
        $path =  $model->county_name . "/" . $model->constituency_name . "/" . $model->caw_name . "/" . $model->polling_station_name . "/" . $model->polling_station_code;
        $parts =  str_replace('.', "", $path); // remove full stops
        $parts = str_replace('\'', '', $path);

        return $parts;
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        //return $this->render('index');
        return $this->redirect('agent');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        $this->layout = 'login';
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }



    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionPrivacy()
    {
        return $this->render('privacy');
    }

    public function actionApp()
    {
        $path = Yii::getAlias('@app') . '/web/app.apk';
        return Yii::$app->response->sendFile($path, 'Observer Android App.apk');
    }
}
