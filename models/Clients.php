<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "clients".
 *
 * @property int $client_id
 * @property string $business_name
 * @property string $representative_name
 * @property string $business_address
 * @property string $email
 * @property string $password
 * @property string $phone
 * @property int $total_sms
 * @property string $created_at
 * @property string $updated_at
 * @property int $is_active
 * @property int $is_deleted
 * @property int $has_own_gateway
 * @property string $gateway_username
 * @property string $gateway_password
 *
 * @property ClientCampaigns[] $clientCampaigns
 * @property ClientGroups[] $clientGroups
 * @property ClientNumbers[] $clientNumbers
 * @property ClientSmsTemplates[] $clientSmsTemplates
 * @property ClientSubscriptions[] $clientSubscriptions
 */
class Clients extends \yii\db\ActiveRecord
{
    public $password_hash,$confirm_password;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clients';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['business_name', 'business_address', 'email', 'password', 'phone', 'total_sms', 'created_at', 'is_deleted', 'has_own_gateway'], 'required'],
            [['business_name', 'business_address', 'email', 'password', 'phone', 'total_sms', 'created_at', 'is_deleted', 'has_own_gateway'], 'trim'],
            [['business_address'], 'string'],
            [['total_sms', 'is_active', 'is_deleted', 'has_own_gateway'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['business_name', 'representative_name', 'email'], 'string', 'max' => 64],
            [['password'], 'string', 'max' => 128],
            [['phone'], 'string', 'max' => 28],
            [['gateway_username', 'gateway_password'], 'string', 'max' => 50],
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
            'client_id' => 'Client ID',
            'business_name' => 'Business Name',
            'representative_name' => 'Representative Name',
            'business_address' => 'Business Address',
            'email' => 'Email',
            'password' => 'Password',
            'password_hash' => 'Password',
            'phone' => 'Phone',
            'total_sms' => 'Total Sms',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'is_active' => 'Is Active',
            'is_deleted' => 'Is Deleted',
            'has_own_gateway' => 'Has Own Gateway',
            'gateway_username' => 'Gateway Username',
            'gateway_password' => 'Gateway Password',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientCampaigns()
    {
        return $this->hasMany(ClientCampaigns::className(), ['client_id' => 'client_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientGroups()
    {
        return $this->hasMany(ClientGroups::className(), ['client_id' => 'client_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientNumbers()
    {
        return $this->hasMany(ClientNumbers::className(), ['client_id' => 'client_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientSmsTemplates()
    {
        return $this->hasMany(ClientSmsTemplates::className(), ['client_id' => 'client_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientSubscriptions()
    {
        return $this->hasMany(ClientSubscriptions::className(), ['client_id' => 'client_id']);
    }
}
