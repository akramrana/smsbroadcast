<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ClientGroups */

$this->title = 'Update Client Groups: ' . $model->client_group_id;
$this->params['breadcrumbs'][] = ['label' => 'Client Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->client_group_id, 'url' => ['view', 'id' => $model->client_group_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="client-groups-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
