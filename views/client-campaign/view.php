<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\ClientCampaigns */

$this->title = $model->campaign_name;
$this->params['breadcrumbs'][] = ['label' => 'Client Campaigns', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="client-campaigns-view">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <?php
    if ($model->is_publish == 0) {
        ?>
        <p>
            <?= Html::a('Update', ['update', 'id' => $model->client_campaign_id], ['class' => 'btn btn-primary']) ?>
            <?=
            Html::a('Delete', ['delete', 'id' => $model->client_campaign_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ])
            ?>
        </p>

        <?php
    }
    ?>

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'client_id',
                'value' => $model->client->business_name,
            ],
            'campaign_name',
            'from_number',
            'message:ntext',
            'character_count',
            'created_at',
            'campaign_type',
            [
                'attribute' => 'is_publish',
                'value' => ($model->is_publish == 1) ? 'Yes' : 'No'
            ],
        ],
    ])
    ?>

    <?php
    $dataProvider = new ActiveDataProvider([
        'query' => $model->getClientCampaignNumbers(),
        'pagination' => [
            'pageSize' => 20,
        ],
    ]);
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => '',
        'columns' => [
            'clientNumber.number',
            'clientNumber.name',
        ],
    ]);
    ?>

</div>
