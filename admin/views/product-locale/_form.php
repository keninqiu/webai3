<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\Locale;
use app\models\Product;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProductLocale */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-locale-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'product_id')->dropDownList(ArrayHelper::map(Product::find()->all(), 'id', 'name'), ['disabled' => 'disabled']) ?>

    <?= $form->field($model, 'locale_id')->dropDownList(ArrayHelper::map(Locale::find()->all(), 'id', 'value'), ['disabled' => 'disabled']) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true,'readonly' => true]) ?>

    <?= $form->field($model, 'value')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
