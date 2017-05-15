<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use frontend\models\Category;
use yii\db\ActiveQuery;
use backend\models\Pages;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="/images/logo.png" type="image/x-icon" />


    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
<div class="container">
<img src="/images/logo.png" />
</div>
    <?php
    NavBar::begin([
        'brandLabel' => 'Главная',    
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse container',
            'style' => 'border-radius: 10px;',
        ],
    ]);
    $pages = Pages::find()->all();
    foreach ($pages as $page) {
        $menuItems[] = ['label' => $page->name, 'url' => Url::to(['site/pages', 'alias' => $page->alias])];
    }
   echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' =>
            $menuItems,
    ]);
    // if (Yii::$app->user->isGuest) {
    //     $menuItems[] = ['label' => 'Регистрация', 'url' => ['/site/signup']];
    //     $menuItems[] = ['label' => 'Вход', 'url' => ['/site/login']];
    // } else {
    //     $menuItems[] = '<li>'
    //         . Html::beginForm(['/site/logout'], 'post')
    //         . Html::submitButton(
    //             'Logout (' . Yii::$app->user->identity->username . ')',
    //             ['class' => 'btn btn-link logout']
    //         )
    //         . Html::endForm()
    //         . '</li>';
    // }

    NavBar::end();
    ?>

    <div class="container back">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [''],
        ]) ?>
        <?= Alert::widget() ?>
        <?php $category = Category::find()->where(['parent_id' => 0])->with('category')->all();?>
        <div class="row">
        <div class="col-md-3 hidden-xs">
       <div class="list-group">
    <a class="list-group-item active">
        <span class="glyphicon glyphicon-home"></span> Меню
    </a>
    <a href="/" class="list-group-item">
        <span class="glyphicon glyphicon-home"></span> Главная
    </a>
  
   <select class="list-group-item"  style="width:100%">
   <option><h2>Жалюзи</h2></option>
     <?php foreach($category as $cat):?>
            <option><?='&nbsp&nbsp'.$cat->name?></option>
        <?php foreach($cat->category as $c):?>
            <option><?='&nbsp&nbsp&nbsp&nbsp'.$c->name?></option>
        <?php endforeach;?>
     <?php endforeach;?>
   </select>
   <?php foreach($pages as $page):?>
    <a href="<?=Url::to(['site/page', 'alias' => $page->alias])?>" class="list-group-item">
     <?=$page->name?>
    </a>
  <?php endforeach;?>
    <form role="search" method="get">
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Поиск" name="s">
          <span class="input-group-btn">
            <button class="btn btn-info" type="submit">
              <i class="glyphicon glyphicon-search"></i>
            </button>
          </span>
      </div>
    </form><!-- Конец формы -->
</div>
        </div>
        <div class="col-md-9" style="margin-top: -25px;">
        <?= $content ?>
        </div>
        </div>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Один день <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
