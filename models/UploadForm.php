<?php
namespace app\models;

use yii\base\Model;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * Class UploadForm
 * @property array $filename
 */
class UploadForm extends Model
{
    /**
     * @var UploadedFile[]
     */
    public $files = [];

    public function rules()
    {
        return [
            [['files'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, doc, docx, pdf, rtf', 'maxFiles' => 4],
        ];
    }

    public function upload($invoiceId)
    {
        if ($this->validate()) {
            $path = \Yii::getAlias('@app') . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'scans' . DIRECTORY_SEPARATOR . $invoiceId . DIRECTORY_SEPARATOR;
            FileHelper::createDirectory($path);
            foreach ($this->files as $file) {
                $scan = new Scan();
                $scan->invoice_id = $invoiceId;
                $scan->filename = $file->baseName . '.' . $file->extension;
                $scan->mimetype = $file->type;
                $scan->save();
                $file->saveAs($path . $scan->id);
            }
            return true;
        } else {
            return false;
        }
    }



}