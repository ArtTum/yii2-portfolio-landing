<?php
/* @var $this yii\web\View */
/* @var $model common\models\Skills */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'employers',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Employers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employer-create">

    <?php echo $this->render('_form', [
        'model' => $model
    ]) ?>

</div>
