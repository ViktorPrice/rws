<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "status_history".
 *
 * @property int $id
 * @property int $request_id
 * @property string $status
 * @property string|null $comment
 * @property string $created_at
 *
 * @property Request $request
 */
class StatusHistory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'status_history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['request_id', 'status', 'created_at'], 'required'],
            [['request_id'], 'integer'],
            [['comment'], 'string'],
            [['created_at'], 'safe'],
            [['status'], 'string', 'max' => 255],
            [['request_id'], 'exist', 'skipOnError' => true, 'targetClass' => Request::class, 'targetAttribute' => ['request_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'request_id' => 'Заявка',
            'status' => 'Статус',
            'comment' => 'Комментарий',
            'created_at' => 'Дата изменения',
        ];
    }

    /**
     * Связь с моделью Request (заявка)
     */
    public function getRequest()
    {
        return $this->hasOne(Request::class, ['id' => 'request_id']);
    }

    /**
     * Перед сохранением модели
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->created_at = date('Y-m-d H:i:s');
            }
            return true;
        }
        return false;
    }
}