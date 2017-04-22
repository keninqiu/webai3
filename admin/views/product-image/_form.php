<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\Product;
use app\models\ImageType;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProductImage */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-image-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'product_id')->dropDownList(ArrayHelper::map(Product::find()->all(), 'id', 'name')) ?>

    <?= $form->field($model, 'type_id')->dropDownList(ArrayHelper::map(ImageType::find()->all(), 'id', 'name')) ?>

    <?= $form->field($model, 'imageFile')->fileInput() ?>
    <?php
    if($model->path) {
        echo '<img src="'.$model->path.'" height="100" width="100">';
    }
    
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
