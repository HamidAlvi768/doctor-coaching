<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[StudentSessionAssignment]].
 *
 * @see StudentSessionAssignment
 */
class StudentSessionAssignmentQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return StudentSessionAssignment[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return StudentSessionAssignment|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
