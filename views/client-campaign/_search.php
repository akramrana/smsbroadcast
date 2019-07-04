<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ClientCampaignSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="client-campaigns-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'client_campaign_id') ?>

    <?= $form->field($model, 'client_id') ?>

    <?= $form->field($model, 'campaign_name') ?>

    <?= $form->field($model, 'from_number') ?>

    <?= $form->field($model, 'message') ?>

    <?php // echo $form->field($model, 'character_count') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'campaign_type') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
