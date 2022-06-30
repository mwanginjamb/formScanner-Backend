<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AgentCenters */

$this->title = 'Assign Polling Station to Agent';
$this->params['breadcrumbs'][] = ['label' => 'Agent Centers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="agent-centers-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'agents' => $agents,
        'polling_stations' => $polling_stations,
        'counties' => $counties,
        'constituencies' => $constituencies,
        'wards' => $wards,
        'centers' => $centers,
        'levels' => $levels
    ]) ?>

</div>