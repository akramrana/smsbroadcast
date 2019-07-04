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
          <div class="col-md-6">  <?= $form->field($model, 'client_id')->textInput() ?> </div>

  <div class="col-md-6">  <?= $form->field($model, 'group_name')->textInput(['maxlength' => true]) ?> </div>

  <div class="col-md-6">  <?= $form->field($model, 'is_active')->textInput() ?> </div>

  <div class="col-md-6">  <?= $form->field($model, 'is_deleted')->textInput() ?> </div>

  <div class="col-md-6">  <?= $form->field($model, 'created_at')->textInput() ?> </div>

  <div class="col-md-6">  <?= $form->field($model, 'updated_at')->textInput() ?> </div>

    </div>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
