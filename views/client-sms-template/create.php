<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ClientSmsTemplates */

$this->title = 'Create Client Sms Templates';
$this->params['breadcrumbs'][] = ['label' => 'Client Sms Templates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-sms-templates-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
