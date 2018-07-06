<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\grid\GridView;
use common\models\finance\Collection;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model common\models\finance\Op */

$this->title = 'Receipt';
$this->params['breadcrumbs'][] = ['label' => 'Finance', 'url' => ['/finance']];
$this->params['breadcrumbs'][] = ['label' => 'Cashier', 'url' => ['/finance/cashier']];
$this->params['breadcrumbs'][] = ['label' => 'Receipt', 'url' => ['/finance/cashier/receipt']];
$this->params['breadcrumbs'][] = 'View';
$enable=false;
?>
<div class="receipt-view">

   <div class="container">
    <?= DetailView::widget([
        'model'=>$model,
        'responsive'=>true,
        'hover'=>true,
        'mode'=>DetailView::MODE_VIEW,
        'panel'=>[
            'heading'=>'<i class="glyphicon glyphicon-book"></i> Receipt#: ' . $model->or_number,
            'type'=>DetailView::TYPE_PRIMARY,
         ],
        'buttons1' => '',
        'attributes' => [
            [
                'columns' => [
                    [
                        'label'=>'Payor',
                        'format'=>'raw',
                        'value'=>$model->payor,
                        'valueColOptions'=>['style'=>'width:30%'], 
                        'displayOnly'=>true
                    ],
                    [
                        'label'=>'Nature of Collection',
                        'format'=>'raw',
                        'value'=>$model->collectiontype->natureofcollection,
                        'valueColOptions'=>['style'=>'width:30%'], 
                        'displayOnly'=>true
                    ],
                ],
                    
            ],
            [
                'columns' => [
                    [
                        'label'=>'Receipt Date',
                        'format'=>'raw',
                        'value'=>$model->receiptDate,
                        'valueColOptions'=>['style'=>'width:30%'], 
                        'displayOnly'=>true
                    ],
                    [
                        'label'=>'Total of Collection',
                        'format'=>'raw',
                        'value'=>$model->total,
                        'valueColOptions'=>['style'=>'width:30%'], 
                        'displayOnly'=>true
                    ],
                ],
                    
            ],
          
        ],
    ]) ?>
   </div>
    <div class="main-container">
        <div class="container">
        <div class="table-responsive">
        <?php
            $gridColumns = [
                [
                    'attribute'=>'details',
                    'enableSorting' => false,
                    'contentOptions' => [
                        'style'=>'max-width:70px; overflow: auto; white-space: normal; word-wrap: break-word;'
                    ],
                ],
                [
                    'attribute'=>'amount',
                    'enableSorting' => false,
                    'hAlign' => 'right', 
                    'vAlign' => 'middle',
                    'width' => '15%',
                    'format' => ['decimal', 2],
                    'pageSummary' => true
                ],
              
                [
                    'class' => 'kartik\grid\ActionColumn',
                    'template' => '{delete}',
                    'dropdown' => false,
                    'dropdownOptions' => ['class' => 'pull-right'],
                    //'urlCreator' => function($action, $model, $key, $index) { return '#'; },
                   /* 'urlCreator' => function ($action, $model, $key, $index) {
                        if ($action === 'delete') {
                            $url ='/lab/sample/delete?id='.$model->sample_id;
                            return $url;
                        }

                    },
                    'deleteOptions' => ['title' => 'Delete Collection', 'data-toggle' => 'tooltip'],
                  */
                    'headerOptions' => ['class' => 'kartik-sheet-style'],
                ],
            ];

            echo GridView::widget([
                'id' => 'collection-grid',
                'dataProvider'=> $paymentitemDataProvider,
                'pjax'=>true,
                'pjaxSettings' => [
                    'options' => [
                        'enablePushState' => false,
                    ]
                ],
                'responsive'=>true,
                'striped'=>true,
                'showPageSummary' => true,
                'hover'=>true,
                'panel' => [
                    'heading'=>'<h3 class="panel-title">Collection</h3>',
                    'type'=>'primary', 'before'=>Html::button('<i class="glyphicon glyphicon-plus"></i> Add Collection', ['disabled'=>$enable, 'value' => Url::to(['add-collection','opid'=>$op_model->orderofpayment_id,'receiptid'=>$model->receipt_id]),'title'=>'Add Collection', 'onclick'=>'addCollection(this.value,this.title)', 'class' => 'btn btn-success','id' => 'modalBtn']),
                    'after'=>false,
                ],
                'columns' => $gridColumns,
               'toolbar' => [
                ],
            ]);
        ?>
        </div>
    </div>
    </div>
    <?php
     if($model->payment_mode_id == 2 && $model->total > 0){
         
        ?>
          <div class="main-container-check">
        <div class="container">
        <div class="table-responsive">
        <?php
            $gridColumns = [
                [
                    'attribute'=>'bank',
                    'enableSorting' => false,
                ],
                [
                    'attribute'=>'checknumber',
                    'enableSorting' => false,
                ],
                [
                    'attribute'=>'checkdate',
                    'enableSorting' => false,
                ],
                [
                    'attribute'=>'amount',
                    'enableSorting' => false,
                    'hAlign' => 'right', 
                    'vAlign' => 'middle',
                    'width' => '15%',
                    'format' => ['decimal', 2],
                    'pageSummary' => true
                ],
                [
                    'class' => 'kartik\grid\ActionColumn',
                    'template' => '{delete}',
                    'dropdown' => false,
                    'dropdownOptions' => ['class' => 'pull-right'],
                    'headerOptions' => ['class' => 'kartik-sheet-style'],
                ],
            ];

            echo GridView::widget([
                'id' => 'check-grid',
                'dataProvider'=> $check_model,
                'pjax'=>true,
                'pjaxSettings' => [
                    'options' => [
                        'enablePushState' => false,
                    ]
                ],
                'responsive'=>true,
                'striped'=>true,
                'showPageSummary' => true,
                'hover'=>true,
                'panel' => [
                    'heading'=>'<h3 class="panel-title">Cheque(s) Details</h3>',
                    'type'=>'primary', 'before'=>Html::button('<i class="glyphicon glyphicon-plus"></i> Add Check', ['disabled'=>$enable, 'value' => Url::to(['add-check','receiptid'=>$model->receipt_id]),'title'=>'Add Check', 'onclick'=>'addCheck(this.value,this.title)', 'class' => 'btn btn-success','id' => 'modalBtn']),
                    'after'=>false,
                ],
                'columns' => $gridColumns,
               'toolbar' => [
                ],
            ]);
        ?>
        </div>
    </div>
    </div>
    <?php
     }
    ?>
   
    
</div>
<script type="text/javascript">
   
    function addCollection(url,title){
       //var url = 'Url::to(['sample/update']) . "?id=' + id;
       //var url = '/lab/sample/update?id='+id;
        $(".modal-title").html(title);
        $('#modal').modal('show')
            .find('#modalContent')
            .load(url);
    }
    function addCheck(url,title){
       //var url = 'Url::to(['sample/update']) . "?id=' + id;
       //var url = '/lab/sample/update?id='+id;
        $(".modal-title").html(title);
        $('#modal').modal('show')
            .find('#modalContent')
            .load(url);
    }
</script>