<?php

namespace app\models\queries;

/**
 * This is the ActiveQuery class for [[\app\models\DocumentLine]].
 *
 * @see \app\models\DocumentLine
 */
class DocumentLineQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\DocumentLine[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\DocumentLine|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
