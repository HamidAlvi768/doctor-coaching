<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Stream]].
 *
 * @see Stream
 */
class StreamQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Stream[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Stream|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
