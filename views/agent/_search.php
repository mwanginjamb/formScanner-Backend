<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PollingCenterSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="polling-center-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'county_code') ?>

    <?= $form->field($model, 'county_name') ?>

    <?= $form->field($model, 'constituency_code') ?>

    <?= $form->field($model, 'constituency_name') ?>

    <?php // echo $form->field($model, 'caw_code') ?>

    <?php // echo $form->field($model, 'caw_name') ?>

    <?php // echo $form->field($model, 'registration_center_name') ?>

    <?php // echo $form->field($model, 'voters_per_registration_center') ?>

    <?php // echo $form->field($model, 'polling_station_code') ?>

    <?php // echo $form->field($model, 'polling_station_name') ?>

    <?php // echo $form->field($model, 'voters_per_polling_station') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
