<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ClientNumbers */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="client-numbers-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
          <div class="col-md-6">  <?= $form->field($model, 'client_number_id')->textInput() ?> </div>

  <div class="col-md-6">  <?= $form->field($model, 'client_id')->textInput() ?> </div>

  <div class="col-md-6">  <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?> </div>

  <div class="col-md-6">  <?= $form->field($model, 'number')->textInput(['maxlength' => true]) ?> </div>

  <div class="col-md-6">  <?= $form->field($model, 'created_at')->textInput() ?> </div>

    </div>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
