<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\PublicAsset;
use yii\bootstrap5\Html;

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

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
    <a class="navbar-brand" href="<?= \yii\helpers\Url::to(['site/index']); ?>">
        <img src="<?= Yii::$app->request->baseUrl ?>/uploads/logo.png" alt="Logo" style="width: 50px; height: auto;">
    </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="<?= \yii\helpers\Url::to(['site/index']); ?>">Home</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <?php if (Yii::$app->user->isGuest): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= \yii\helpers\Url::to(['auth/login']); ?>">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= \yii\helpers\Url::to(['auth/signup']); ?>">Register</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= \yii\helpers\Url::to(['auth/logout']); ?>" data-method="post">
                            Logout (<?= Yii::$app->user->identity->username; ?>)
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<?= $content ?>

<!-- Footer -->
<footer class="footer-widget-section bg-dark text-light py-5">
    <div class="container">
        <div class="row">
            <!-- About Section -->
            <div class="col-md-4">
                <aside class="footer-widget">
                    <img src="/uploads/logo.png" alt="Logo" class="mb-3" style="max-width: 150px;">
                    <p>Your go-to platform for the latest in music trends, reviews, and artist features.</p>
                </aside>
            </div>

            <!-- Latest Blog Posts -->
            <div class="col-md-4">
                <aside class="footer-widget">
                    <h3 class="widget-title text-uppercase mb-4">Latest Blog Posts</h3>
                    <ul class="list-unstyled">
                        <?php
                        use app\models\Article;
                        $recentArticles = Article::getRecent();
                        foreach ($recentArticles as $article): ?>
                            <li class="mb-3">
                                <a href="<?= Yii::$app->urlManager->createUrl(['site/view', 'id' => $article->id]) ?>" class="text-light">
                                    <?= $article->title ?>
                                </a>
                                <span class="d-block small"><?= Yii::$app->formatter->asDate($article->date, 'long') ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </aside>
            </div>

            <!-- Contact Info -->
            <div class="col-md-4">
                <aside class="footer-widget">
                    <h4 class="text-uppercase">Contact Us</h4>
                    <p>123 Music Avenue, Suite 456, NY</p>
                    <p>Phone: +123 456 78900</p>
                    <p>Email: <a href="mailto:info@musicblog.com" class="text-light">info@musicblog.com</a></p>
                </aside>
            </div>
        </div>
    </div>

    <div class="footer-copy bg-secondary py-3">
        <div class="container text-center">
            <p class="mb-0">&copy; <?= date('Y') ?> <a href="#" class="text-light">Modern Music Blog</a>, All Rights Reserved. Built with ❤️ by <a href="#" class="text-light">Masha & Alex</a></p>
        </div>
    </div>
</footer>



<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
