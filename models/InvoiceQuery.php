<?php


namespace app\models;


use yii\db\ActiveQuery;

class InvoiceQuery extends ActiveQuery
{

    public function expired()
    {
        //return $this->where(['paid' => 0, 'expiration_date' => ['<' => date('Y-m-d')] ]);
        return $this->where(['paid' => 0])
                    ->andWhere(['<', 'expiration_date', date('Y-m-d')]);
    }

}