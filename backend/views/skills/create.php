<?php
/* @var $this yii\web\View */
/* @var $model common\models\Skills */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'skills',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Skills'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="skill-create">

    <?php echo $this->render('_form', [
        'model' => $model
    ]) ?>

</div>
