<?php
/* @var $this yii\web\View */
/* @var $model common\models\Skills */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'hobby',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'hobby'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="create">

    <?php echo $this->render('_form', [
        'model' => $model
    ]) ?>

</div>
