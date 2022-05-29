<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DocumentLine */

$this->title = 'Create Document Line';
$this->params['breadcrumbs'][] = ['label' => 'Document Lines', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="document-line-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
