<?php

namespace app\helpers;

use \app\models\Invoice;
use \app\models\Scan;


class InvoiceFileStoreHelper
{

    public static function invoiceDir(Invoice $invoice)
    {
        return static::getInvoiceDir($invoice->id);
    }

    public static function scanPath(Scan $scan)
    {
        return static::getScanPath($scan->invoice_id, $scan->id);
    }

    protected static function getInvoiceDir($invoiceId)
    {
        return static::getBasePath()
            . DIRECTORY_SEPARATOR
            . $invoiceId;
    }

    protected static function getScanPath($invoiceId, $scanId)
    {
        return static::getInvoiceDir($invoiceId)
            . DIRECTORY_SEPARATOR
            . $scanId;
    }

    protected static function getBasePath()
    {
        return \Yii::getAlias('@app')
            . DIRECTORY_SEPARATOR
            . \Yii::$app->params['scanUploadPath'];
    }


}
