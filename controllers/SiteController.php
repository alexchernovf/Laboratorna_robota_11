<?php
namespace app\controllers;

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

        // Если данные были отправлены и форма валидна, сохраняем пользователя
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Регистрация прошла успешно! Теперь вы можете войти.');
            return $this->redirect(['site/login']); // Перенаправляем на страницу входа
        }

        return $this->render('signup', ['model' => $model]); // Отображаем форму регистрации
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

        $model->password = ''; // Очищаем пароль при неправильном вводе
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
