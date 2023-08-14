<?php
/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\widgets\Menu;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <?= $this->registerMetaTag(['http-equiv' => 'X-UA-Compatible', 'content' => 'IE=edge']); ?>
        <?= $this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1']); ?>
        <?= $this->registerMetaTag(['name' => 'description', 'content' => 'Internet Business Management']); ?>
        <?= $this->registerMetaTag(['name' => 'author', 'content' => 'Chandrap']); ?>
        <title><?= SITE_NAME ?></title>
        <?php $this->head() ?>
        


    </head>
    <body>
        <?php $this->beginBody() ?>

        <!-- ########## START: LEFT PANEL ########## -->
        <div class="br-logo"><a href="#"><span>[</span><i><?= SITE_NAME ?></i><span>]</span></a></div>
        <div class="br-sideleft overflow-y-auto">
            <label class="sidebar-label pd-x-10 mg-t-20 op-3">Navigation</label>

            <?=
            Menu::widget([
                'options' => ['class' => 'br-sideleft-menu'],
                'items' => \backend\component\MenuHelper::renderMenu(),
                'itemOptions' => ['class' => 'br-menu-item'],
                'encodeLabels' => false,
                'activateItems' => true,
                'activateParents' => true,
                'activeCssClass' => 'active',
            ]);
            ?>
            <?php //= $this->render('_info') ?>
            <br>
        </div><!-- br-sideleft -->
        <!-- ########## END: LEFT PANEL ########## -->

        <!-- ########## START: HEAD PANEL ########## -->
        <?= $this->render('_header') ?>
        <!-- ########## END: HEAD PANEL ########## -->

        <!-- ########## START: MAIN PANEL ########## -->
        <div class="br-mainpanel" id="app">
            <?= $this->render('_breadcrum') ?>
            <div class="br-pagebody">
                <?= $content ?>
            </div><!-- br-pagebody -->
        </div><!-- br-mainpanel -->
        <!-- ########## END: MAIN PANEL ########## -->
        <!-- ##########start Footer ##########-->
        <footer class="br-footer">
            <div class="footer-left"></div>
            <div class="footer-right">
                <div class="mg-b-2">
                    Copyright © 2020. CabelTree. All Rights Reserved.
                </div>
                <div>Passionately created by CabelTree</div>
            </div>
        </footer>>
        <!-- ##########End Footer ##########-->
        <?php $this->endBody() ?>
        
    </body>
</html>
<?php $this->endPage() ?>