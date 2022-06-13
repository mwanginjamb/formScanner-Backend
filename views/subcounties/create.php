<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Subcounties */

$this->title = 'Create Subcounties';
$this->params['breadcrumbs'][] = ['label' => 'Subcounties', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subcounties-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
