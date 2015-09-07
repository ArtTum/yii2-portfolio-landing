<?php

/* @var $this yii\web\View */
/* @var $model common\models\Languages */


$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'language',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('common_languages', 'Languages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('common_languages', 'Update');
?>
<div class="languages-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
