<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ClientSubscriptions */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="client-subscriptions-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
          <div class="col-md-6">  <?= $form->field($model, 'client_id')->textInput() ?> </div>

  <div class="col-md-6">  <?= $form->field($model, 'amount')->textInput() ?> </div>

  <div class="col-md-6">  <?= $form->field($model, 'sms_charge')->textInput() ?> </div>

  <div class="col-md-6">  <?= $form->field($model, 'total_sms')->textInput() ?> </div>

  <div class="col-md-6">  <?= $form->field($model, 'created_at')->textInput() ?> </div>

  <div class="col-md-6">  <?= $form->field($model, 'payment_method')->textInput(['maxlength' => true]) ?> </div>

  <div class="col-md-6">  <?= $form->field($model, 'payment_status')->textInput() ?> </div>

  <div class="col-md-6">  <?= $form->field($model, 'comments')->textarea(['rows' => 6]) ?> </div>

    </div>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
