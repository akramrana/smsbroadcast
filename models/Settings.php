<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "settings".
 *
 * @property int $setting_id
 * @property string $gateway_username
 * @property string $gateway_password
 */
class Settings extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'settings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gateway_username', 'gateway_password'], 'required'],
            [['gateway_username', 'gateway_password'], 'string', 'max' => 32],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'setting_id' => 'Setting ID',
            'gateway_username' => 'Gateway Username',
            'gateway_password' => 'Gateway Password',
        ];
    }
}
