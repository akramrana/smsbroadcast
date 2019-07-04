<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "client_numbers".
 *
 * @property int $client_number_id
 * @property int $client_id
 * @property string $name
 * @property string $number
 * @property string $created_at
 *
 * @property ClientCampaignNumbers[] $clientCampaignNumbers
 * @property ClientGroupNumbers[] $clientGroupNumbers
 * @property Clients $client
 */
class ClientNumbers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'client_numbers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client_number_id', 'client_id', 'number', 'created_at'], 'required'],
            [['client_number_id', 'client_id'], 'integer'],
            [['created_at'], 'safe'],
            [['name'], 'string', 'max' => 48],
            [['number'], 'string', 'max' => 32],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Clients::className(), 'targetAttribute' => ['client_id' => 'client_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'client_number_id' => 'Client Number ID',
            'client_id' => 'Client ID',
            'name' => 'Name',
            'number' => 'Number',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientCampaignNumbers()
    {
        return $this->hasMany(ClientCampaignNumbers::className(), ['client_number_id' => 'client_number_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientGroupNumbers()
    {
        return $this->hasMany(ClientGroupNumbers::className(), ['client_number_id' => 'client_number_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Clients::className(), ['client_id' => 'client_id']);
    }
}
