<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ClientSubscriptions */

$this->title = 'Add Client Payment';
$this->params['breadcrumbs'][] = ['label' => 'Client Payment', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-subscriptions-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
