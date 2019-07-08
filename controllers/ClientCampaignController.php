<?php

namespace app\controllers;

use Yii;
use app\models\ClientCampaigns;
use app\models\ClientCampaignSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;
use yii\filters\AccessControl;
use app\components\UserIdentity;
use app\components\AccessRule;

/**
 * ClientCampaignController implements the CRUD actions for ClientCampaigns model.
 */
class ClientCampaignController extends Controller {

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
                'only' => ['index', 'view', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'create', 'update', 'delete'],
                        'roles' => [
                            UserIdentity::ROLE_ADMIN
                        ]
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'create', 'update', 'delete'],
                        'roles' => [
                            UserIdentity::ROLE_CLIENT
                        ]
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all ClientCampaigns models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new ClientCampaignSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ClientCampaigns model.
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
     * Creates a new ClientCampaigns model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new ClientCampaigns();
        if (\Yii::$app->session['_smsbroadcastAuth'] == 2) {
            $model->client_id = Yii::$app->user->identity->client_id;
        }
        $model->scenario = 'create';
        if ($model->load(Yii::$app->request->post())) {
            $request = Yii::$app->request->bodyParams;
            $model->created_at = date('Y-m-d H:i:s');
            $model->campaign_type = "General";
            $model->character_count = strlen($request['ClientCampaigns']['message']);
            $model->is_publish = 0;
            $model->is_deleted = 0;
            if ($model->save()) {
                if ($model->sent_to_all == 0) {
                    if (!empty($request['ClientCampaignNumbers']['client_number_id'])) {
                        foreach ($request['ClientCampaignNumbers']['client_number_id'] as $val) {
                            $campaignNumner = new \app\models\ClientCampaignNumbers();
                            $campaignNumner->client_campaign_id = $model->client_campaign_id;
                            $campaignNumner->client_number_id = $val;
                            $campaignNumner->save();
                        }
                    }
                }
                if ($model->sent_to_all == 1) {
                    $clientNumbers = \app\models\ClientNumbers::find()
                            ->where(['client_group_id' => $model->client_group_id, 'is_deleted' => 0])
                            ->all();
                    if (!empty($clientNumbers)) {
                        foreach ($clientNumbers as $cnum) {
                            $campaignNumner = new \app\models\ClientCampaignNumbers();
                            $campaignNumner->client_campaign_id = $model->client_campaign_id;
                            $campaignNumner->client_number_id = $cnum->client_number_id;
                            $campaignNumner->save();
                        }
                    }
                }

                Yii::$app->session->setFlash('success', 'Campaign successfully saved');
                return $this->redirect(['index']);
            } else {
                return $this->render('create', [
                            'model' => $model,
                ]);
            }
        }
        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing ClientCampaigns model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        if ($model->is_publish == 1) {
            throw new ForbiddenHttpException(Yii::t('app', 'You are not allowed to perform this action.'));
        }
        if (\Yii::$app->session['_smsbroadcastAuth'] == 2) {
            if ($model->client_id != Yii::$app->user->identity->client_id) {
                throw new ForbiddenHttpException(Yii::t('app', 'You are not allowed to perform this action.'));
            }
        }
        $model->scenario = 'update';
        if ($model->load(Yii::$app->request->post())) {
            $request = Yii::$app->request->bodyParams;
            \app\models\ClientCampaignNumbers::deleteAll('client_campaign_id = ' . $model->client_campaign_id);
            if ($model->sent_to_all == 0) {
                if (!empty($request['ClientCampaignNumbers']['client_number_id'])) {
                    foreach ($request['ClientCampaignNumbers']['client_number_id'] as $val) {
                        $campaignNumner = new \app\models\ClientCampaignNumbers();
                        $campaignNumner->client_campaign_id = $model->client_campaign_id;
                        $campaignNumner->client_number_id = $val;
                        $campaignNumner->save();
                    }
                }
            }
            if ($model->sent_to_all == 1) {
                $clientNumbers = \app\models\ClientNumbers::find()
                        ->where(['client_group_id' => $model->client_group_id, 'is_deleted' => 0])
                        ->all();
                if (!empty($clientNumbers)) {
                    foreach ($clientNumbers as $cnum) {
                        $campaignNumner = new \app\models\ClientCampaignNumbers();
                        $campaignNumner->client_campaign_id = $model->client_campaign_id;
                        $campaignNumner->client_number_id = $cnum->client_number_id;
                        $campaignNumner->save();
                    }
                }
            }
            Yii::$app->session->setFlash('success', 'Campaign successfully updated');
            if ($model->save()) {
                return $this->redirect(['index']);
            } else {
                return $this->render('update', [
                            'model' => $model,
                ]);
            }
        }
        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ClientCampaigns model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $model = $this->findModel($id);
        if ($model->is_publish == 1) {
            throw new ForbiddenHttpException(Yii::t('app', 'You are not allowed to perform this action.'));
        }
        if (\Yii::$app->session['_smsbroadcastAuth'] == 2) {
            if ($model->client_id != Yii::$app->user->identity->client_id) {
                throw new ForbiddenHttpException(Yii::t('app', 'You are not allowed to perform this action.'));
            }
        }
        $model->is_deleted = 1;
        $model->save();
        Yii::$app->session->setFlash('success', 'Campaign successfully deleted');
        return $this->redirect(['index']);
    }

    public function actionGetNumbers($client_id = "", $client_group_id = "") {
        $requestData = Yii::$app->request->queryParams;
        $query = \app\models\ClientNumbers::find()
                ->where(['is_deleted' => 0])
                ->orderBy(['created_at' => SORT_DESC]);
        if (!empty($requestData['search']['value'])) {
            $query->andWhere([
                'AND',
                [
                    'OR',
                    ['LIKE', 'name', $requestData['search']['value']],
                    ['LIKE', 'number', $requestData['search']['value']],
                ]
            ]);
        }
        if (\Yii::$app->session['_smsbroadcastAuth'] == 1) {
            if ($client_id != null) {
                $query->andWhere(['client_id' => $client_id]);
            }
            if ($client_group_id != null) {
                $query->andWhere(['client_group_id' => $client_group_id]);
            }
        } else if (\Yii::$app->session['_smsbroadcastAuth'] == 2) {
            $query->andWhere(['client_id' => Yii::$app->user->identity->client_id]);
            if ($client_group_id != null) {
                $query->andWhere(['client_group_id' => $client_group_id]);
            }
        }
        $data = $query->all();
        $totalData = count($data);
        $totalFiltered = count($totalData);

        $query->limit($requestData['length']);
        $query->offset($requestData['start']);
        $result = $query->all();
        $resultSet = [];
        $i = 0;
        foreach ($result as $key => $model) {
            $nestedData = array();
            $nestedData[] = $model->client_number_id;
            $nestedData[] = $model->number;
            $nestedData[] = $model->name;
            $resultSet[] = $nestedData;
            $i++;
        }
        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $resultSet
        );
        return json_encode($json_data);
    }

    /**
     * Finds the ClientCampaigns model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ClientCampaigns the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = ClientCampaigns::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
