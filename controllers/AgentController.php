<?php

namespace app\controllers;

use app\models\ImportSheet;
use app\models\PollingCenter;
use app\models\PollingCenterSearch;
use app\models\SignupForm;
use app\models\UserOtp;
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
class AgentController extends Controller
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


    public function actionList()
    {
        $agents = UserOtp::find()->with('assignment')->all();


        foreach ($agents as $a) {

            $result['data'][] = [
                'username' => $a->username,
                'phone_number' => $a->phone_number,
                'full_names' => $a->full_names
            ];
        }

        return $result;
    }

    public function getPollingCenter($id)
    {
        return PollingCenter::findOne(['id' => $id]);
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


        //\Yii::$app->utilities->printrr($sheetData);

        $i = 0;
        $curl = curl_init();
        foreach ($sheetData as $key => $data) {

            $username = trim($data['B']);
            $phone_number = trim($data['E']);
            $password = trim($data['F']);
            $password_confirm = trim($data['F']);
            $full_names = trim($data['D']);

            // Read from 4th row
            if ($key >= 4) {

                $model = new SignupForm();
                $model->username = $username;
                $model->phone_number = $phone_number;
                $model->password = $password;
                $model->password_confirm = $password_confirm;
                $model->full_names = $full_names;

                if (!$model->signup()) {
                    //\Yii::$app->session->setFlash('error', implode(' - ', $model->getFirstErrors()));
                    foreach ($model->errors as $k => $v) {
                        \Yii::$app->session->setFlash('error', $v[0] . ' Got value: ' . $model->$k . '  On row :' . $key);
                    }
                }
            }
        }



        return $this->redirect('index');
    }



    public function actionInspectData()
    {
        if (\Yii::$app->session->has('poll-data')) {
            print_r('Available Data.');
            print '<pre>';
            $data = print_r(\Yii::$app->session->get('poll-data'), true);
            print_r($data);
            return $data;
        } else {
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
        $data = PollingCenter::find()->select(['constituency_code', 'constituency_name', 'county_code'])->distinct()->all();
        return $data;
    }
}
