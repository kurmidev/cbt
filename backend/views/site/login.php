<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = "Login";
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="login-wrapper wd-250 wd-xl-350 mg-y-30">
    <?php $form = ActiveForm::begin(['id' => 'login-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>
    <h4 class="tx-inverse tx-center">Sign In</h4>
    <p class="tx-center mg-b-60">Welcome back! Please sign in.</p>
    <div class="form-group">
        <?=
                $form->field($model, 'username', ['options' => ['class' => 'row']])->textInput()
                ->input('text', ['class' => 'form-control uname', "placeholder" => "Enter your username"]);
        ?>
    </div><!-- form-group -->
    <div class="form-group">        
        <?=
                $form->field($model, 'password', ['options' => ['class' => 'row']])->passwordInput()
                ->input('password', ['class' => 'form-control pword', "placeholder" => "Enter your password"]);
        ?>
    </div><!-- form-group -->
    <?= Html::submitButton('Sign In', ['class' => 'btn btn-info btn-block', 'name' => 'login-button']) ?>
    <?php ActiveForm::end(); ?>
</div><!-- login-wrapper -->