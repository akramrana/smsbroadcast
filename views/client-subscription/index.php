<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ClientSubscriptionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Payment';
$this->params['breadcrumbs'][] = $this->title;
$actionBtn = '';
if (\Yii::$app->session['_smsbroadcastAuth'] == 1) {
    $actionBtn = '{view} {update} {delete}';
} else if (\Yii::$app->session['_smsbroadcastAuth'] == 2) {
    $actionBtn = '{view}';
}
?>
<div class="client-subscriptions-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= (\Yii::$app->session['_smsbroadcastAuth'] == 1) ? Html::a('Add Payment', ['create'], ['class' => 'btn btn-success']) : "" ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

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
            'amount',
            'sms_charge',
            'total_sms',
            //'created_at',
            [
                'attribute' => 'payment_method',
                'value' => function($model) {
                    return (trim($model->payment_method) == "B") ? "Bkash" : ((trim($model->payment_method) == "C") ? "Cash" : "Cheque");
                },
                'filter' => Html::activeDropDownList($searchModel, 'payment_method', ['B' => 'Bkash', 'C' => 'Cash', 'CH' => 'Cheque'], ['class' => 'form-control', 'prompt' => 'Filter']),
            ],
            [
                'attribute' => 'payment_status',
                'value' => function($model) {
                    return ($model->payment_status == 1) ? "Paid" : "Not Paid";
                },
                'filter' => Html::activeDropDownList($searchModel, 'payment_status', ['0' => 'Unpaid', '1' => 'Paid'], ['class' => 'form-control', 'prompt' => 'Filter']),
            ],
            //'comments:ntext',
            ['class' => 'yii\grid\ActionColumn', 'template' => $actionBtn],
        ],
    ]);
    ?>


</div>
