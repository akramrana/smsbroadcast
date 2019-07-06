<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ClientCampaignSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Client Campaigns';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-campaigns-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Client Campaigns', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'client_id',
                'value' => function($model) {
                    return $model->client->business_name;
                },
                'visible' => (\Yii::$app->session['_smsbroadcastAuth'] == 1) ? true : false,
                'filter' => Html::activeDropDownList($searchModel, 'client_id', app\helpers\AppHelper ::getAllClients(), ['class' => 'form-control', 'prompt' => 'Filter']),
            ],
            'campaign_name',
            'from_number',
            'message:ntext',
            'character_count',
            //'created_at',
            //'campaign_type',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'update' => function($url, $model) {
                        if ($model->is_publish == 0) {
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                        'title' => 'Update',
                                        'aria-label' => 'Update',
                                        'data-pjax' => '0',
                            ]);
                        }
                    },
                    'delete' => function($url, $model) {
                        if ($model->is_publish == 0) {
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                        'title' => 'Delete',
                                        'aria-label' => 'Delete',
                                        'data-pjax' => '0',
                                        'data-confirm' => 'Are you sure you want to delete this item?',
                                        'data-method' => 'post',
                            ]);
                        }
                    },
                ]
            ],
        ],
    ]);
    ?>


</div>
