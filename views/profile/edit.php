<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Edit Profile';

$model->business_address = trim($model->business_address);
$model->representative_name = trim($model->representative_name);
$model->business_name = trim($model->business_name);
?>
<div class="edit-profile">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    $form = ActiveForm::begin([
                'id' => 'profile-edit',
                'options' => ['class' => 'form-horizontal'],
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-lg-3\">
                            {input}</div>\n<div class=\"col-lg-5\">
                            {error}</div>",
                    'labelOptions' => ['class' => 'col-lg-2 control-label'],
                ],
    ]);
    ?>

    <?php
    echo $form->field($model, 'business_name', [
        'inputOptions' => [
            'placeholder' => 'Business Name',
            'class' => 'form-control'
        ]
    ])->textInput()->label('Business Name');

    echo
    $form->field($model, 'representative_name', [
        'inputOptions' => [
            'placeholder' => 'Representative Name',
            'class' => 'form-control'
        ]
    ])->textInput()->label('Representative Name');

    echo
    $form->field($model, 'business_address', [
        'inputOptions' => [
            'class' => 'form-control'
        ]
    ])->textArea()->label('Business Address');

    echo
    $form->field($model, 'oldPass', [
        'inputOptions' => [
            'placeholder' => 'Old password',
            'class' => 'form-control',
            'onchange' => 'app.validation.checkPassword()'
        ]
    ])->passwordInput()->label('Old password');
    ?>

    <?php
    echo
    $form->field($model, 'newPass', [
        'inputOptions' => [
            'placeholder' => 'New password',
            'class' => 'form-control',
            'onchange' => 'app.validation.checkPassword()'
        ]
    ])->passwordInput()->label('New password');
    ?>

    <?php
    echo
    $form->field($model, 'repeatNewPass', [
        'inputOptions' => [
            'placeholder' => 'Confirm password',
            'class' => 'form-control',
            'onchange' => 'app.validation.checkPassword()'
        ]
    ])->passwordInput()->label('Confirm password')
    ?>

    <div class="form-group">
        <div class="col-lg-offset-2 col-lg-11">
            <?php
            echo
            Html::submitButton('Save', [
                'class' => 'btn btn-primary'
            ])
            ?>
        </div>
    </div>


<?php ActiveForm::end(); ?>

</div>