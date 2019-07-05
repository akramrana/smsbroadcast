<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ClientNumberSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Import Numbers';
$this->params['breadcrumbs'][] = ['label' => 'Client Numbers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-numbers-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">  
            <?=
            $form->field($model, 'client_id')->dropDownList(\app\helpers\AppHelper::getAllClients(), [
                'prompt' => 'Please Select',
                'class' => 'form-control'
            ])
            ?> 
        </div>
        <span class="clearfix">&nbsp;</span>
        <div class="col-md-6">  
            <?= $form->field($model, 'file')->fileInput() ?> 
            <a class="text-danger" download href="<?= \yii\helpers\BaseUrl::home() ?>/data/Sample.xlsx">Sample.xlsx</a>
        </div>
    </div>

    <div class="form-group">

        <span class="clearfix">&nbsp;</span>
        <?= Html::submitButton('Import', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
