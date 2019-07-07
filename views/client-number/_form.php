<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ClientNumbers */
/* @var $form yii\widgets\ActiveForm */
$groups = [];
if (!$model->isNewRecord) {
    $model->number = trim($model->number);
    $model->name = trim($model->name);
    if (\Yii::$app->session['_smsbroadcastAuth'] == 2) {
        $groups = \app\helpers\AppHelper::getClientGroupsById(Yii::$app->user->identity->client_id);
    } else if (\Yii::$app->session['_smsbroadcastAuth'] == 1) {
        $groups = app\helpers\AppHelper::getClientGroupsById($model->client_id);
    }
} else {
    if (\Yii::$app->session['_smsbroadcastAuth'] == 2) {
        $groups = \app\helpers\AppHelper::getClientGroupsById(Yii::$app->user->identity->client_id);
    }
}
?>
<div class="client-numbers-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <?php
        if (\Yii::$app->session['_smsbroadcastAuth'] == 1) {
            ?>
            <div class="col-md-6">  
                <?=
                $form->field($model, 'client_id')->dropDownList(\app\helpers\AppHelper::getAllClients(), [
                    'prompt' => 'Please Select',
                    'class' => 'form-control',
                    'onchange' => 'app.getClientGroupList(this.value,"#clientnumbers-client_group_id")'
                ])
                ?> 
            </div>
            <span class="clearfix">&nbsp;</span>
            <?php
        }
        ?>
        <div class="col-md-6">  
            <?=
            $form->field($model, 'client_group_id')->dropDownList($groups, [
                'prompt' => 'Please Select',
                'class' => 'form-control'
            ])
            ?> 
        </div>
        <span class="clearfix">&nbsp;</span>
        <div class="col-md-6">  
            <?= $form->field($model, 'number')->textInput(['maxlength' => true]) ?> 
        </div>
        <div class="col-md-6">  
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?> 
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
