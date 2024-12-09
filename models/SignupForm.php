<?php

namespace app\models;

use Yii;
use yii\base\Model;

class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;

    public function rules()
    {
        return [
            [['username', 'email', 'password'], 'required'],
            ['email', 'email'],
        ];
    }

    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password); // Updates password_hash
            $user->generateAuthKey(); // Sets auth_key

            if ($user->save()) {
                // Assign the role 'author' if it exists
                $auth = Yii::$app->authManager;
                $role = $auth->getRole('author');
                if ($role) {
                    $auth->assign($role, $user->id);
                }
                return $user;
            } else {
                // Log or display errors for debugging
                Yii::error('Signup failed: ' . json_encode($user->getErrors()));
            }
        }

        return null; // Return null on failure
    }

}
