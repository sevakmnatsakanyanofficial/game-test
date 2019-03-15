<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%result}}".
 *
 * @property int $id
 * @property int $user_id
 * @property int $win
 * @property int $lose
 *
 * @property User $user
 */
class Result extends \yii\db\ActiveRecord
{
    const IS_WIN = 1;
    const IS_LOSE = 1;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%result}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'win', 'lose'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'win' => 'Win',
            'lose' => 'Lose',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return ResultQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ResultQuery(get_called_class());
    }
}
