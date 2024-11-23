<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\web\IdentityInterface;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string $password_hash
 * @property string $auth_key
 */
class User extends ActiveRecord implements IdentityInterface
{
    public $password; // Пароль при регистрации

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * Правила валидации
     */
    public function rules()
    {
        return [
            [['username', 'email', 'password'], 'required'], // Все обязательные поля
            ['email', 'email'], // Проверка email
            ['password', 'string', 'min' => 6], // Минимальная длина пароля
        ];
    }

    /**
     * Хешируем пароль перед сохранением
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            // Хешируем пароль, если он был задан
            if (!empty($this->password)) {
                $this->password_hash = Yii::$app->security->generatePasswordHash($this->password);
            }
            // Генерируем auth_key
            if (empty($this->auth_key)) {
                $this->auth_key = Yii::$app->security->generateRandomString();
            }
            return true;
        }
        return false;
    }

    /**
     * Создаём пользователя и сохраняем в БД
     * @return bool
     */
    public function signup()
    {
        if ($this->validate()) {
            // Сохраняем модель в базу
            return $this->save();
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    /**
     * Метод для проверки пароля
     * @param string $password
     * @return bool
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }
}
