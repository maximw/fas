<?php

namespace app\models;

use yii\base\Security;
use yii\db\ActiveRecord;

/**
 *
 * @property int $id
 * @property string $login
 * @property string $password
 * @property string $auth_key
 * @property string $role
 */
class User extends ActiveRecord implements \yii\web\IdentityInterface
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'role'], 'required'],
            [['username'], 'string', 'max' => 64],
            [['password'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['role'], 'string', 'max' => 16],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'User name',
            'role' => 'Role',
        ];
    }


    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
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
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Security::generateRandomKey();
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return \Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = \Yii::$app->getSecurity()->generatePasswordHash($password);
    }

    public function beforeSave($insert)
     {
        // Первому юзеру нельзя роли поменять, он суперадмин
        if (1 !== $this->getId()) {
            $auth = \Yii::$app->authManager;
            // Зачем-то при добавлении уже существующей роли кидается исключение, причем не специфическое,
            // так что в try catch не завернешь, приходится проверять если ли уже такая роль.
            $roles = $auth->getRolesByUser($this->getId());
            if (!array_key_exists($this->role, $roles)) {
                $role = $auth->getRole($this->role);
                $auth->revokeAll($this->getId());
                $auth->assign($role, $this->getId());
            }
        }
        return parent::beforeSave($insert);
    }
}
