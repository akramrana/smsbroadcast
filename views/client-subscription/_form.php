<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ClientSubscriptions */
/* @var $form yii\widgets\ActiveForm */
if(!$model->isNewRecord){
    $model->total_sms =  trim($model->total_sms);
    $model->sms_charge =  trim($model->sms_charge);
    $model->amount =  trim($model->amount);
    $model->comments =  trim($model->comments);
    $model->payment_status =  trim($model->payment_status);
    $model->payment_method =  trim($model->payment_method);
}
?>

<div class="client-subscriptions-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-6">  
            <?= $form->field($model, 'client_id')->dropDownList(\app\helpers\AppHelper::getAllClients(),[
                'prompt' => 'Please Select',
                'class' => 'form-control'
            ]); ?> 
        </div>
        <span class="clearfix">&nbsp;</span>
        <div class="col-md-6">  
            <?= $form->field($model, 'total_sms')->textInput([
                'readonly' => (!$model->isNewRecord)?true:false
            ]) ?>
            
            <?= $form->field($model, 'sms_charge')->textInput() ?> 
            
            <?= $form->field($model, 'payment_status')->dropDownList(['0' => 'Unpaid','1' => 'Paid'],[
                'prompt' => 'Please Select',
                'class' => 'form-control'
            ]) ?>
            
            <?= $form->field($model, 'comments')->textarea(['rows' => 6]) ?>
        </div>

        <div class="col-md-6">  
            <?= $form->field($model, 'amount')->textInput() ?> 
            
            <?= $form->field($model, 'payment_method')->dropDownList(['B' => 'Bkash','C' => 'Cash','CH' => 'Cheque'],[
                'prompt' => 'Please Select',
                'class' => 'form-control'
            ]) ?>
            
            
        </div>

        <div class="col-md-6">   </div>

        <div class="col-md-6">   </div>

    </div>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
