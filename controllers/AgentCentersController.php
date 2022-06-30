<?php

namespace app\controllers;

use app\models\AgentCenters;
use app\models\AgentCentersSearch;
use app\models\Counties;
use app\models\PollingCenter;
use app\models\ResultsLevel;
use app\models\User;
use app\modules\apiV1\resources\UserResource;
use yii\bootstrap4\Html;
use yii\filters\ContentNegotiator;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Response;

/**
 * AgentCentersController implements the CRUD actions for AgentCenters model.
 */
class AgentCentersController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
                'contentNegotiator' => [
                    'class' => ContentNegotiator::class,
                    'only' => [
                        'constituency', 'list'
                    ],
                    'formatParam' => '_format',
                    'formats' => [
                        'application/json' => Response::FORMAT_JSON,
                        //'application/xml' => Response::FORMAT_XML,
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all AgentCenters models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new AgentCentersSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $users = ArrayHelper::map(UserResource::find()->all(), 'id', 'full_names');
        /* $assignment = AgentCenters::find()->with('center')->all();
        print '<pre>';
        print_r($assignment[0]);
        exit;*/

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionList()
    {
        $assignment = AgentCenters::find()->with('center')->with('user')->with('level')->asArray()->all();

        //\Yii::$app->utilities->printrr($assignment);

        foreach ($assignment as $a) {
            $update = Html::a('<i class="fa fa-edit"></i>', ['update', 'id' => $a['id']], ['class' => 'mx-1']);

            $delete = Html::a('<i class="fa fa-trash"></i>', ['delete', 'id' => $a['id']], [
                'class' => 'bg-danger',
                'title' => 'Delete assignment',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this assignment?',
                    'method' => 'post',
                ],
            ]);

            $result['data'][] = [
                'username' => $a['user']['full_names'] ?? '',
                'phone_number' => $a['user']['phone_number'] ?? '',
                'county' =>  $a['center']['county_name'] ?? '',
                'Ward' =>  $a['center']['caw_name'] ?? '',
                'constituency' => $a['center']['constituency_name'] ?? '',
                'center' => $a['center']['registration_center_name'] ?? '',
                'polling_station_code' => $a['center']['polling_station_code'] ?? '',
                'level' => $a['level']['description'] ?? '',
                'actions' => $update . $delete
            ];
        }

        return $result;
    }

    /**
     * Displays a single AgentCenters model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new AgentCenters model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new AgentCenters();
        $model->scenario = 'scenariocreate';
        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        $counties = Counties::find()->asArray()->all();
        $constituencies = PollingCenter::find()->select(['constituency_code', 'constituency_name', 'county_code'])->distinct()->asArray()->all();
        $wards = PollingCenter::find()->select(['caw_code', 'caw_name'])->distinct()->asArray()->all();
        $centers = PollingCenter::find()->select(['registration_center_code', 'registration_center_name'])->distinct()->where(['<>', 'registration_center_name', ''])->asArray()->all();
        $resultLevel = ResultsLevel::find()->all();
        // \Yii::$app->utilities->printrr($centers);
        return $this->render('create', [
            'model' => $model,
            'agents' => ArrayHelper::map(UserResource::find()->all(), 'id', 'full_names'),
            'polling_stations' => [],
            'counties' => ArrayHelper::map($counties, 'CountyID', 'CountyName'),
            'constituencies' => ArrayHelper::map($constituencies, 'constituency_code', 'constituency_name'),
            'wards' => ArrayHelper::map($wards, 'caw_code', 'caw_name'),
            'centers' => ArrayHelper::map($centers, 'registration_center_code', 'registration_center_name'),
            'levels' => ArrayHelper::map($resultLevel, 'level', 'description'),
        ]);
    }

    // ArrayHelper::map(PollingCenter::find()
    //             ->select(['concat(county_name," ",constituency_name," ",polling_station_name," ",polling_station_code) as station', 'id'])
    //             ->asArray()
    //             ->all(), 'id', 'station')

    /**
     * Updates an existing AgentCenters model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = 'scenarioupdate';
        // \Yii::$app->utilities->printrr($model->user);
        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }
        $counties = Counties::find()->asArray()->all();
        $constituencies = PollingCenter::find()->select(['constituency_code', 'constituency_name', 'county_code'])->distinct()->asArray()->all();
        $wards = PollingCenter::find()->select(['caw_code', 'caw_name'])->distinct()->asArray()->all();
        $centers = PollingCenter::find()->select(['registration_center_code', 'registration_center_name'])->distinct()->where(['<>', 'registration_center_name', ''])->asArray()->all();
        $resultLevel = ResultsLevel::find()->all();
        // $model->county = $model->center->county_name;

        return $this->render('update', [
            'model' => $model,
            'agents' => ArrayHelper::map(UserResource::find()->all(), 'id', 'full_names'),
            'polling_stations' => [],
            'counties' => ArrayHelper::map($counties, 'CountyID', 'CountyName'),
            'constituencies' => [], // ArrayHelper::map($constituencies, 'constituency_code', 'constituency_name'),
            'wards' => [], // ArrayHelper::map($wards, 'caw_code', 'caw_name'),
            'centers' => [], // ArrayHelper::map($centers, 'registration_center_code', 'registration_center_name')
            'levels' => ArrayHelper::map($resultLevel, 'level', 'description'),
        ]);
    }

    /**
     * Deletes an existing AgentCenters model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AgentCenters model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return AgentCenters the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AgentCenters::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public function actionConstituencyDd($county)
    {
        $data = PollingCenter::find()->select(['constituency_code', 'constituency_name', 'county_code'])->distinct()
            ->where(['county_code' => $county])
            ->asArray()->all();

        if (count($data)) {
            ob_start();
            echo '<option value="0">Select...</option>';
            foreach ($data  as $d) {
                echo "<option value='" . $d['constituency_code'] . "'>" . $d['constituency_name'] . "</option>";
                $listData = ob_get_contents();
            }
            ob_end_clean();
            echo $listData;
            exit;
        } else {
            echo "<option value=''>No data Available</option>";
        }
    }



    public function actionWardDd($constituency)
    {
        $data = $wards = PollingCenter::find()->select(['caw_code', 'caw_name'])->distinct()
            ->where(['constituency_code' => $constituency])
            ->asArray()->all();

        if (count($data)) {
            ob_start();
            echo '<option value="0">Select...</option>';
            foreach ($data  as $d) {
                echo "<option value='" . $d['caw_code'] . "'>" . $d['caw_name'] . "</option>";
                $listData = ob_get_contents();
            }
            ob_end_clean();
            echo $listData;
            exit;
        } else {
            echo "<option value=''>No data Available</option>";
        }
    }

    public function actionCenterDd($ward)
    {
        $data = PollingCenter::find()->select(['registration_center_code', 'registration_center_name'])->distinct()
            ->where(['<>', 'registration_center_name', ''])
            ->andWhere(['caw_code' => $ward])
            ->asArray()->all();

        if (count($data)) {
            ob_start();
            echo '<option value="0">Select...</option>';
            foreach ($data  as $d) {
                echo "<option value='" . $d['registration_center_code'] . "'>" . $d['registration_center_name'] . "</option>";
                $listData = ob_get_contents();
            }
            ob_end_clean();
            echo $listData;
            exit;
        } else {
            echo "<option value=''>No data Available</option>";
        }
    }

    public function actionStationDd($ward)
    {
        $data = PollingCenter::find()
            ->select(['concat(county_name," ",constituency_name," ",polling_station_name," ",polling_station_code) as station', 'id', 'polling_station_code'])
            ->where(['caw_code' => $ward])
            ->asArray()
            ->all();

        if (count($data)) {
            ob_start();
            echo '<option value="0">Select...</option>';
            foreach ($data  as $d) {
                echo "<option value='" . $d['id'] . "'>" . $d['station'] . "</option>";
                $listData = ob_get_contents();
            }
            ob_end_clean();
            echo $listData;
            exit;
        } else {
            echo "<option value=''>No data Available</option>";
        }
    }
}
