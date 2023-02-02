<?php

namespace backend\controllers;

use Yii;

use backend\models\TmpRating;
use backend\models\SearchTmpRating;
use backend\models\SearchTmpImportance;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\modules\admin\models\AuthAccessRegion;
use common\models\Services;
use common\models\ServiceUnit;
use kartik\mpdf\Pdf;

/**
 * Reports2Controller implements the CRUD actions for TmpRating model.
 */
class Reports2Controller extends Controller
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
     * Lists all TmpRating models.
     *
     * @return string
     */
    public function actionIndex($datefrom='',$dateto='',$service_unit_id,$region_id,$pstc_id=0,$driver_id=0,$clientType=0)
    {
        
        $satIndex = [
            "is_total_init" => 0, 
            "ws_total" => 0, 
            "promoters" =>  0, 
            "detractors" => 0, 
            "respondent_number" => 0, 
            "nps" => 0, 
            "satisfaction_index" => 0,
            "vss" => 0,
            "vss_score" => 0,
            "csat_score" => 0
        ];

        $comments = [];

        if ($this->request->isPost) {
            $datefrom = date_create($_POST['datefrom']);
            $dateto = date_create($_POST['dateto']);
            if($service_unit_id == 12 )$clientType = $_POST['client_type'];
            $satIndex = $this->getSatisfactionIndex(date_format($datefrom,'Y-m-d'),date_format($dateto,'Y-m-d'),$service_unit_id,$region_id,$pstc_id,$driver_id,$clientType);
            $comments = $this->getComments(date_format($datefrom,'Y-m-d'),date_format($dateto,'Y-m-d'),$service_unit_id,$region_id,$pstc_id,$driver_id,$clientType);
            //$print = $this->actionPrint(date_format($datefrom,'Y-m-d'),date_format($dateto,'Y-m-d'),$service_unit_id,$region_id,$pstc_id,$driver_id,$clientType);
        }else{
            $this->clearRatings();
        }
        
        $service_unit = ServiceUnit::find()
                        ->joinWith('services')
                        ->where(['service_unit_id' => $service_unit_id])
                        ->one();

        $searchModel = new SearchTmpRating();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $searchModel2 = new SearchTmpImportance();
        $dataProvider2 = $searchModel2->search($this->request->queryParams);
 
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'searchModel2' => $searchModel2,
            'dataProvider2' => $dataProvider2,
            'datefrom' =>  $datefrom,
            'dateto' =>  $dateto,
            'service_unit' => $service_unit,
            'satIndex' => $satIndex,
            'pstc_id' => $pstc_id,
            'clientType' => $clientType,
            'comments' => $comments
         ]);
    }
    public function actionPrint($datefrom='',$dateto='',$service_unit_id,$region_id,$pstc_id=0,$driver_id=0,$clientType=0)
    {
        
        $satIndex = [
            "is_total_init" => 0, 
            "ws_total" => 0, 
            "promoters" =>  0, 
            "detractors" => 0, 
            "respondent_number" => 0, 
            "nps" => 0, 
            "satisfaction_index" => 0,
            "vss" => 0,
            "csat_score" => 0
        ];

        $comments = [];

        if ($this->request->isGet) {
            $satIndex = $this->getSatisfactionIndex($datefrom,$dateto,$service_unit_id,$region_id,$pstc_id,$driver_id,$clientType);
            $comments = $this->getComments($datefrom,$dateto,$service_unit_id,$region_id,$pstc_id,$driver_id,$clientType);
        }else{
            $this->clearRatings();
        }
        
        $service_unit = ServiceUnit::find()
                        ->joinWith('services')
                        ->where(['service_unit_id' => $service_unit_id])
                        ->one();

        $searchModel = new SearchTmpRating();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $searchModel2 = new SearchTmpImportance();
        $dataProvider2 = $searchModel2->search($this->request->queryParams);
 
        return $this->renderAjax('_print', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'searchModel2' => $searchModel2,
            'dataProvider2' => $dataProvider2,
            'datefrom' =>  $datefrom,
            'dateto' =>  $dateto,
            'service_unit' => $service_unit,
            'satIndex' => $satIndex,
            'pstc_id' => $pstc_id,
            'clientType' => $clientType,
            'comments' => $comments
         ]);
        //  $pdf = new Pdf([
        //     // set to use core fonts only
        //     'mode' => Pdf::MODE_CORE, 
        //     // A4 paper format
        //     'format' => Pdf::FORMAT_A4, 
        //     // portrait orientation
        //     'orientation' => Pdf::ORIENT_PORTRAIT, 
        //     // stream to browser inline
        //     'destination' => Pdf::DEST_BROWSER, 
        //     // your html content input
        //     'content' => $content,  
        //     // format content from your own css file if needed or use the
        //     // enhanced bootstrap css built by Krajee for mPDF formatting 
        //     'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
        //     // any css to be embedded if required
        //     'cssInline' => '.kv-heading-1{font-size:18px}', 
        //      // set mPDF properties on the fly
        //     'options' => ['title' => 'Krajee Report Title'],
        //      // call mPDF methods on the fly
        //     'methods' => [ 
        //         'SetHeader'=>['Krajee Report Header'], 
        //         'SetFooter'=>['{PAGENO}'],
        //     ]
        // ]);
        //    // return the pdf output as per the destination setting
        //     return $pdf->render(); 
    }
    /**
     * Displays a single TmpRating model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new TmpRating model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new TmpRating();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TmpRating model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TmpRating model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TmpRating model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return TmpRating the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TmpRating::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function clearRatings(){
        $con = Yii::$app->db;
        $sql = 'DELETE FROM tbl_tmp_importance; DELETE FROM tbl_tmp_rating;';
        $delete = $con->createCommand($sql)->execute();
        return $delete;
    }
    public function  getSatisfactionIndex($datefrom,$dateto,$service_unit_id,$region_id,$pstc_id=0,$driver_id=0,$clientType=0){
        $con = Yii::$app->db;
        $sql = "CALL `sp_satisfaction_index`('$datefrom','$dateto',$service_unit_id,$region_id,$pstc_id,$driver_id,$clientType)";
        $satIndex = $con->createCommand($sql)->queryOne();
        return $satIndex;
    }
    public function getComments($datefrom,$dateto,$service_unit_id,$region_id,$pstc_id=0,$driver_id=0,$clientType=0){
        $con = Yii::$app->db;
        $sql = "CALL `sp_comments`('$datefrom','$dateto',$service_unit_id,$region_id,$pstc_id,$driver_id,$clientType)";
        $comments = $con->createCommand($sql)->queryAll();
        return $comments;
    }
    public function getRegions(){
        $user_id = Yii::$app->user->identity->id;
        if($model = AuthAccessRegion::find()->where(['user_id' =>  $user_id ])->all()){
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function findServcicesUnit($id){
        if ($model = ServiceUnit::findOne($id)){
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
