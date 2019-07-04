<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "admins".
 *
 * @property int $admin_id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $password
 * @property int $is_active
 * @property int $is_deleted
 * @property string $admin_type
 */
class Admins extends \yii\db\ActiveRecord
{
    public $password_hash,$confirm_password;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'admins';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email', 'phone', 'password', 'admin_type'], 'required'],
            [['name', 'email', 'phone', 'password', 'admin_type'], 'trim'],
            [['is_active', 'is_deleted'], 'integer'],
            [['name', 'phone'], 'string', 'max' => 48],
            [['email', 'password'], 'string', 'max' => 128],
            [['admin_type'], 'string', 'max' => 1],
            [['password_hash','confirm_password'], 'required', 'on' => 'create'],
            [['password_hash'],'string','min'=>6],
            ['email', 'email'],
            ['email', 'unique'],
            ['phone', 'unique'],
            ['confirm_password', 'compare', 'compareAttribute' => 'password_hash','message' => Yii::t('yii', 'Confirm Password must be equal to "Password"')],
            ['phone', 'match', 'pattern' => '/^[0-9-+]+$/', 'message' => Yii::t('yii', 'Your phone can only contain numeric characters with +/-')],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'admin_id' => 'Admin ID',
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'password' => 'Password',
            'password_hash' => Yii::t('app', 'Password'),
            'is_active' => 'Is Active',
            'is_deleted' => 'Is Deleted',
            'admin_type' => 'Admin Type',
        ];
    }
}
