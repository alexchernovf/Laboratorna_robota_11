<?php

use app\models\Songs;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\SongSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Songs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="songs-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Songs', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'name',
            'artist',
            'genre',
            'year',
            [
                'attribute' => 'image',
                'format' => 'html',
                'value' => function ($model) {
                    if (!empty($model->image)) {
                        $filePath = Yii::getAlias('@webroot/' . $model->image);
                        if (file_exists($filePath)) {
                            return Html::img(Yii::getAlias('@web/' . $model->image), ['style' => 'max-width: 100px;']);
                        } else {
                            Yii::error('Image not found at: ' . $filePath); // Логирование ошибки
                            return 'Image not found';
                        }
                    } else {
                        return 'No Image';
                    }
                },
            ],
            [
                'attribute' => 'content',
                'value' => function ($model) {
                    return Html::encode($model->content);
                },
            ],
            [
                'attribute' => 'description',
                'value' => function ($model) {
                    return Html::encode($model->description);
                },
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
