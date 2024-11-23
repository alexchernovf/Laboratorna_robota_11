<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1 class="text-center mb-4"><?= Html::encode($this->title) ?></h1>

    <p class="text-center mb-4">Please fill out the following fields to login:</p>

    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'options' => ['class' => 'card p-4 shadow'],
                'fieldConfig' => [
                    'template' => "<div class='mb-3'>{label}\n{input}\n{error}</div>",
                    'labelOptions' => ['class' => 'form-label'],
                    'inputOptions' => ['class' => 'form-control'],
                    'errorOptions' => ['class' => 'invalid-feedback'],
                ],
            ]); ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder' => 'Enter your username']) ?>

            <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Enter your password']) ?>

            <?= $form->field($model, 'rememberMe')->checkbox([
                'template' => "<div class=\"form-check\">{input} {label}</div>",
                'labelOptions' => ['class' => 'form-check-label'],
                'inputOptions' => ['class' => 'form-check-input'],
            ]) ?>

            <div class="form-group d-flex justify-content-between align-items-center">
                <div>
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>
                <div>
                    <a href="<?= \yii\helpers\Url::to(['site/signup']) ?>" class="btn btn-link">Sign Up</a>
                </div>
            </div>

            <?php ActiveForm::end(); ?>



        </div>
    </div>
</div>
