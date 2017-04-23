<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Locale;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model app\models\SettingLocale */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="setting-locale-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'locale_id')->dropDownList(ArrayHelper::map(Locale::find()->all(), 'id', 'value')) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'value')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
