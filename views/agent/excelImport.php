<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Communities */

$this->title = 'Import Agents via Excel Import';
$this->params['breadcrumbs'][] = ['label' => 'Polling Centers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">

	<?= $this->render('_excelform', [
		'model' => $model,

	]) ?>

</section>