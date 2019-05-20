<?php

namespace app\controllers;

use app\helpers\RbacHelper;
use app\models\UploadForm;
use app\models\User;
use Yii;
use app\models\Invoice;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * InvoiceController implements the CRUD actions for Invoice model.
 */
class InvoiceController extends Controller
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
                        'actions' => ['index', 'view', 'unpaid'],
                        'allow' => true,
                        'roles' => [RbacHelper::PERMISSION_VIEW],
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => [RbacHelper::PERMISSION_CREATE],
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => [RbacHelper::PERMISSION_UPDATE],
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
     * Lists all Invoice models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Invoice::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Invoice models.
     * @return mixed
     */
    public function actionUnpaid()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Invoice::find()->expired(false),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Invoice model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Invoice model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Invoice();
        $uploadModel = new UploadForm();

        if (Yii::$app->request->isPost) {
            if ($this->saveInvoice($model, $uploadModel)) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'uploadModel' => $uploadModel,
        ]);
    }

    /**
     * Updates an existing Invoice model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $uploadModel = new UploadForm();

        if (Yii::$app->request->isPost) {
            if ($this->saveInvoice($model, $uploadModel)) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'uploadModel' => $uploadModel,
        ]);
    }

    /**
     * Deletes an existing Invoice model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Deletes an existing Invoice model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpload($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Invoice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Invoice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Invoice::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function saveInvoice($model, $uploadModel)
    {
        $uploadModel->files = UploadedFile::getInstances($uploadModel, 'files');
        if (!empty($uploadModel->files) && RbacHelper::can(RbacHelper::PERMISSION_CREATE)) {
            throw new ForbiddenHttpException();
        }
        $model->load(Yii::$app->request->post(), 'Invoice');
        $model->save();
        $uploadModel->upload($model->id);
        //TODO $successFlag
        return true;

    }
}
