<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Communities */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="card">
	<div class="card-header">
		<h4 class="card-title"><?= $this->title; ?></h4>

	</div>
	<div class="card-content collapse show">
		<div class="card-body">
			<?php $form = ActiveForm::begin([
				'action' => 'import',
				'id' => 'excel-doc-upload',
				'enableClientValidation' => true,
				'encodeErrorSummary' => false,
				'options' => [
					'enctype' => 'multipart/form-data'
				]
			]);

			$form->errorSummary($model);

			?>

			<div class="row">
				<div class="col-md-8">
					<?= $form->field($model, 'excel_doc')->fileInput() ?>
					<?= $form->field($model, 'workplanID')->hiddenInput()->label(false) ?>
				</div>

			</div>


			<div class="form-group">

				<?= Html::submitButton('<i class="fa fa-check"></i> Save', ['class' => 'btn btn-primary']) ?>
			</div>

			<?php ActiveForm::end(); ?>

		</div>
	</div>