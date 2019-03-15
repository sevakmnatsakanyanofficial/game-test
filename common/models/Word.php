<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%word}}".
 *
 * @property int $id
 * @property int $task_id
 * @property int $number
 * @property string $text
 *
 * @property Task $task
 */
class Word extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%word}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['task_id', 'number', 'text'], 'required'],
            [['task_id', 'number'], 'integer'],
            [['text'], 'string', 'max' => 255],
            [['number'], 'unique'],
            ['text', 'match', 'pattern' => '/^[a-zа-я\-\.\!\?]{1,}$/iu'],
            ['text', 'match', 'pattern' => '/[a-zа-я]{1,}/iu'],
            ['text', 'match', 'pattern' => '/^\-|\-$/iu', 'not' => true],
            ['text', 'match', 'pattern' => '/\-{2,}/iu', 'not' => true],
            ['text', 'match', 'pattern' => '/^[\-\.\!\?]/iu', 'not' => true],
            ['text', 'match', 'pattern' => '/\.(?=\?|\!)/iu', 'not' => true],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::className(), 'targetAttribute' => ['task_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'task_id' => 'Task ID',
            'number' => 'Number',
            'text' => 'Text',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Task::className(), ['id' => 'task_id']);
    }

    /**
     * {@inheritdoc}
     * @return WordQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new WordQuery(get_called_class());
    }

    /**
     * Generates number key
     */
    public function generateNumber()
    {
        $number = rand();
        if (self::findOne(['number' => $number])) {
            $this->generateNumber();
        } else {
            $this->number = $number;
        }
    }
}
