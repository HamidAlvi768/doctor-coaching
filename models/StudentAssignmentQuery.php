<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[StudentAssignment]].
 *
 * @see StudentAssignment
 */
class StudentAssignmentQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return StudentAssignment[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return StudentAssignment|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
