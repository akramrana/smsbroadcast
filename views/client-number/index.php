<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ClientNumberSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Client Numbers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-numbers-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Add Number', ['create'], ['class' => 'btn btn-success']) ?>
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
                'filter' => Html::activeDropDownList($searchModel, 'client_id', app\helpers\AppHelper ::getAllClients(), ['class' => 'form-control', 'prompt' => 'Filter']),
            ],
            'number',
            'name',
            ['class' => 'yii\grid\ActionColumn', 'template' => '{update} {delete}'],
        ],
    ]);
    ?>


</div>
