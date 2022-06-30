<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PollingCenter */

$this->title = 'Update Polling Center: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Polling Centers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="polling-center-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
