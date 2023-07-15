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
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to login:</p>

    <div class="row">
        <div class="col-lg-5">

            <?php $form = ActiveForm::begin([
                'action' => ["accesso/login"],
                'method' => "POST"
            ]); ?>

            <?= $form->field($model, 'email')->textInput(); ?>

            <?= $form->field($model, 'password')->passwordInput(); ?>

            <div class="form-group">
                <div>
                    <?= Html::submitButton('Invia', ['class' => 'btn btn-primary']); ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
            <?php
              if(isset($string)){

                var_dump( $string);
              }
            ?>
        </div>
    </div>
</div>
