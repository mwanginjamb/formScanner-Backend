<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Subcounties */

$this->title = 'Update Subcounties: ' . $model->SubCountyID;
$this->params['breadcrumbs'][] = ['label' => 'Subcounties', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->SubCountyID, 'url' => ['view', 'SubCountyID' => $model->SubCountyID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="subcounties-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
