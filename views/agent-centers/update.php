<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AgentCenters */

$this->title = 'Update Agent Polling Station assignment: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Agent Centers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="agent-centers-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'agents' => $agents,
        'polling_stations' => $polling_stations
    ]) ?>

</div>
