<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ClientGroups */

$this->title = 'Create Group';
$this->params['breadcrumbs'][] = ['label' => 'Client Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-groups-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
