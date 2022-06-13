<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SubcountiesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="subcounties-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'SubCountyID') ?>

    <?= $form->field($model, 'SubCountyName') ?>

    <?= $form->field($model, 'CountyID') ?>

    <?= $form->field($model, 'Notes') ?>

    <?= $form->field($model, 'CreatedDate') ?>

    <?php // echo $form->field($model, 'CreatedBy') ?>

    <?php // echo $form->field($model, 'Deleted') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
