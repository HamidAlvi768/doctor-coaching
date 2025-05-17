<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[QuizTimeLog]].
 *
 * @see QuizTimeLog
 */
class QuizTimeLogQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return QuizTimeLog[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return QuizTimeLog|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
