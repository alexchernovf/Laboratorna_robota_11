<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Songs $model */

$this->title = 'Create Songs';
$this->params['breadcrumbs'][] = ['label' => 'Songs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="songs-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
