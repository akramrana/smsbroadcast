<?php
/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use yii\helpers\BaseUrl;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <script type="application/javascript">
            var baseUrl = '<?php echo BaseUrl::home(); ?>';
            var _csrf = '<?php echo Yii::$app->request->getCsrfToken() ?>';
            var _system_date = '<?php echo date('Y-m-d') ?>';
        </script>
    </head>
    <body>
        <?php $this->beginBody() ?>

        <div class="wrap">
            <?php
            NavBar::begin([
                'brandLabel' => Yii::$app->name,
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-default navbar-fixed-top',
                ],
            ]);
            if (\Yii::$app->session['_smsbroadcastAuth'] == 1) {
                $name = Yii::$app->user->identity->name;
            }
            else if (\Yii::$app->session['_smsbroadcastAuth'] == 2) {
                $name = Yii::$app->user->identity->business_name;
            }
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => [
                    [
                        'label' => 'Admin',
                        'url' => ['/admin/index'],
                        'visible' => Yii::$app->auth->checkAccess(\Yii::$app->session['_smsbroadcastAuth'], '/admin/index')
                    ],
                    [
                        'label' => 'Client',
                        'url' => ['/client/index'],
                        'visible' => Yii::$app->auth->checkAccess(\Yii::$app->session['_smsbroadcastAuth'], '/client/index')
                    ],
                    [
                        'label' => 'Group',
                        'url' => ['/client-group/index'],
                        'visible' => Yii::$app->auth->checkAccess(\Yii::$app->session['_smsbroadcastAuth'], '/client-group/index')
                    ],
                    [
                        'label' => 'Campaign',
                        'url' => ['/client-campaign/index'],
                        'visible' => Yii::$app->auth->checkAccess(\Yii::$app->session['_smsbroadcastAuth'], '/client-campaign/index')
                    ],
                    //['label' => 'Group', 'url' => ['/client-group/index'],'visible' => !Yii::$app->user->isGuest],
                    [
                        'label' => 'Number',
                        'url' => ['/client-number/index'],
                        'visible' => Yii::$app->auth->checkAccess(\Yii::$app->session['_smsbroadcastAuth'], '/client-number/index')
                    ],
                    //['label' => 'SMS Template', 'url' => ['/client-sms-template/index'],'visible' => !Yii::$app->user->isGuest],
                    [
                        'label' => 'Payment',
                        'url' => ['/client-subscription/index'],
                        'visible' => Yii::$app->auth->checkAccess(\Yii::$app->session['_smsbroadcastAuth'], '/client-subscription/index')
                    ],
                    [
                        'label' => 'Edit Profile',
                        'url' => ['/profile/edit'],
                        'visible' => Yii::$app->auth->checkAccess(\Yii::$app->session['_smsbroadcastAuth'], '/profile/edit')
                    ],
                    Yii::$app->user->isGuest ? (
                            ['label' => 'Login', 'url' => ['/site/login']]
                            ) : (
                            '<li>'
                            . Html::beginForm(['/site/logout'], 'post')
                            . Html::submitButton(
                                    'Logout (' .$name. ')',
                                    ['class' => 'btn btn-link logout']
                            )
                            . Html::endForm()
                            . '</li>'
                            )
                ],
            ]);
            NavBar::end();
            ?>

            <div class="container">
                <?=
                Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ])
                ?>
                <?= Alert::widget() ?>
                <?= $content ?>
            </div>
        </div>

        <footer class="footer">
            <div class="container">
                <p class="pull-left">&copy; i-info Media LTD <?= date('Y') ?></p>
            </div>
        </footer>

        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
