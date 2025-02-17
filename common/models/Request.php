<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * Модель заявки
 *
 * @property int $id
 * @property string $train_number Номер поезда
 * @property string|null $carriage_number Номер вагона
 * @property string|null $node Узел
 * @property string $defect_short Краткое описание дефекта
 * @property string|null $defect_full Полное описание дефекта
 * @property string|null $photo Фото дефекта
 * @property string $urgency Уровень срочности
 * @property int $created_at Дата создания
 * @property int $deadline Срок закрытия
 * @property string $status Статус заявки
 * @property int $responsible_id Ответственный
 * @property string|null $qr_code QR-код
 */
class Request extends ActiveRecord
{
    const STATUS_CREATED = 'Создано';
    const STATUS_ASSIGNED = 'Назначено';
    const STATUS_IN_PROGRESS = 'В работе';
    const STATUS_ON_CHECK = 'На проверке';
    const STATUS_CLOSED = 'Закрыто';

    const URGENCY_EMERGENCY = 'Аварийная';
    const URGENCY_URGENT = 'Срочная';
    const URGENCY_PLANNED = 'Плановая';

    /**
     * @var UploadedFile
     */
    public $photoFile;

    public static function tableName()
    {
        return '{{%request}}';
    }

	public function behaviors()
	{
		return [
			[
				'class' => TimestampBehavior::class,
				'attributes' => [
					ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'], // Только created_at
				],
				// Если используете MySQL, можно указать значение по умолчанию
				'value' => function () {
					return date('Y-m-d H:i:s'); // Формат для MySQL
				},
			],
		];
	}

    public static function getStatusOptions()
    {
        return [
            'Создано' => 'Создано',
            'Назначено' => 'Назначено',
            'В работе' => 'В работе',
            'На проверке' => 'На проверке',
            'Требуется канава' => 'Требуется канава',
            'Закрыто' => 'Закрыто',
            'Донор' => 'Донор',
            'Ожидается поставка' => 'Ожидается поставка',
        ];
    }

    public function rules()
    {
        return [
			[['photoFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'maxSize' => 10 * 1024 * 1024, 'checkExtensionByMimeType' => false],
            [['train_number', 'defect_short', 'urgency'], 'required'],
            [['defect_full'], 'string'],
            [['created_at', 'deadline', 'responsible_id'], 'integer'],
            [['train_number', 'carriage_number', 'node'], 'string', 'max' => 50],
            [['defect_short'], 'string', 'max' => 100],
            [['defect_full'], 'string', 'max' => 1000],
            [['photo', 'qr_code'], 'string', 'max' => 255],
            [['urgency'], 'in', 'range' => [self::URGENCY_EMERGENCY, self::URGENCY_URGENT, self::URGENCY_PLANNED]],
            [['status'], 'default', 'value' => self::STATUS_CREATED],
            [['photoFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'maxSize' => 10 * 1024 * 1024],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'train_number' => 'Номер поезда',
            'carriage_number' => 'Номер вагона',
            'node' => 'Узел',
            'defect_short' => 'Краткое описание дефекта',
            'defect_full' => 'Полное описание дефекта',
            'photo' => 'Фото дефекта',
            'urgency' => 'Уровень срочности',
            'created_at' => 'Дата создания',
            'deadline' => 'Срок закрытия',
            'status' => 'Статус',
            'responsible_id' => 'Ответственный',
            'qr_code' => 'QR-код',
            'photoFile' => 'Фото дефекта',
        ];
    }

	public function beforeSave($insert)
	{
		if (parent::beforeSave($insert)) {
			// Устанавливаем текущее время для created_at
			if ($this->isNewRecord) {
				$this->created_at = time();
			}

			// Устанавливаем deadline (по умолчанию +12 часов от текущего времени)
			if (empty($this->deadline)) {
				$this->deadline = strtotime('+12 hours');
			}

			return true;
		}
		return false;
	}


	public function upload()
	{
		// Проверяем, загружен ли файл
		if ($this->photoFile === null) {
			return true; // Файл не загружен, но это не ошибка
		}

		// Проверяем, существует ли временный файл
		if (!file_exists($this->photoFile->tempName)) {
			Yii::error('Временный файл не найден: ' . $this->photoFile->tempName);
			return false;
		}
		
		Yii::info('Временный файл: ' . $this->photoFile->tempName);

		// Создаем папку uploads, если её нет
		$uploadPath = Yii::getAlias('@frontend/web/uploads');
		if (!is_dir($uploadPath)) {
			mkdir($uploadPath, 0777, true);
		}

		// Генерируем уникальное имя файла
		$fileName = uniqid() . '.' . $this->photoFile->extension;
		$fullPath = $uploadPath . DIRECTORY_SEPARATOR . $fileName;

		// Сохраняем файл
		if ($this->photoFile->saveAs($fullPath)) {
			$this->photo = '/uploads/' . $fileName; // Сохраняем относительный путь
			return true;
		}

		Yii::error("Не удалось сохранить файл: {$fullPath}");
		return false;
	}

	public function getResponsible()
    {
        return $this->hasOne(User::class, ['id' => 'responsible_id']);
    }

    public function generateQrCode()
    {
        $this->qr_code = 'qr_' . $this->id . '_' . time() . '.png';
        // Логика генерации QR-кода (например, с использованием библиотеки `endroid/qr-code`)
        return true;
    }

	public function getStatusHistory()
	{
    return $this->hasMany(StatusHistory::class, ['request_id' => 'id'])
        ->orderBy(['created_at' => SORT_DESC]);
	}

	public function getComments()
    {
        return $this->hasMany(Comment::class, ['request_id' => 'id']);
    }
}