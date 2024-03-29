<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\base\NotSupportedException;

class User extends ActiveRecord implements IdentityInterface
{
    public $auth_key;
    public $client_id;
    public $business_name;
    public $representative_name;
    public $business_address;
    public $total_sms;
    public $created_at;
    public $updated_at;
    public $has_own_gateway;
    public $gateway_username;
    public $gateway_password;
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%admins}}';
    }


    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        if (\Yii::$app->session['_smsbroadcastAuth'] == 1) {
            return static::findOne(['admin_id' => $id, 'is_active' => self::STATUS_ACTIVE,'is_deleted' => self::STATUS_DELETED]);
        }
        elseif (\Yii::$app->session['_smsbroadcastAuth'] == 2) {
            $dbUser = Clients::find()->where(['client_id' => $id, 'is_active' => self::STATUS_ACTIVE,'is_deleted' => self::STATUS_DELETED])->one();
            return new static($dbUser);
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['email' => $username,'is_deleted' => self::STATUS_DELETED,'is_active' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, trim($this->password));
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }
}
