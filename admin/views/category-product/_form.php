<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Category;
use app\models\Product;

/* @var $this yii\web\View */
/* @var $model app\models\CategoryProduct */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'category_id')->dropDownList(ArrayHelper::map(Category::find()->all(), 'id', 'name')) ?>

    <?= $form->field($model, 'product_id')->dropDownList(ArrayHelper::map(Product::find()->all(), 'id', 'name')) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
