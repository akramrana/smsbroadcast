<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Clients */
/* @var $form yii\widgets\ActiveForm */
if(!$model->isNewRecord){
    $model->business_name =  trim($model->business_name);
    $model->email =  trim($model->email);
    $model->business_address =  trim($model->business_address);
    $model->representative_name =  trim($model->representative_name);
    $model->phone =  trim($model->phone);
}
?>

<div class="clients-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-6">  
            <?= $form->field($model, 'business_name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'password_hash')->passwordInput(['maxlength' => true]) ?> 

            <?= $form->field($model, 'business_address')->textarea(['rows' => 6]) ?>

            <?= $form->field($model, 'is_active')->checkbox() ?>
        </div>

        <div class="col-md-6">  
            <?= $form->field($model, 'representative_name')->textInput(['maxlength' => true]) ?> 

            <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

            <?php
            if ($model->isNewRecord) {
                echo $form->field($model, 'confirm_password')->passwordInput(['maxlength' => true]);
            }
            ?> 
        </div>

    </div>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
