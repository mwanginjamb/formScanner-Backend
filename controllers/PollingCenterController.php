<?php

namespace app\controllers;

use app\models\ImportSheet;
use app\models\PollingCenter;
use app\models\PollingCenterSearch;
use PhpOffice\PhpSpreadsheet\IOFactory;
use yii\filters\ContentNegotiator;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\UploadedFile;


/**
 * PollingCenterController implements the CRUD actions for PollingCenter model.
 */
class PollingCenterController extends Controller
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
                        'constituency'
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
     * Lists all PollingCenter models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PollingCenterSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PollingCenter model.
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
     * Creates a new PollingCenter model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new PollingCenter();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing PollingCenter model.
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
        ]);
    }

    /**
     * Deletes an existing PollingCenter model.
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
     * Finds the PollingCenter model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return PollingCenter the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PollingCenter::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionExcelImport()
    {
        // $id = \Yii::$app->session->get('LatestCount');
        // exit($id);
        $model = new  ImportSheet();
        return $this->render('excelImport', ['model' => $model]);
    }

    public function actionImport()
    {

        $model = new ImportSheet();
        // Set session for current workplan id
        //Yii::$app->session->set('workplanID', Yii::$app->request->post()['ImportWorkplan']['workplanID']);
        if ($model->load(\Yii::$app->request->post())) {
            $excelUpload = UploadedFile::getInstance($model, 'excel_doc');
            $model->excel_doc = $excelUpload;
            if ($uploadedFile = $model->upload()) {
                // Extract data from  uploaded file
                $sheetData = $this->extractData($uploadedFile);

                // save the data
                $this->saveData($sheetData);
            } else {
                $this->redirect(['excel-import']);
            }
        } else {
            $this->redirect(['excel-import']);
        }
    }

    private function extractData($file)
    {
        $spreadsheet = IOFactory::load($file);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        return $sheetData;
    }



    private function saveData($sheetData)
    {

        // Store sheet data in a session
        \Yii::$app->session->set('poll-data',$sheetData);

        if(count(\Yii::$app->session->get('poll-data'))){
            print_r('Done storing data.');

            print '<pre>';
            print_r(\Yii::$app->session->get('poll-data'));
            return true;
        }
        exit('Did not manage to store data.');

        $i = 0;
        foreach ($sheetData as $key => $data) {         

            
            // Read from 2nd row
            while ($key >=2) {      
                $i++;
                if (trim($data['C']) !== '') { // Has to have a constituency
                    $model = new PollingCenter();
                    $model->county_code = trim($data['A']);
                    $model->county_name = trim($data['B']);
                    $model->constituency_code = trim($data['C']);
                    $model->constituency_name =  trim($data['D']);
                    $model->caw_code = trim($data['E']);
                    $model->caw_name = trim($data['F']);
                    $model->registration_center_code = trim($data['G']);
                    $model->registration_center_name = trim($data['H']);
                    $model->voters_per_registration_center = str_replace(',','',trim($data['I']));
                    $model->polling_station_code = trim($data['J']);
                    $model->polling_station_name = trim($data['K']);
                    $model->voters_per_polling_station = str_replace(',','',trim($data['L']));

                    //sleep(1);
                    if (!$model->save()) {
                        foreach ($model->errors as $k => $v) {
                            \Yii::$app->session->setFlash('error', $v[0] . ' Got value: ' . $model->$k );
                        }
                    } 
                }
                continue;
            }
        }



        return $this->redirect('index');
    }

    public function actionSaveData()
    {
        $sheetData = \Yii::$app->session->get('poll-data');
        $DataLoop = new \ArrayIterator($sheetData);
        $i = 0;
        foreach ($DataLoop as $key => $data) {  
            //print_r($data); exit;       
            // Read from 2nd row
            if($key >= 3584) {      
                $i++;
                if (trim($data['C']) !== '') { // Has to have a constituency
                    $model = new PollingCenter();
                    $model->county_code = !empty(trim($data['A']))?trim($data['A']):'';
                    $model->county_name = !empty(trim($data['B']))?trim($data['B']):'';
                    $model->constituency_code = !empty(trim($data['C']))?trim($data['C']):'';
                    $model->constituency_name =  !empty(trim($data['D']))?trim($data['D']):'';
                    $model->caw_code = !empty(trim($data['E']))?trim($data['E']):'';
                    $model->caw_name = !empty(trim($data['F']))?trim($data['F']):'';
                    $model->registration_center_code = !empty(trim($data['G']))?trim($data['G']):'';
                    $model->registration_center_name = !empty(trim($data['H']))?trim($data['H']):'';
                    $model->voters_per_registration_center = !empty(trim($data['I']))?str_replace(',','',trim($data['I'])):'';
                    $model->polling_station_code = !empty(trim($data['J']))?trim($data['J']):'';
                    $model->polling_station_name = !empty(trim($data['K']))?trim($data['K']):'';
                    $model->voters_per_polling_station = !empty(trim($data['L']))?str_replace(',','',trim($data['L'])):'';

                   
                    if ($model->save()) {
                        $success = print_r($model->errors, true);
                        $this->logger($success,'success');
                    } else{
                        $errors = print_r($model->errors, true);
                        $this->logger($errors,'error');
                    }
                   
                }
                
            }
            sleep(1);
        }



        return $this->redirect('index');
    }

    public function actionInspectData()
    {
        if(\Yii::$app->session->has('poll-data')){
            print_r('Available Data.');
            print '<pre>';
            $data = print_r(\Yii::$app->session->get('poll-data'), true);
            print_r($data);
            return $data;
        }else{
            print_r('No Available Data.');
            return true;
        }
    }

    private function logger($message, $type)
    {
        if ($type == 'success') {
            $filename = 'log/success.log';
        } elseif ($type == 'error') {
            $filename = 'log/error.log';
        } 

        $req_dump = print_r($message, TRUE);
        $fp = fopen($filename, 'a');
        fwrite($fp, $req_dump);
        fclose($fp);
    }


    public function actionConstituency()
    {
        $data = PollingCenter::find()->select(['constituency_code','constituency_name','county_code'])->distinct()->all();
        return $data;
    }

}
