<?php

namespace app\services;

use Yii;
use app\models\User;

// TODO replace User::findByUsername($form->username) with repository, when Schemas for Users will be created

class AuthService
{
    /**
     * @param $form
     * @return bool
     */
    public function login($form)
    {
        return Yii::$app->user->login(User::findByUsername($form->username), $form->rememberMe ? 3600*24*30 : 0);
    }

    /**
     * @return bool
     */
    public function logout()
    {
        return Yii::$app->user->logout();
    }
}