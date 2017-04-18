<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Locale;
/* @var $this yii\web\View */
/* @var $model app\models\CategoryLocale */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-locale-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'locale_id')->dropDownList(ArrayHelper::map(Locale::find()->all(), 'id', 'value')) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'value')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
