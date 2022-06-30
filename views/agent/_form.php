<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PollingCenter */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="polling-center-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'county_code')->textInput() ?>

    <?= $form->field($model, 'county_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'constituency_code')->textInput() ?>

    <?= $form->field($model, 'constituency_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'caw_code')->textInput() ?>

    <?= $form->field($model, 'caw_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'registration_center_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'voters_per_registration_center')->textInput() ?>

    <?= $form->field($model, 'polling_station_code')->textInput() ?>

    <?= $form->field($model, 'polling_station_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'voters_per_polling_station')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
