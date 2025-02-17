<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "settings".
 *
 * @property int $id
 * @property string $key
 * @property string|null $value
 * @property string|null $defect_short
 * @property int $created_at
 * @property int $updated_at
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
            [['key', 'created_at', 'updated_at'], 'required'],
            [['value'], 'string'],
            [['created_at', 'updated_at'], 'integer'],
            [['key'], 'string', 'max' => 50],
            [['defect_short'], 'string', 'max' => 255],
            [['key'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'key' => 'Key',
            'value' => 'Value',
            'defect_short' => 'defect_short',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
	
	public static function getValue($key)
{
    $model = static::find()->where(['key' => $key])->one();
    return $model ? $model->value : null;
}

public static function updateSetting($key, $value)
{
    $model = static::find()->where(['key' => $key])->one();
    if (!$model) {
        $model = new static();
        $model->key = $key;
    }
    $model->value = $value;
    $model->updated_at = time();
    return $model->save();
}
}
