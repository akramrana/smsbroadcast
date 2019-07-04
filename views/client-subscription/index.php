<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ClientSubscriptionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Client Subscriptions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-subscriptions-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Client Subscriptions', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'client_subscription_id',
            'client_id',
            'amount',
            'sms_charge',
            'total_sms',
            //'created_at',
            //'payment_method',
            //'payment_status',
            //'comments:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
