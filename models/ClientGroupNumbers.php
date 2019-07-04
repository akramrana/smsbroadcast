<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "client_group_numbers".
 *
 * @property int $client_group_number_id
 * @property int $client_group_id
 * @property int $client_number_id
 *
 * @property ClientNumbers $clientNumber
 * @property ClientGroups $clientGroup
 */
class ClientGroupNumbers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'client_group_numbers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client_group_id', 'client_number_id'], 'required'],
            [['client_group_id', 'client_number_id'], 'integer'],
            [['client_number_id'], 'exist', 'skipOnError' => true, 'targetClass' => ClientNumbers::className(), 'targetAttribute' => ['client_number_id' => 'client_number_id']],
            [['client_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => ClientGroups::className(), 'targetAttribute' => ['client_group_id' => 'client_group_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'client_group_number_id' => 'Client Group Number ID',
            'client_group_id' => 'Client Group ID',
            'client_number_id' => 'Client Number ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientNumber()
    {
        return $this->hasOne(ClientNumbers::className(), ['client_number_id' => 'client_number_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientGroup()
    {
        return $this->hasOne(ClientGroups::className(), ['client_group_id' => 'client_group_id']);
    }
}
