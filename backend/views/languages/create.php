<?php
/* @var $this yii\web\View */
/* @var $model common\models\Languages */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'language',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('common_languages', 'Language'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="languages-create">

    <?php echo $this->render('_form', [
        'model' => $model
    ]) ?>

</div>
