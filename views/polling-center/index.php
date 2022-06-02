<?php

use app\models\PollingCenter;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PollingCenterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Polling Centers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="polling-center-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Polling Center', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Import Polling Centers', ['excel-import'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'county_code',
            'county_name',
            'constituency_code',
            'constituency_name',
            //'caw_code',
            //'caw_name',
            //'registration_center_name',
            //'voters_per_registration_center',
            //'polling_station_code',
            //'polling_station_name',
            //'voters_per_polling_station',
            //'created_at',
            //'updated_at',
            //'created_by',
            //'updated_by',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, PollingCenter $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
