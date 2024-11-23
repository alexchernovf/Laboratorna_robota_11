<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Songs $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Songs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="songs-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'artist',
            'genre',
            'year',
            'created_at',
            'updated_at',
            [
                'label' => 'Image',
                'value' => function ($model) {
                    if ($model->image) {
                        return Html::img('data:image/jpeg;base64,' . base64_encode($model->image), ['width' => '200px']);
                    }
                    return 'No image';
                },
                'format' => 'raw',
            ],
        ],
    ]) ?>

</div>
