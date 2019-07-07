<?php

namespace app\controllers;

use Yii;
use app\models\ClientGroups;
use app\models\ClientGroupSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;
use yii\filters\AccessControl;
use app\components\UserIdentity;
use app\components\AccessRule;

/**
 * ClientGroupController implements the CRUD actions for ClientGroups model.
 */
class ClientGroupController extends Controller {

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
     * Lists all ClientGroups models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new ClientGroupSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ClientGroups model.
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
     * Creates a new ClientGroups model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new ClientGroups();
        if (\Yii::$app->session['_smsbroadcastAuth'] == 2) {
            $model->client_id = Yii::$app->user->identity->client_id;
        }
        $model->is_deleted = 0;
        $model->created_at = date('Y-m-d H:i:s');
        $model->updated_at = date('Y-m-d H:i:s');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Group successfully saved');
            return $this->redirect(['index']);
        }
        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing ClientGroups model.
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
        $model->updated_at = date('Y-m-d H:i:s');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Group successfully updated');
            return $this->redirect(['index']);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ClientGroups model.
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
        Yii::$app->session->setFlash('success', 'Group successfully deleted');
        return $this->redirect(['index']);
    }

    /**
     * Finds the ClientGroups model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ClientGroups the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = ClientGroups::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
