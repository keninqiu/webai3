<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    $items = [
        ['label' => 'Login', 'url' => ['/site/login']]
    ];
    if(Yii::$app->user->identity) {
        $items = [
                ['label' => 'Home', 'url' => ['/site/index']],
                [
                    'label' => 'Setting', 'url' => ['#'],
                    'items' => [
                        ['label' => 'Setting', 'url' => ['/setting']],
                        ['label' => 'Mode', 'url' => ['/mode']],
                        ['label' => 'Origin', 'url' => ['/origin']],
                        ['label' => 'Position', 'url' => ['/position']],
                        ['label' => 'Slide', 'url' => ['/slide']],
                        ['label' => 'Brand', 'url' => ['/brand']],
                        ['label' => 'Image Type', 'url' => ['/image-type']],
                    ],                
                ],

                [
                    'label' => 'Locale', 'url' => ['#'],
                    'items' => [
                        ['label' => 'Locale', 'url' => ['/locale']],
                        ['label' => 'Setting Locale', 'url' => ['/setting-locale']],
                        ['label' => 'Origin Locale', 'url' => ['/origin-locale']],
                        ['label' => 'Product Locale', 'url' => ['/product-locale']],
                        ['label' => 'Category Locale', 'url' => ['/category-locale']],
                    ],                
                ],

                
                
                
                ['label' => 'Mode Category', 'url' => ['/mode-category']],      
                
                ['label' => 'Product', 'url' => ['/product']],
                
                ['label' => 'Category', 'url' => ['/category']],
                
                ['label' => 'Category Product', 'url' => ['/category-product']],
                ['label' => 'Product Image', 'url' => ['/product-image']],

                    '<li>'
                    . Html::beginForm(['/site/logout'], 'post')
                    . Html::submitButton(
                        'Logout (' . Yii::$app->user->identity->username . ')',
                        ['class' => 'btn btn-link logout']
                    )
                    . Html::endForm()
                    . '</li>'

        ];
    }
        NavBar::begin([
            'brandLabel' => 'Cishop',
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar-inverse navbar-fixed-top',
            ],
        ]);
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => $items
        ]);
        NavBar::end();        
    

    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Cishop <?= date('Y') ?></p>
        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
