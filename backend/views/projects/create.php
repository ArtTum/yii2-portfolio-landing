<?php
/* @var $this yii\web\View */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'project',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Projects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-create">

    <?php echo $this->render('_form', [
        'model' => $model
    ]) ?>

</div>
