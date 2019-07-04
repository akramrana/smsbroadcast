<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "client_campaigns".
 *
 * @property int $client_campaign_id
 * @property int $client_id
 * @property string $campaign_name
 * @property string $from_number
 * @property string $message
 * @property int $character_count
 * @property string $created_at
 * @property string $campaign_type
 *
 * @property ClientCampaignNumbers[] $clientCampaignNumbers
 * @property ClientCampaignResponses[] $clientCampaignResponses
 * @property Clients $client
 */
class ClientCampaigns extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'client_campaigns';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client_id', 'campaign_name', 'from_number', 'message', 'character_count', 'created_at', 'campaign_type'], 'required'],
            [['client_id', 'character_count'], 'integer'],
            [['message'], 'string'],
            [['created_at'], 'safe'],
            [['campaign_name', 'from_number', 'campaign_type'], 'string', 'max' => 32],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Clients::className(), 'targetAttribute' => ['client_id' => 'client_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'client_campaign_id' => 'Client Campaign ID',
            'client_id' => 'Client',
            'campaign_name' => 'Campaign Name',
            'from_number' => 'From Number',
            'message' => 'Message',
            'character_count' => 'Character Count',
            'created_at' => 'Created At',
            'campaign_type' => 'Campaign Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientCampaignNumbers()
    {
        return $this->hasMany(ClientCampaignNumbers::className(), ['client_campaign_id' => 'client_campaign_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientCampaignResponses()
    {
        return $this->hasMany(ClientCampaignResponses::className(), ['client_campaign_id' => 'client_campaign_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Clients::className(), ['client_id' => 'client_id']);
    }
}
