<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AppHelper
 *
 * @author akram
 */

namespace app\helpers;

use Yii;
use yii\helpers\ArrayHelper;

class AppHelper {

    //put your code here
    static function getAllClients() {
        $model = \app\models\Clients::find()
                ->where(['is_deleted' => 0])
                ->all();
        $list = ArrayHelper::map($model, 'client_id', 'business_name');
        return $list;
    }

    static function getClientGroups() {
        $query = \app\models\ClientGroups::find()
                ->select(['client_group_id','LTRIM(RTRIM(group_name)) as group_name'])
                ->where(['is_deleted' => 0]);
        if (\Yii::$app->session['_smsbroadcastAuth'] == 2) {
            $query->andWhere(['client_id' => Yii::$app->user->identity->client_id]);
        }
        $model = $query->all();
        $list = ArrayHelper::map($model, 'client_group_id', 'group_name');
        return $list;
    }
    
    static function getClientGroupsById($client_id) {
        $query = \app\models\ClientGroups::find()
                ->select(['client_group_id','LTRIM(RTRIM(group_name)) as group_name'])
                ->where(['is_deleted' => 0]);
        $query->andWhere(['client_id' => $client_id]);
        $model = $query->all();
        $list = ArrayHelper::map($model, 'client_group_id', 'group_name');
        return $list;
    }

}
