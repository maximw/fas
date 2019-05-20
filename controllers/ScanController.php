<?php

namespace app\controllers;

use app\helpers\InvoiceFileStoreHelper;
use app\helpers\RbacHelper;
use app\models\User;
use Yii;
use app\models\Scan;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ScanController implements the CRUD actions for Scan model.
 */
class ScanController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['view'],
                        'allow' => true,
                        'roles' => [RbacHelper::PERMISSION_VIEW],
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => [RbacHelper::PERMISSION_DELETE],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Displays a single Scan model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        if (!$model || !file_exists(InvoiceFileStoreHelper::scanPath($model))) {
            throw new NotFoundHttpException('File not found.');
        }

        return Yii::$app->response->sendFile(InvoiceFileStoreHelper::scanPath($model), $model->filename, ['mimeType' => $model->mimetype]);
    }

    /**
     * Deletes an existing Scan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();
        return $this->redirect(['invoice/update', 'id' => $model->invoice_id]);
    }

    /**
     * Finds the Scan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Scan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Scan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
