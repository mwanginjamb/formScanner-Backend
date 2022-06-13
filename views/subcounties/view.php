<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Subcounties */

$this->title = $model->SubCountyID;
$this->params['breadcrumbs'][] = ['label' => 'Subcounties', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="subcounties-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'SubCountyID' => $model->SubCountyID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'SubCountyID' => $model->SubCountyID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'SubCountyID',
            'SubCountyName',
            'CountyID',
            'Notes:ntext',
            'CreatedDate',
            'CreatedBy',
            'Deleted',
        ],
    ]) ?>

</div>
