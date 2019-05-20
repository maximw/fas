<?php

namespace app\models;

use app\helpers\InvoiceFileStoreHelper;
use Yii;
use yii\helpers\FileHelper;

/**
 * This is the model class for table "scan".
 *
 * @property int $id
 * @property int $invoice_id
 * @property string $filename
 * @property string $mimetype
 * @property Invoice $invoice
 */
class Scan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'scan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['invoice_id', 'filename', 'mimetype'], 'required'],
            [['invoice_id'], 'integer'],
            [['filename'], 'string', 'max' => 100],
            [['mimetype'], 'string', 'max' => 32],
            [['invoice_id'], 'exist', 'skipOnError' => true, 'targetClass' => Invoice::className(), 'targetAttribute' => ['invoice_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'invoice_id' => 'Invoice ID',
            'filename' => 'Filename',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoice()
    {
        return $this->hasOne(Invoice::className(), ['id' => 'invoice_id']);
    }

     public function beforeDelete()
     {
         FileHelper::unlink(InvoiceFileStoreHelper::scanPath($this));
         return parent::beforeDelete();
     }


}
