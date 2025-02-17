<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "comment".
 *
 * @property int $id
 * @property int $request_id
 * @property int $author_id
 * @property string $text
 * @property int $created_at
 *
 * @property Request $request
 * @property User $author
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['request_id', 'author_id', 'text', 'created_at'], 'required'],
            [['text'], 'required', 'message' => 'Комментарий не может быть пустым.'],
            [['request_id', 'author_id', 'created_at'], 'integer'],
            [['text'], 'string'],
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
            'author_id' => 'Автор',
            'text' => 'Текст',
            'created_at' => 'Дата создания',
        ];
    }

    /**
     * Связь с моделью Request
     */
    public function getRequest()
    {
        return $this->hasOne(Request::class, ['id' => 'request_id']);
    }

    /**
     * Связь с моделью User (автор комментария)
     */
    public function getAuthor()
    {
        return $this->hasOne(User::class, ['id' => 'author_id']);
    }
}