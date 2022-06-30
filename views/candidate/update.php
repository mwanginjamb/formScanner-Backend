<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Candidate */

$this->title = 'Update Candidate: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Candidates', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="candidate-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'levels' => $levels,
        'constituencies' => $constituencies
    ]) ?>

</div>