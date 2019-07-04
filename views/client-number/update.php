<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ClientNumbers */

$this->title = 'Update Number: ' . $model->number;
$this->params['breadcrumbs'][] = ['label' => 'Client Numbers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->number, 'url' => ['view', 'id' => $model->client_number_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="client-numbers-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
