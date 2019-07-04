<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ClientNumbers */
/* @var $form yii\widgets\ActiveForm */
if(!$model->isNewRecord){
    $model->number =  trim($model->number);
    $model->name =  trim($model->name);
}
?>
<div class="client-numbers-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-6">  
            <?= $form->field($model, 'client_id')->dropDownList(\app\helpers\AppHelper::getAllClients(),[
                'prompt' => 'Please Select',
                'class' => 'form-control'
            ]) ?> 
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
