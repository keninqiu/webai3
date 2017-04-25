<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Origin */

$this->title = Yii::t('app', 'Create Origin');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Origins'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="origin-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
