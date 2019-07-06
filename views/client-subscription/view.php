<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ClientSubscriptions */

$this->title = '#' . $model->client_subscription_id;
$this->params['breadcrumbs'][] = ['label' => 'Client Subscriptions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="client-subscriptions-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= (\Yii::$app->session['_smsbroadcastAuth'] == 1)?Html::a('Update', ['update', 'id' => $model->client_subscription_id], ['class' => 'btn btn-primary']):"" ?>
        <?=
        (\Yii::$app->session['_smsbroadcastAuth'] == 1)?Html::a('Delete', ['delete', 'id' => $model->client_subscription_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]):"";
        ?>
    </p>

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'client_id',
                'value' => $model->client->business_name,
            ],
            'amount',
            'sms_charge',
            'total_sms',
            'created_at',
            [
                'attribute' => 'payment_method',
                'value' => (trim($model->payment_method)=="B")?"Bkash":((trim($model->payment_method)=="C")?"Cash":"Cheque"),
            ],
            [
                'attribute' => 'payment_status',
                'value' => ($model->payment_status==1)?"Paid":"Not Paid",
            ],
            'comments:ntext',
        ],
    ])
    ?>

</div>
