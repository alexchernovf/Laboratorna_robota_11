<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\PublicAsset;
use yii\bootstrap5\Html;
use yii\widgets\Breadcrumbs;
use yii\widgets\LinkPager;

PublicAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
?>
<?php $this->beginPage() ?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="<?= Yii::$app->homeUrl ?>">My Blog</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="site/login">Login</a></li>
                <li class="nav-item"><a class="nav-link" href="site/signup">Register</a></li>
            </ul>
        </div>
    </div>
</nav>

<?=$content ?>


<!-- Footer -->
<footer class="bg-dark text-light py-4">
    <div class="container text-center">
        <p>&copy; <?= date('Y') ?> My Blog | Designed by Developer</p>
        <p>
            <a href="#" class="text-light me-2"><i class="fa fa-facebook"></i></a>
            <a href="#" class="text-light me-2"><i class="fa fa-twitter"></i></a>
            <a href="#" class="text-light"><i class="fa fa-instagram"></i></a>
        </p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
