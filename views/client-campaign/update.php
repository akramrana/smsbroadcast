<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ClientCampaigns */

$this->title = 'Update Client Campaigns: ' . $model->client_campaign_id;
$this->params['breadcrumbs'][] = ['label' => 'Client Campaigns', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->client_campaign_id, 'url' => ['view', 'id' => $model->client_campaign_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="client-campaigns-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>