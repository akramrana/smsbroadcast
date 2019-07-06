<?php

namespace app\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\components\UserIdentity;
use app\components\AccessRule;

class ProfileController extends \yii\web\Controller {

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
                'only' => ['edit'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['edit'],
                        'roles' => [
                            UserIdentity::ROLE_CLIENT
                        ]
                    ],
                ],
            ],
        ];
    }

    public function actionEdit() {
        $model = new \app\models\PasswordForm();
        $userModel = \app\models\Clients::findOne(Yii::$app->user->identity->client_id);
        $model->business_address = $userModel->business_address;
        $model->representative_name = $userModel->representative_name;
        $model->business_name = $userModel->business_name;
        if ($model->load(\Yii::$app->request->post())) {
            $request = Yii::$app->request->bodyParams;
            if ($model->validate()) {
                if (isset($model->repeatNewPass) && $model->repeatNewPass != "") {
                    $userModel->password = Yii::$app->security->generatePasswordHash($model->repeatNewPass);
                }
                $userModel->business_address = $model->business_address;
                $userModel->representative_name = $model->representative_name;
                $userModel->business_name = $model->business_name;
                if ($userModel->save()) {
                    Yii::$app->getSession()->setFlash('success', 'Profile changes saved.');
                    return $this->redirect(['edit']);
                } else {
                    die(json_encode($userModel->errors));
                }
            } else {
                return $this->render('edit', [
                            'model' => $model
                ]);
            }
        }
        return $this->render('edit', [
                    'model' => $model
        ]);
    }

}
