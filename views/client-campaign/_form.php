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

  <div class="col-md-6">  <?= $form->field($model, 'client_id')->textInput() ?> </div>

  <div class="col-md-6">  <?= $form->field($model, 'campaign_name')->textInput(['maxlength' => true]) ?> </div>

  <div class="col-md-6">  <?= $form->field($model, 'from_number')->textInput(['maxlength' => true]) ?> </div>

  <div class="col-md-6">  <?= $form->field($model, 'message')->textarea(['rows' => 6]) ?> </div>

  <div class="col-md-6">  <?= $form->field($model, 'character_count')->textInput() ?> </div>

  <div class="col-md-6">  <?= $form->field($model, 'created_at')->textInput() ?> </div>

  <div class="col-md-6">  <?= $form->field($model, 'campaign_type')->textInput(['maxlength' => true]) ?> </div>

    </div>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
