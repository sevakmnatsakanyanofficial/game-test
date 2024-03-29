<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Task]].
 *
 * @see Task
 */
class TaskQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere('[[status]]=:status', [':status' => Task::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     * @return Task[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Task|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
