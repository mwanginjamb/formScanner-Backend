<?php

namespace app\controllers;

use app\models\Subcounties;
use app\models\SubcountiesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SubcountiesController implements the CRUD actions for Subcounties model.
 */
class SubcountiesController extends Controller
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
     * Lists all Subcounties models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SubcountiesSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Subcounties model.
     * @param int $SubCountyID Sub County ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($SubCountyID)
    {
        return $this->render('view', [
            'model' => $this->findModel($SubCountyID),
        ]);
    }

    /**
     * Creates a new Subcounties model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Subcounties();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'SubCountyID' => $model->SubCountyID]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Subcounties model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $SubCountyID Sub County ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($SubCountyID)
    {
        $model = $this->findModel($SubCountyID);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'SubCountyID' => $model->SubCountyID]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Subcounties model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $SubCountyID Sub County ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($SubCountyID)
    {
        $this->findModel($SubCountyID)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Subcounties model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $SubCountyID Sub County ID
     * @return Subcounties the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($SubCountyID)
    {
        if (($model = Subcounties::findOne(['SubCountyID' => $SubCountyID])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
