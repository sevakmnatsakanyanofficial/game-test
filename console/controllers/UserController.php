<?php

namespace console\controllers;

use common\models\User;
use Yii;
use yii\console\Controller;

class UserController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();

        // add "admin" role
        $admin = $auth->createRole(User::ROLE_ADMIN);
        $auth->add($admin);

        // add "gamer" role
        $gamer = $auth->createRole(User::ROLE_GAMER);
        $auth->add($gamer);

        // create admin user and assign role
        $auth->assign($admin, $this->createUser('admin', 'a123456'));

        // create gamers and assign role
        $auth->assign($gamer, $this->createUser('gamer1', '123456'));
        $auth->assign($gamer, $this->createUser('gamer2', '123456'));
    }

    protected function createUser($username, $password)
    {
        $user = new User();
        $user->username = $username;
        $user->setPassword($password);
        $user->generateAuthKey();
        $user->save();

        return $user->id;
    }
}