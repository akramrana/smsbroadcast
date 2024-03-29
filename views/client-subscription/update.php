<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ClientSubscriptions */

$this->title = 'Update Payment: #' . $model->client_subscription_id;
$this->params['breadcrumbs'][] = ['label' => 'Payment', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->client_subscription_id, 'url' => ['view', 'id' => $model->client_subscription_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="client-subscriptions-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
