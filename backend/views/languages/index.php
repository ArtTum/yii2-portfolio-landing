<?php

use yii\helpers\Html;
use yii\grid\GridView;

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
                'value' => function ($model) {
                    return Html::a($model->name, ['update', 'id' => $model->id]);
                },
            ],
            [
                'headerOptions' => [
                    'class' => 'unsorted'
                ],
                'attribute' => 'flag',
                'format' => 'html',
                'value' => function ($model) {
                    return Html::img($model->getFlagUrl(), ['width' => '25px']);
                },
            ],
            'locale',
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
            [
                'headerOptions' => [
                    'class' => 'checkboxed'
                ],
                'attribute' => 'default',
                'format' => 'raw',
                'value' => function ($model) {
                    $checkStatus = $model->default ? 'Default' : '';
                    return $checkStatus;
                    //@TODO: Problem with comeback in Chrome. Wrong merge of checked data.
                    //return "<div class='hidden'>" . $checkStatus . "</div>" . Html::checkbox('default[]', $model->default, ['value' => $model->default, 'disabled' => true]);
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