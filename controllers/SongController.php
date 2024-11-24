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

/**
 * SongController implements the CRUD actions for Songs model.
 */
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

    /**
     * Lists all Songs models.
     *
     * @return string
     */
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

    /**
     * Displays a single Songs model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Songs model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Songs();

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            $file = UploadedFile::getInstance($model, 'image');

            if ($file) {
                // Указываем путь для сохранения файла
                $filePath = Yii::getAlias('@webroot/uploads/' . $file->baseName . '.' . $file->extension);


                if ($file->saveAs($filePath)) {
                    $model->image = 'uploads/' . $file->baseName . '.' . $file->extension;
                } else {
                    Yii::error("Помилка при завантаженні зображення.");
                }
            }

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', ['model' => $model]);
    }

    /**
     * Updates an existing Songs model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            $file = UploadedFile::getInstance($model, 'image');

            if ($file) {

                $filePath = Yii::getAlias('@webroot/uploads/' . $file->baseName . '.' . $file->extension);


                if ($file->saveAs($filePath)) {
                    $model->image = 'uploads/' . $file->baseName . '.' . $file->extension;
                } else {
                    Yii::error("Помилка при завантаженні зображення.");
                }
            }

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', ['model' => $model]);
    }

    /**
     * Deletes an existing Songs model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Songs model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Songs the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Songs::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
