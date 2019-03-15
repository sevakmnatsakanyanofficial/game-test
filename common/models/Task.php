<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%task}}".
 *
 * @property int $id
 * @property string $sentence
 * @property integer $status
 *
 * @property Word[] $words
 */
class Task extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%task}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sentence'], 'required'],
            [['sentence'], 'string', 'max' => 255],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sentence' => 'Sentence',
            'status' => 'Status'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWords()
    {
        return $this->hasMany(Word::className(), ['task_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return TaskQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TaskQuery(get_called_class());
    }

    /**
     * It is soft delete case and return deleted model id
     * @return false|int|null
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function delete()
    {
        $this->status = self::STATUS_DELETED;
        if (!$this->update()) {
            return null;
        }
        return $this->id;
    }

    public static function generateSentences($text)
    {
        return preg_split('/(?<=[.?!])\s+(?=[a-zа-я])/iu', $text);
    }

    public static function generateWords($sentence)
    {
        return preg_split('/[ ,\-\:;]/', $sentence);
    }
}
