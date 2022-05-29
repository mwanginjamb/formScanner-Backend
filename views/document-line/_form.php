<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DocumentLine */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="document-line-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'candidate_id')->textInput() ?>

    <?= $form->field($model, 'votes')->textInput() ?>

    <?= $form->field($model, 'polling_station_id')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
