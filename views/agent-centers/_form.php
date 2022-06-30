<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AgentCenters */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="agent-centers-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model) ?>
    <div class="row">
        <div class="col-md-6">

            <?= $form->field($model, 'county')->dropDownList(
                $counties,
                [
                    'prompt' => 'Select  ...',
                    'onchange' => '$.post( "' . Yii::$app->urlManager->createUrl('agent-centers/constituency-dd?county=') . '" + $(this).val(), function( data ) {
                    $( "select#agentcenters-constituency" ).html( data );
                });
                '
                ]
            ) ?>
            <?= $form->field($model, 'ward')->dropDownList($wards, [
                'prompt' => 'Select  ...',
                'onchange' => '$.post( "' . Yii::$app->urlManager->createUrl('agent-centers/station-dd?ward=') . '" + $(this).val(), function( data ) {
                    $( "select#agentcenters-center_id" ).html( data );
                });
                '
            ]) ?>
            <?= $form->field($model, 'agent_id')->dropDownList($agents, ['prompt' => 'Select Agent ...']) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'constituency')->dropDownList($constituencies, [
                'prompt' => 'Select  ...',
                'onchange' => '$.post( "' . Yii::$app->urlManager->createUrl('agent-centers/ward-dd?constituency=') . '" + $(this).val(), function( data ) {
                    $( "select#agentcenters-ward" ).html( data );
                });
                '
            ]) ?>
            <?php $form->field($model, 'center')->dropDownList($centers, [
                'prompt' => 'Select  ...',
                'onchange' => '$.post( "' . Yii::$app->urlManager->createUrl('agent-centers/station-dd?center=') . '" + $(this).val(), function( data ) {
                    $( "select#agentcenters-center_id" ).html( data );
                });
                '
            ]) ?>
            <?= $form->field($model, 'center_id')->dropDownList($polling_stations, ['prompt' => 'Select Polling Station ...']) ?>
            <?= $form->field($model, 'result_level_id')->dropDownList($levels, ['prompt' => 'Select  ...']) ?>

        </div>
    </div>





    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$script = <<<JS
$("#agentcenters-center_id").select2();
JS;
//$this->registerJs($script);
