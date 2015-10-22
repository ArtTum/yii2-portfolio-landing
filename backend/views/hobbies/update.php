<?php

/* @var $this yii\web\View */


$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'skills',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Hobby'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('common_languages', 'Update');
?>
<div class="update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
