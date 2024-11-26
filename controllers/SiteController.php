<?php
namespace app\controllers;

use app\models\Songs;
use Yii;
use yii\web\Controller;
use app\models\User;
use app\models\LoginForm;
use yii\web\Response;
use yii\widgets\ActiveForm;

class SiteController extends Controller
{
    /**
     * Регистрация пользователя
     */



    public function actionIndex()
    {
        // Используем ActiveDataProvider для пагинации
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => Songs::find(),
            'pagination' => [
                'pageSize' => 10, // Количество записей на странице
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionView()
    {
        return $this->render('index');
    }

    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            return $this->render('error', ['exception' => $exception]);
        }
    }

    public function actionSignup()
    {
        $model = new User();


        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Регистрация прошла успешно! Теперь вы можете войти.');
            return $this->redirect(['site/login']);
        }

        return $this->render('signup', ['model' => $model]);
    }

    /**
     * Вход пользователя
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', ['model' => $model]);
    }

    /**
     * Выйти из системы
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }



}
