<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ClientNumbers */

$this->title = 'Add Number';
$this->params['breadcrumbs'][] = ['label' => 'Client Numbers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-numbers-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
