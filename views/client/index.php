<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ClientSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Clients';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clients-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Clients', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'business_name',
            'representative_name',
            'business_address:ntext',
            'email:email',
            //'password',
            'phone',
            'total_sms',
            //'created_at',
            //'updated_at',
            [
                'attribute' => 'is_active',
                'value' => function($model) {
                    return ($model->is_active == 1) ? 'Yes' : 'No';
                }
            ],
            //'is_deleted',
            //'has_own_gateway',
            //'gateway_username',
            //'gateway_password',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
