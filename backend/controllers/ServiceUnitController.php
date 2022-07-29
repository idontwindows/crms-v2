<?php

namespace backend\controllers;

use common\models\ServiceUnit;
use common\models\Pstc;
use backend\models\ServiceUnitSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use Yii;
/**
 * ServiceUnitController implements the CRUD actions for ServiceUnit model.
 */
class ServiceUnitController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all ServiceUnit models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ServiceUnitSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $region_id = Yii::$app->user->identity->region_id;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'region_id' => $region_id
        ]);
    }

    /**
     * Displays a single ServiceUnit model.
     * @param int $service_unit_id Service Unit ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($service_unit_id)
    {
        $region_id = Yii::$app->user->identity->region_id;
        $model = $this->findModel($service_unit_id);
        return $this->renderAjax('view', [
            'model' => $model,
            'region_id' => $region_id
        ]);
    }

    /**
     * Creates a new ServiceUnit model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new ServiceUnit();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'service_unit_id' => $model->service_unit_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ServiceUnit model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $service_unit_id Service Unit ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($service_unit_id)
    {
        $model = $this->findModel($service_unit_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'service_unit_id' => $model->service_unit_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ServiceUnit model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $service_unit_id Service Unit ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($service_unit_id)
    {
        $this->findModel($service_unit_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ServiceUnit model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $service_unit_id Service Unit ID
     * @return ServiceUnit the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($service_unit_id)
    {
        if (($model = ServiceUnit::findOne(['service_unit_id' => $service_unit_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionSubUnit($service_unit_id){
        $region_id = Yii::$app->user->identity->region_id;
        $query = ServiceUnit::find()->where(['is_child' => 1,'parent_id' => $service_unit_id]);
        $model = $this->findModel($service_unit_id);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false
        ]);
        return $this->render('sub_units',['dataProvider'=>$dataProvider,'model'=>$model,'region_id' => $region_id]);
    }
    public function actionPstc($service_unit_id){
        $region_id = Yii::$app->user->identity->region_id;
        $query = Pstc::find()->where(['region_id' => $region_id]);
        $serviceunit = ServiceUnit::find()->where(['is_child' => 1,'parent_id' => $service_unit_id]);
        $model = $this->findModel($service_unit_id);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false
        ]);
        return $this->render('pstc',['dataProvider' => $dataProvider,'model' => $model, 'region_id' => $region_id]);
    }
    public function actionDownloadQrcode($id,$region_id,$name,$pstc_id=0)
    {
        $model = $this->findModel($id);
        
        if($model->is_with_pstc == true) $file = '../../web/administrator/qr-code/' . $name . '_' . $region_id . '_'. $pstc_id .'_code.png';
        if($model->is_with_pstc == false) $file = '../../web/administrator/qr-code/' . $name . '_' . $region_id . '_code.png';
        
        
        $date = date('d-m-y-' . substr((string)microtime(), 1, 8));
        $date = str_replace(".", "", $date);
        $filename = $date . '_QR-Code.png';
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            readfile($file);
            exit;
        }
    }

}
