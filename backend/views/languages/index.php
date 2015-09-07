<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\CheckboxColumn;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('common_languages', 'Language');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="languages-index">
    <div class="clearfix">
        <?php echo Html::a(Yii::t('backend', 'Create {modelClass}', [
            'modelClass' => 'language',
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
                'attribute' => 'name',
                'format' => 'raw',
                'value' => function ($model, $index, $widget) {
                    return Html::a($model->name, ['update', 'id' => $model->id]);
                },
            ],
            'locale',
            [
                'headerOptions' => [
                    'class' => 'checkboxed'
                ],
                'attribute' => 'active',
                'format' => 'raw',
                'value' => function ($model, $index, $widget) {
                    $checkStatus = $model->active? 'active':'disabled';
                    return "<div class='hidden'>".$checkStatus."</div>".Html::checkbox('active[]', $model->active, ['value' => $index, 'disabled' => true]);
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