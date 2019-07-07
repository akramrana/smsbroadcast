<?php

namespace app\controllers;

use Yii;
use app\models\ClientNumbers;
use app\models\ClientNumberSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use app\components\UserIdentity;
use app\components\AccessRule;

/**
 * ClientNumberController implements the CRUD actions for ClientNumbers model.
 */
class ClientNumberController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'only' => ['index', 'view', 'create', 'update', 'delete', 'import'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'import'],
                        'roles' => [
                            UserIdentity::ROLE_ADMIN
                        ]
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'import'],
                        'roles' => [
                            UserIdentity::ROLE_CLIENT
                        ]
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all ClientNumbers models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new ClientNumberSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ClientNumbers model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        $model = $this->findModel($id);
        if (\Yii::$app->session['_smsbroadcastAuth'] == 2) {
            if ($model->client_id != Yii::$app->user->identity->client_id) {
                throw new ForbiddenHttpException(Yii::t('app', 'You are not allowed to perform this action.'));
            }
        }
        return $this->render('view', [
                    'model' => $model,
        ]);
    }

    /**
     * Creates a new ClientNumbers model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new ClientNumbers();
        if (\Yii::$app->session['_smsbroadcastAuth'] == 2) {
            $model->client_id = Yii::$app->user->identity->client_id;
        }
        $model->created_at = date('Y-m-d H:i:s');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Number successfully added');
            return $this->redirect(['index']);
        }
        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing ClientNumbers model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        if (\Yii::$app->session['_smsbroadcastAuth'] == 2) {
            if ($model->client_id != Yii::$app->user->identity->client_id) {
                throw new ForbiddenHttpException(Yii::t('app', 'You are not allowed to perform this action.'));
            }
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Number successfully updated');
            return $this->redirect(['index']);
        }
        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ClientNumbers model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $model = $this->findModel($id);
        if (\Yii::$app->session['_smsbroadcastAuth'] == 2) {
            if ($model->client_id != Yii::$app->user->identity->client_id) {
                throw new ForbiddenHttpException(Yii::t('app', 'You are not allowed to perform this action.'));
            }
        }
        $model->is_deleted = 1;
        $model->save();
        Yii::$app->session->setFlash('success', 'Number successfully deleted');
        return $this->redirect(['index']);
    }

    public function actionImport() {
        $model = new \app\models\ExcelUpload();
        if (\Yii::$app->session['_smsbroadcastAuth'] == 2) {
            $model->client_id = Yii::$app->user->identity->client_id;
        }
        if ($model->load(Yii::$app->request->post())) {
            $excelFile = UploadedFile::getInstance($model, 'file');
            $directory = \Yii::getAlias('@app/web/uploads') . DIRECTORY_SEPARATOR;
            if ($excelFile) {
                $filetype = mime_content_type($excelFile->tempName);
                $allowed = array('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                if (!in_array(strtolower($filetype), $allowed)) {
                    Yii::$app->session->setFlash('error', 'File type not supported');
                } else {
                    $uid = uniqid(time(), true);
                    $fileName = $uid . '.' . $excelFile->extension;
                    $filePath = $directory . $fileName;
                    if ($excelFile->saveAs($filePath)) {
                        $path = $directory . $fileName;
                        $objPHPExcel = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);
                        $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                        $processedCount = 0;
                        $time_start = microtime(true);
                        for ($i = 2; $i <= count($sheetData); $i++) {
                            $phone = $sheetData[$i]['A'];
                            $name = $sheetData[$i]['B'];

                            $clientNumberModel = ClientNumbers::find()
                                    ->where(['client_id' => $model->client_id, 'number' => $phone, 'is_deleted' => 0])
                                    ->one();
                            if (empty($clientNumberModel)) {
                                $clientNumberModel = new ClientNumbers();
                                $clientNumberModel->client_id = $model->client_id;
                                $clientNumberModel->number = $phone;
                                $clientNumberModel->name = $name;
                                $clientNumberModel->created_at = date('Y-m-d H:i:s');
                                $clientNumberModel->client_group_id = $model->client_group_id;
                            } else {
                                $clientNumberModel->number = $phone;
                                $clientNumberModel->name = $name;
                                $clientNumberModel->client_group_id = $model->client_group_id;
                            }
                            if ($clientNumberModel->save()) {
                                $processedCount++;
                            } else {
                                die(json_encode($clientNumberModel->errors));
                            }
                        }
                        $time_end = microtime(true);
                        $execution_time = ($time_end - $time_start) / 60;
                        if ($processedCount > 0) {
                            Yii::$app->session->setFlash('success', "Excel imported successfully total '$processedCount' row processed.Total Execution Time: " . $execution_time . ' Min(s)');
                        } else {
                            Yii::$app->session->setFlash('warning', "No new number has been imported");
                        }
                    }
                    return $this->redirect(['index']);
                }
            }
        }
        return $this->render('import', [
                    'model' => $model,
        ]);
    }

    public function actionGetGroups($id)
    {
        if (\Yii::$app->session['_smsbroadcastAuth'] == 2) {
            return [];
        }
        $query = \app\models\ClientGroups::find()
                ->select(['client_group_id','LTRIM(RTRIM(group_name)) as group_name'])
                ->where(['is_deleted' => 0]);
        $query->andWhere(['client_id' => $id]);
        $model = $query->all();
        $data = [];
        foreach ($model as $row){
            $d = [
                'id' => $row->client_group_id,
                'name' => $row->group_name,
            ];
            array_push($data,$d);
        }
        return \yii\helpers\Json::encode($data);
    }
    /**
     * Finds the ClientNumbers model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ClientNumbers the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = ClientNumbers::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
