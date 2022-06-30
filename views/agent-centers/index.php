<?php

/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/22/2020
 * Time: 5:23 PM
 */

use yii\bootstrap4\Html;

/* @var $this yii\web\View */

$this->title = Yii::$app->params['generalTitle'];
$this->params['breadcrumbs'][] = ['label' => 'Agents List', 'url' => ['index']];

$url = \yii\helpers\Url::home(true);
?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <?= Html::a('Assign a Polling Station', ['agent-center/create'], ['class' => 'btn btn-success']) ?>
                <?php Html::a('<i class="fa fa-download"></i> Download Template', \yii\helpers\Url::home(true) . "templates/agents.xlsx", ['class' => 'btn btn-info mx-1', 'title' => 'Get data import sample excel template here.']) ?>
            </div>
        </div>
    </div>
</div>


<?php
if (Yii::$app->session->hasFlash('success')) {
    print ' <div class="alert alert-success alert-dismissable">
                             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h5><i class="icon fas fa-check"></i> Success!</h5>
 ';
    echo Yii::$app->session->getFlash('success');
    print '</div>';
} else if (Yii::$app->session->hasFlash('error')) {
    print ' <div class="alert alert-danger alert-dismissable">
                                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h5><i class="icon fas fa-check"></i> Error!</h5>
                                ';
    echo Yii::$app->session->getFlash('error');
    print '</div>';
}
?>
<div class="row">
    <div class="col-md-12">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Agent Assignment List</h3>






            </div>
            <div class="card-body">
                <table class="table table-bordered dt-responsive table-hover" id="table">
                </table>
            </div>
        </div>
    </div>
</div>

<input type="hidden" value="<?= $url ?>" id="url" />
<?php

$script = <<<JS

    $(function(){
         /*Data Tables*/
         
        $.fn.dataTable.ext.errMode = 'throw';
        const url = $('#url').val();
    
          $('#table').DataTable({
           
            //serverSide: true,  
            ajax: url+'agent-centers/list',
            paging: true,
            columns: [
                { title: 'Agent ID' ,data: 'username'},
                { title: 'Phone Number' ,data: 'phone_number'},
                { title: 'County' ,data: 'county'},
                { title: 'Ward' ,data: 'Ward'},
                { title: 'Constituency' ,data: 'constituency'},
                { title: 'center' ,data: 'center'},
                { title: 'Polling Station Code' ,data: 'polling_station_code'},
                { title: 'Agent Level' ,data: 'level'},
                { title: 'Aactions' ,data: 'actions'},
               
               
            ] ,                              
           language: {
                "zeroRecords": "No Records to show"
            },
            
            order : [[ 0, "desc" ]]
            
           
       });
        
       //Hidding some 
       var table = $('#table').DataTable();
      // table.columns([0,6]).visible(false);
    
    /*End Data tables*/
        $('#table').on('click','tr', function(){
            
        });
    });
        
JS;

$this->registerJs($script);

$style = <<<CSS
    table td:nth-child(7), td:nth-child(8), td:nth-child(9) {
        text-align: center;
    }
CSS;

//$this->registerCss($style);
