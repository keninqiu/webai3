<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\Locale;
/* @var $this yii\web\View */
/* @var $searchModel app\models\OriginLocaleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Origin Locales');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="origin-locale-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Origin Locale'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'locale_id',
                'value' => 'locale.value',
                'filter' => Html::activeDropDownList($searchModel, 'locale_id', [''=>'']+ArrayHelper::map(Locale::find()->all(), 'id', 'value'), ['class' => 'form-control'])
            ],
            'name',
            'value',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
