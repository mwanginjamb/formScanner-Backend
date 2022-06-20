<?php

namespace app\controllers;

use app\models\AgentCenters;
use app\models\AgentCentersSearch;
use app\models\PollingCenter;
use app\models\User;
use app\modules\apiV1\resources\UserResource;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

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
        /*print '<pre>';
        print_r($users);
        exit;*/

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
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

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'agents' => ArrayHelper::map(UserResource::find()->all(), 'id', 'full_names'),
            'polling_stations' => ArrayHelper::map(PollingCenter::find()
                ->select(['concat(county_name," ",constituency_name," ",polling_station_name," ",polling_station_code) as station', 'id'])
                ->asArray()
                ->all(), 'id', 'station')
        ]);
    }

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

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'agents' => ArrayHelper::map(UserResource::find()->all(), 'id', 'full_names'),
            'polling_stations' => ArrayHelper::map(PollingCenter::find()
                ->select(['concat(county_name," ",constituency_name," ",polling_station_name," ",polling_station_code) as station', 'id'])
                ->asArray()
                ->all(), 'id', 'station')
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
}
