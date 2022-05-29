<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AgentCenters */

$this->title = 'Create Agent Centers';
$this->params['breadcrumbs'][] = ['label' => 'Agent Centers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="agent-centers-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
