<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PollingCenter */

$this->title = 'Create Polling Center';
$this->params['breadcrumbs'][] = ['label' => 'Polling Centers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="polling-center-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
