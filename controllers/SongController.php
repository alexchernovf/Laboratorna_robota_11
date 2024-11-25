<?php

namespace app\controllers;

use Yii;
use app\models\Songs;
use app\models\SongSearch;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;
use app\models\Category;

class SongController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }


    public function beforeAction($action)
    {
        // Перевірка, чи є користувач авторизованим і чи має роль адміністратора
        if (Yii::$app->user->isGuest || Yii::$app->user->identity->is_admin != 1) {
            throw new ForbiddenHttpException('You do not have permission to access this page.');
        }

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $searchModel = new SongSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    public function actionCreate()
    {
        $model = new Songs();

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());

            $file = UploadedFile::getInstance($model, 'image');
            if ($file) {
                $filePath = Yii::getAlias('@webroot/uploads/' . $file->baseName . '.' . $file->extension);
                if ($file->saveAs($filePath)) {
                    $model->image = 'uploads/' . $file->baseName . '.' . $file->extension;
                } else {
                    Yii::error("Помилка");
                }
            }

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', ['model' => $model]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {


            $file = UploadedFile::getInstance($model, 'image');
            if ($file) {
                $filePath = Yii::getAlias('@webroot/uploads/' . $file->baseName . '.' . $file->extension);
                if ($file->saveAs($filePath)) {
                    $model->image = 'uploads/' . $file->baseName . '.' . $file->extension;
                } else {
                    Yii::error("Помилка.");
                }
            }

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', ['model' => $model]);
    }


    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionSetCategory($id)
    {
        $song = $this->findModel($id);

        if (Yii::$app->request->isPost) {

            $category = Yii::$app->request->post('Songs')['category_id'];
            $song->category_id = $category;

            if ($song->save()) {

                return $this->redirect(['view', 'id' => $song->id]);
            }
        }


        $categories = \yii\helpers\ArrayHelper::map(Category::find()->all(), 'id', 'title');


        $selectedCategory = $song->category_id;

        return $this->render('category', [
            'song' => $song,
            'categories' => $categories,
            'selectedCategory' => $selectedCategory
        ]);
    }

    public function actionSetTags($id)
    {
        $song = $this->findModel($id);
        $selectedTags = $song->getSelectedTags();
        $tags = ArrayHelper::map(Tag::find()->all(), 'id', 'title');
        if (Yii::$app->request->isPost) {
            $tags = Yii::$app->request->post('tags');
            $song->saveTags($tags);
            return $this->redirect(['view', 'id' => $song->id]);
        }

        // Передать переменные в представление
        return $this->render('tags', [
            'selectedTags' => $selectedTags,
            'tags' => $tags
        ]);
    }


    protected function findModel($id)
    {
        if (($model = Songs::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
