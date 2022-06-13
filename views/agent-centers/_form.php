<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AgentCenters */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="agent-centers-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'agent_id')->dropDownList($agents,['prompt' => 'Select Agent ...']) ?>

    <?= $form->field($model, 'center_id')->dropDownList($polling_stations,['prompt' => 'Select Polling Station ...']) ?>

   

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
