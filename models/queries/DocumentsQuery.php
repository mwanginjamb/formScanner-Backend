<?php

namespace app\models\queries;

/**
 * This is the ActiveQuery class for [[\app\models\Documents]].
 *
 * @see \app\models\Documents
 */
class DocumentsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\Documents[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\Documents|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
