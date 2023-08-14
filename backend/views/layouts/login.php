<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use backend\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <?= Html::csrfMetaTags() ?>
        <?= $this->registerMetaTag(['http-equiv' => 'X-UA-Compatible', 'content' => 'IE=edge']); ?>
        <?= $this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1']); ?>
        <?= $this->registerMetaTag(['name' => 'description', 'content' => 'CabelTree-IMS']); ?>
        <?= $this->registerMetaTag(['name' => 'author', 'content' => 'Kurmi']); ?>
        <title><?= SITE_NAME ?></title>
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>

        <div class="row no-gutters flex-row-reverse ht-100v">
            <div class="col-md-6 bg-gray-200 d-flex align-items-center justify-content-center">
                <?= $content ?>
            </div><!-- col -->
            <div class="col-md-6 bg-br-primary d-flex align-items-center justify-content-center">
                <div class="wd-250 wd-xl-450 mg-y-30">
                    <div class="signin-logo tx-28 tx-bold tx-white"><span class="tx-normal">[</span> JPR <span class="tx-info">IMS</span> <span class="tx-normal">]</span></div>
                    <div class="tx-white mg-b-60">The IMS For Perfectionist</div>

                    <h5 class="tx-white">Why IMS?</h5>
                    <p class="tx-white">Bandwidth Management</p>
                    <p class="tx-white">Billing & Payment</p>
                    <p class="tx-white">Reporting</p>
                    <p class="tx-white">Customer Query Management</p>
                    <p class="tx-white">Online Payment</p>
                    <p class="tx-white">Web portal's for customers</p>
                    <p class="tx-white mg-b-60">and much more...</p>
                    <a href="#" class="btn btn-outline-light bd bd-white bd-2 tx-white pd-x-25 tx-uppercase tx-12 tx-spacing-2 tx-medium">CabelTree</a>
                </div><!-- wd-500 -->
            </div>
        </div><!-- row -->

        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
