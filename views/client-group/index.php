<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ClientGroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Client Groups';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-groups-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Client Groups', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
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
            'group_name',
            [
                'attribute' => 'is_active',
                'value' => function($model) {
                    return ($model->is_active == 1) ? 'Yes' : 'No';
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
