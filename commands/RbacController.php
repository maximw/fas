<?php

namespace app\commands;

use app\helpers\RbacHelper;
use yii\console\Controller;
use yii\console\ExitCode;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = \Yii::$app->getAuthManager();
        $auth->removeAll();

        $permissions = [];
        foreach (RbacHelper::PERMISSIONS as $permissionName) {
            $permissions[$permissionName] = $auth->createPermission($permissionName);
            $auth->add($permissions[$permissionName]);
        }

        foreach (RbacHelper::ROLES as $roleName => $rolePermissions) {
            $role = $auth->createRole($roleName);
            $auth->add($role);
            foreach ($rolePermissions as $permissionName) {
                $auth->addChild($role, $permissions[$permissionName]);
            }
        }

        // Первый юзер может все, надо же с чего-то начинать
        foreach (RbacHelper::ROLES as $roleName => $rolePermissions) {
            $role = $auth->getRole($roleName);
            $auth->assign($role, 1);
        }

        return ExitCode::OK;
    }
}