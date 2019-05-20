<?php


namespace app\helpers;


class RbacHelper
{
    const ROLE_OPERATOR = 'operator';
    const ROLE_ADMIN = 'admin';

    const PERMISSION_CREATE = 'create';
    const PERMISSION_VIEW = 'view';
    const PERMISSION_UPDATE = 'update';
    const PERMISSION_DELETE = 'delete';

    // Отдельно управление юзерами, вне рамок задачи
    const PERMISSION_USER_MANAGEMENT = 'user';

    const ROLES = [
        self::ROLE_OPERATOR => [
            self::PERMISSION_CREATE,
            self::PERMISSION_VIEW,
        ],
        self::ROLE_ADMIN => [
            self::PERMISSION_CREATE,
            self::PERMISSION_VIEW,
            self::PERMISSION_UPDATE,
            self::PERMISSION_DELETE,
            self::PERMISSION_USER_MANAGEMENT,
        ]
    ];

    const PERMISSIONS = [
        self::PERMISSION_CREATE,
        self::PERMISSION_VIEW,
        self::PERMISSION_UPDATE,
        self::PERMISSION_DELETE,
        self::PERMISSION_USER_MANAGEMENT,
    ];

    const ROLES_DROPDOWN_LIST = [
        self::ROLE_OPERATOR => self::ROLE_OPERATOR,
        self::ROLE_ADMIN => self::ROLE_ADMIN,
    ];

    /**
     * Для удобства, что так, что так через статический метод вызывается
     *
     * @param $permissionName
     * @return bool
     */
    public static function can($permissionName)
    {
        return \Yii::$app->getUser()->can($permissionName);
    }

}