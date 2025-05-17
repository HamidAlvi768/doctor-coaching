<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Reattempts]].
 *
 * @see Reattempts
 */
class ReattemptsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Reattempts[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Reattempts|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
