<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ClientGroups */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="client-groups-form">

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
                ])
                ?>
            </div>
            <span class="clearfix">&nbsp;</span>
            <?php
        }
        ?>
        <div class="col-md-6">  
            <?= $form->field($model, 'group_name')->textInput(['maxlength' => true]) ?> 
            
            <?= $form->field($model, 'is_active')->checkbox(); ?> 
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
