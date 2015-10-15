<?php

/* @var $this yii\web\View */


$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'project',
]) . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Projects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="project-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
