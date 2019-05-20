<?php

namespace app\models;

use app\helpers\InvoiceFileStoreHelper;
use Yii;
use yii\helpers\FileHelper;

/**
 * This is the model class for table "invoice".
 *
 * @property int $id
 * @property string $create_date
 * @property string $expiration_date
 * @property string $sum
 * @property string $details
 * @property string $comment
 */
class Invoice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'invoice';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            //[['create_date', 'expiration_date', 'sum', 'details'], 'required'],
            //[['create_date', 'expiration_date'], 'safe'],
            [['sum', 'paid'], 'number'],
            [['create_date', 'expiration_date', 'details', 'comment'], 'string'],
            [['comment'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'create_date' => 'Create Date',
            'expiration_date' => 'Expiration Date',
            'sum' => 'Sum',
            'details' => 'Details',
            'comment' => 'Comment',
            'paid' => 'Paid'
        ];
    }


    public function getScans()
    {
        return $this->hasMany(Scan::className(), ['invoice_id' => 'id']);
    }

    public static function find()
    {
        return new InvoiceQuery(get_called_class());
    }

     public function beforeDelete()
     {
         FileHelper::removeDirectory(InvoiceFileStoreHelper::invoiceDir($this));
         Scan::deleteAll(['invoice_id' => $this->id]);
         return parent::beforeDelete();
     }

}
