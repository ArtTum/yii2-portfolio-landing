<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Languages */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="languages-create-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'class' => 'col-md-6'
        ]
    ]); ?>
    <?php echo $form->errorSummary($model) ?>
    <?php echo $form->field($model, 'flag')->widget(
        \trntv\filekit\widget\Upload::className(),
        [
            'url'=>['/file-storage/upload'],
            'multiple'=>false
        ]
    ) ?>
    <?php echo $form->field($model, 'name')->textInput(['maxlength' => 50]) ?>
    <?php echo $form->field($model, 'locale')->dropDownList(\common\models\Languages::getLocales()) ?>
    <?php echo $form->field($model, 'active')->checkbox() ?>
    <?php echo $form->field($model, 'default')->checkbox() ?>
    <?php echo $form->field($model, 'sort')->textInput() ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
