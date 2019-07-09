<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ClientNumberSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Numbers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-numbers-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Add Number', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Import Number', ['import'], ['class' => 'btn btn-info pull-right']) ?>
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
                'visible' => (\Yii::$app->session['_smsbroadcastAuth'] == 1) ? true : false,
                'filter' => Html::activeDropDownList($searchModel, 'client_id', app\helpers\AppHelper ::getAllClients(), ['class' => 'form-control', 'prompt' => 'Filter']),
            ],
            [
                'attribute' => 'client_group_id',
                'value' => function($model) {
                    return !empty($model->clientGroups)?$model->clientGroups->group_name:"";
                },
                'filter' => Html::activeDropDownList($searchModel, 'client_group_id', app\helpers\AppHelper ::getClientGroups(), ['class' => 'form-control', 'prompt' => 'Filter']),
            ],
            'number',
            'name',
            ['class' => 'yii\grid\ActionColumn', 'template' => '{update} {delete}'],
        ],
    ]);
    ?>


</div>
