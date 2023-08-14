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