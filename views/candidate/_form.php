<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Candidate */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="candidate-form">


    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="presidential-tab" data-toggle="tab" href="#presidential" role="tab" aria-controls="home" aria-selected="true">Presidential</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="mp-tab" data-toggle="tab" href="#mp" role="tab" aria-controls="profile" aria-selected="false">MP</a>
        </li>

    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="presidential" role="tabpanel" aria-labelledby="presidential-tab">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->errorSummary($model) ?>
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'countable')->checkbox([$model->countable]) ?>
            <?= $form->field($model, 'candidate_code')->textInput([]) ?>

            <?php $form->field($model, 'result_level_id')->dropDownList($levels, ['prompt' => 'select ...']) ?>
            <?php $form->field($model, 'constituency_code')->dropDownList($constituencies, ['prompt' => 'select ...']) ?>

            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
        <div class="tab-pane fade" id="mp" role="tabpanel" aria-labelledby="mp-tab">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->errorSummary($model) ?>
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'countable')->checkbox([$model->countable]) ?>
            <?= $form->field($model, 'candidate_code')->textInput([]) ?>

            <?= $form->field($model, 'result_level_id')->dropDownList($levels, ['prompt' => 'select ...']) ?>
            <?= $form->field($model, 'constituency_code')->dropDownList($constituencies, ['prompt' => 'select Constituency Code']) ?>

            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>

    </div>



</div>

<?php
$script = <<<JS
$("#candidate-constituency_code").select2();
JS;
$this->registerJs($script);
