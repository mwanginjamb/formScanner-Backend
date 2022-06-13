<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\SubcountiesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Subcounties';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subcounties-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Subcounties', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'SubCountyID',
            'SubCountyName',
            'CountyID',
            'Notes:ntext',
            'CreatedDate',
            //'CreatedBy',
            //'Deleted',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, app\models\Subcounties $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'SubCountyID' => $model->SubCountyID]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
