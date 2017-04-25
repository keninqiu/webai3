<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\OriginLocale */

$this->title = Yii::t('app', 'Create Origin Locale');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Origin Locales'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="origin-locale-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
