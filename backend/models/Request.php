<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "request".
 *
 * @property int $id
 * @property string $train_number
 * @property string|null $status
 * @property string|null $created_at
 */
class Request extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    public $urgency 

    public static function tableName()
    {
        return 'request';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['train_number', 'defect_short', 'status', 'urgency'], 'required'],
            [['created_at'], 'safe'],
            [['train_number', 'status'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'urgency' => 'Уровень срочности',
            'id' => 'ID',
            'train_number' => 'Train Number',
            'status' => 'Status',
            'created_at' => 'Created At',
        ];
    }
}
