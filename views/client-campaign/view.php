<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\ClientCampaigns */

$this->title = $model->campaign_name;
$this->params['breadcrumbs'][] = ['label' => 'Campaigns', 'url' => ['index']];
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

            <?=
            Html::a('Publish', 'javascript:;', [
                'class' => 'btn btn-success pull-right',
                'onclick' => 'app.publishCampaign(' . $model->client_campaign_id . ')',
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
            [
                'attribute' => 'client_group_id',
                'value' => !empty($model->clientGroups) ? $model->clientGroups->group_name : "",
            ],
            'campaign_name',
            'from_number',
            'message:ntext',
            'character_count',
            'created_at',
            'campaign_type',
            [
                'attribute' => 'sent_to_all',
                'value' => ($model->sent_to_all == 1) ? 'Yes' : 'No'
            ],
            [
                'attribute' => 'is_publish',
                'value' => ($model->is_publish == 1) ? 'Yes' : 'No'
            ],
        ],
    ])
    ?>

    <?php
    $query = app\models\ClientCampaignNumbers::find()
            ->join('LEFT JOIN', 'client_numbers', 'client_campaign_numbers.client_number_id = client_numbers.client_number_id')
            ->where(['client_campaign_id' => $model->client_campaign_id, 'is_deleted' => 0]);
    $dataProvider = new ActiveDataProvider([
        'query' => $query,
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
    if ($model->is_publish == 1) {
        ?>
        <b>Campaign Server Response</b>
        <?php
        $dataProvider1 = new ActiveDataProvider([
            'query' => $model->getClientCampaignResponses(),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        echo GridView::widget([
            'dataProvider' => $dataProvider1,
            'summary' => '',
            'columns' => [
                'message_id',
                'status_text',
                'error_text',
                'sms_count',
                [
                    'attribute' => 'current_credit',
                    'visible' => (\Yii::$app->session['_smsbroadcastAuth'] == 1) ? true : false,
                ],
                'created_at'
            ],
        ]);
    }
    ?>

</div>

<div class="preloader">
    <div class="preloader-content">
        <h3>Sending....</h3>
    </div>
</div>