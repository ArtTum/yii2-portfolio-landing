<?php

/* @var $this yii\web\View */
/* @var $model common\models\skills */


$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'skills',
]) . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Skills'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('common_languages', 'Update');
?>
<div class="skill-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
