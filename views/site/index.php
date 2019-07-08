<?php
/* @var $this yii\web\View */

$this->title = 'Dashhboard';
if (\Yii::$app->session['_smsbroadcastAuth'] == 1) {
    $name = Yii::$app->user->identity->name;
} else if (\Yii::$app->session['_smsbroadcastAuth'] == 2) {
    $name = Yii::$app->user->identity->business_name;
}
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Welcome! <?= $name; ?></h1>
        <?php
        if (\Yii::$app->session['_smsbroadcastAuth'] == 2) {
            ?>
            <p class="text-danger">You have <b><?php echo Yii::$app->user->identity->total_sms; ?> remaining SMS!</b></p>
            <?php
        }
        ?>
    </div>

    <div class="body-content text-center">
        <a href="<?php echo \yii\helpers\BaseUrl::home() ?>client-campaign/create" class="btn btn-lg btn-success">Create new campaign</a>
        <a href="<?php echo \yii\helpers\BaseUrl::home() ?>client-number/import" class="btn btn-lg btn-info">Import phone numbers</a>
        <a href="<?php echo \yii\helpers\BaseUrl::home() ?>client-number/create" class="btn btn-lg btn-info">Add phone number</a>
        <a href="<?php echo \yii\helpers\BaseUrl::home() ?>client-group/create" class="btn btn-lg btn-warning">Add new group</a>
        <?php
        if (\Yii::$app->session['_smsbroadcastAuth'] == 2) {
            ?>
            <a href="<?php echo \yii\helpers\BaseUrl::home() ?>profile/edit" class="btn btn-lg btn-success">Edit profile</a>
            <?php
        }
        ?>
        <?php
        if (\Yii::$app->session['_smsbroadcastAuth'] == 1) {
            ?>
            <a href="<?php echo \yii\helpers\BaseUrl::home() ?>client-subscription/create" class="btn btn-lg btn-danger">Add Payment</a>
            <?php
        }
        ?>
    </div>
</div>
