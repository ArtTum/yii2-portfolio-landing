<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Skills');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="skill-index">
    <div class="clearfix">
        <?php echo Html::a(Yii::t('backend', 'Create {modelClass}', [
            'modelClass' => 'skills',
        ]), ['create'], ['class' => 'btn btn-success pull-left']) ?>
    </div>
    <br>
    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => [
            'class' => 'dataTable table table-striped table-bordered'
        ],
        'summary' => false,
        'showOnEmpty' => false,
        'columns' => [
            [
                'attribute' => 'title',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a($model->name, ['update', 'id' => $model->id]);
                },
            ],
            'mark',
            [
                'headerOptions' => [
                    'class' => 'checkboxed'
                ],
                'attribute' => 'active',
                'format' => 'raw',
                'value' => function ($model) {
                    $checkStatus = $model->active ? 'Active' : 'Disabled';
                    return $checkStatus;
                },
            ],
            'sort',
            [
                'headerOptions' => [
                    'class' => 'unsorted'
                ],
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}'
            ],
        ],
    ]); ?>
</div>