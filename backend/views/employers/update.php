<?php

/* @var $this yii\web\View */
/* @var $model common\models\skills */


$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'employers',
]) . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Employers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="employer-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
