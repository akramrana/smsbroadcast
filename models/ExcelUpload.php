<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;

use yii\base\Model;
/**
 * Description of ExcelUpload
 *
 * @author akram
 */
class ExcelUpload extends Model{
    
    public $file;
    public $client_id;
    public $client_group_id;

    public function rules()
    {
        return [
            [['client_id','file'], 'required'],
            [['client_id','file','client_group_id'], 'safe'],
            [['file'], 'required', 'message' => \Yii::t('app', 'Upload at least one file.')],
            [['file'], 'file','extensions' => 'xlsx,xls'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'file' => \Yii::t('app', 'Excel File'),
            'client_id' => \Yii::t('app', 'Client'),
            'client_group_id' => \Yii::t('app', 'Group'),
        ];
    }
}
