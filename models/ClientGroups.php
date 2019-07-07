<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "client_groups".
 *
 * @property int $client_group_id
 * @property int $client_id
 * @property string $group_name
 * @property int $is_active
 * @property int $is_deleted
 * @property string $created_at
 * @property string $updated_at
 *
 * @property ClientGroupNumbers[] $clientGroupNumbers
 * @property Clients $client
 */
class ClientGroups extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'client_groups';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client_id', 'group_name', 'is_deleted', 'created_at', 'updated_at'], 'required'],
            [['client_id', 'is_active', 'is_deleted'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['group_name'], 'string', 'max' => 32],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Clients::className(), 'targetAttribute' => ['client_id' => 'client_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'client_group_id' => 'Client Group ID',
            'client_id' => 'Client',
            'group_name' => 'Group Name',
            'is_active' => 'Is Active',
            'is_deleted' => 'Is Deleted',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientGroupNumbers()
    {
        return $this->hasMany(ClientGroupNumbers::className(), ['client_group_id' => 'client_group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Clients::className(), ['client_id' => 'client_id']);
    }
}
