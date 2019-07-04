<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ClientCampaigns */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="client-campaigns-form">

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
            <?= $form->field($model, 'campaign_name')->textInput(['maxlength' => true]) ?> 

            <?= $form->field($model, 'message')->textarea(['rows' => 6,'maxlength' => 140]) ?> 
        </div>
        <div class="col-md-6">  
            <?= $form->field($model, 'from_number')->textInput(['maxlength' => true]) ?> 
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
