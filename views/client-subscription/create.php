<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ClientSubscriptions */

$this->title = 'Create Client Subscriptions';
$this->params['breadcrumbs'][] = ['label' => 'Client Subscriptions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-subscriptions-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
