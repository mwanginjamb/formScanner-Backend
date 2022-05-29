<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Documents */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Documents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
//exit($mime);
?>
<div class="documents-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>


    <div class="container">

        <div class="row">
            <div class="col-md-12">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'id',
                        'description',
                        'results:ntext',
                        'polling_station',
                        'local_file_path',
                        'sharepoint_path',
                        //'created_by',
                        //'updated_by',
                        'created_at:datetime',
                        //'updated_at',
                    ],
                ]) ?>
            </div>
        </div>


        <div class="row">

            <div class="col-md-12">

                <?php if($content){ ?>
                    <img class="image mx-auto d-block img-fluid" id="image-view" src="data:<?= $mime ?>;base64,<?= $content; ?>" width="100%">
                <?php } ?>

            </div>
        </div>




        </div>





</div>

<?php

$style = <<<CSS
    #image-view{
   /* transform: rotate(-90deg);*/
    }
CSS;

$this->registerCss($style);

