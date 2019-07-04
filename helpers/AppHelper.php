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
    static function getAllClients()
    {
        $model = \app\models\Clients::find()
                ->where(['is_deleted' => 0])
                ->all();
        $list = ArrayHelper::map($model, 'client_id', 'business_name');
        return $list;
    }
}
