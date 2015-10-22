<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Hobby');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="index">
    <div class="clearfix">
        <?php echo Html::a(Yii::t('backend', 'Create {modelClass}', [
            'modelClass' => 'hobby',
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
                'value' => function ($model) {
                    return Html::a($model->name, ['update', 'id' => $model->id]);
                },
            ],
            'icon_name',
            [
                'headerOptions' => [
                    'class' => 'checkboxed'
                ],
                'attribute' => 'active',
                'format' => 'raw',
                'value' => function ($model) {
                    $checkStatus = $model->active ? 'Active' : 'Disabled';
                    return "<div class='hidden'>" . $checkStatus . "</div>" . Html::checkbox('default[]', $model->active, ['value' => $model->active, 'disabled' => true]);
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