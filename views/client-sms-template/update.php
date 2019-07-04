<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ClientSmsTemplates */

$this->title = 'Update Client Sms Templates: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Client Sms Templates', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->client_sms_template_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="client-sms-templates-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
