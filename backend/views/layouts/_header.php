<div class="br-header">
    <div class="br-header-left">
        <div class="navicon-left hidden-md-down">
            <a id="btnLeftMenu" href="#"><i class="icon ion-navicon-round"></i></a>
        </div>
        <div class="navicon-left hidden-lg-up">
            <a id="btnLeftMenuMobile" href="#"><i class="icon ion-navicon-round"></i></a>
        </div>
        <div class="input-group hidden-xs-down wd-170 transition">

        </div><!-- input-group -->
    </div><!-- br-header-left -->
    <div class="br-header-right">
        <nav class="nav">
            <?= \backend\component\MenuHelper::getNotification() ?>

            <?= \backend\component\MenuHelper::getAccountSetting() ?>
        </nav>
    </div><!-- br-header-right -->
</div><!-- br-header -->
<?php if (Yii::$app->session->hasFlash('s')) { ?>
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <?= Yii::$app->session->getFlash('s'); ?>
    </div>
<?php } ?>
<?php if (Yii::$app->session->hasFlash('e')) { ?>
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <?= Yii::$app->session->getFlash('e'); ?>
    </div>
<?php } ?>