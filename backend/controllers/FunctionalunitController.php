<?php

namespace backend\controllers;

use Attribute;
use common\models\Functionalunit;
use common\models\UnitServices;
use backend\models\Functionalunit\FunctionalunitSearch;
use common\models\QuestionGroupUnit as AttributeGroup;
use common\models\QuestionUnit;
use common\models\Attributes;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

use function Matrix\identity;

/**
 * FuntionalunitController implements the CRUD actions for Functionalunit model.
 */
class FunctionalunitController extends Controller
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
     * Lists all Functionalunit models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new FunctionalunitSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
       

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Functionalunit model.
     * @param int $functional_unit_id Functional Unit ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($unit_id)
    {
        $attributes = Attributes::find()->where(['unit_id' => $unit_id])->orderBy('dimension_id');
        $dataProvider = new ActiveDataProvider([
            'query' => $attributes,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $this->render('view', [
            'model' => $this->findModel($unit_id),
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Creates a new Functionalunit model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Functionalunit();
        $servicesDataArray = UnitServices::find()->all();

        $attributesGroupId = $this->getAttributeId();
        $UnitId = $this->getUnitId();

        if ($this->request->isPost) {

            $services_id = $_POST['Functionalunit']['services_id'];
            $services = UnitServices::find()->where(['services_id' => $services_id])->one();

            $model->unit_id = $UnitId;
            $model->services_id = $services_id;
            $model->unit_name = $services->services_name;
            $model->region_id = Yii::$app->user->identity->region_id;
            $model->unit_url = '/csf/' . base64_encode(base64_encode($UnitId));
            $model->save();
            
            // $attributesGroup = new AttributeGroup();
            // $attributesGroup->question_group_unit_id = $attributesGroupId;
            // $attributesGroup->question_group_unit_name = 'HOW WOULD YOU RATE OUR SERVICES?';
            // $attributesGroup->unit_id= $UnitId;
            // $attributesGroup->save(false);

            if(!empty($_POST['attrib1'])){
                $attributeQuestion1 = new Attributes();
                $attributeQuestion1->question = $_POST['attrib1'];
                $attributeQuestion1->dimension_id = 1;
                if (!isset($_POST['check-1'])) $attributeQuestion1->no_dimension = false;
                if (isset($_POST['check-1'])) $attributeQuestion1->no_dimension = true;
                $attributeQuestion1->unit_id = $UnitId;
                $attributeQuestion1->save(false);
            }
            if(!empty($_POST['attrib2'])){
                $attributeQuestion2 = new Attributes();
                $attributeQuestion2->question = $_POST['attrib2'];
                $attributeQuestion2->dimension_id = 2;
                if (!isset($_POST['check-2'])) $attributeQuestion2->no_dimension = false;
                if (isset($_POST['check-2'])) $attributeQuestion2->no_dimension = true;
                $attributeQuestion2->unit_id = $UnitId;
                $attributeQuestion2->save(false);
            }
            if(!empty($_POST['attrib3'])){
                $attributeQuestion3 = new Attributes();
                $attributeQuestion3->question = $_POST['attrib3'];
                $attributeQuestion3->dimension_id = 3;
                if (!isset($_POST['check-3'])) $attributeQuestion3->no_dimension = false;
                if (isset($_POST['check-3'])) $attributeQuestion3->no_dimension = true;
                $attributeQuestion3->unit_id = $UnitId;
                $attributeQuestion3->save(false);
            }
            if(!empty($_POST['attrib4'])){
                $attributeQuestion4 = new Attributes();
                $attributeQuestion4->question = $_POST['attrib4'];
                $attributeQuestion4->dimension_id = 4;
                if (!isset($_POST['check-4'])) $attributeQuestion4->no_dimension = false;
                if (isset($_POST['check-4'])) $attributeQuestion4->no_dimension = true;
                $attributeQuestion4->unit_id = $UnitId;
                $attributeQuestion4->save(false);
            }
            if(!empty($_POST['attrib5'])){
                $attributeQuestion5 = new Attributes();
                $attributeQuestion5->question = $_POST['attrib5'];
                $attributeQuestion5->dimension_id = 5;
                if (!isset($_POST['check-5'])) $attributeQuestion5->no_dimension = false;
                if (isset($_POST['check-5'])) $attributeQuestion5->no_dimension = true;
                $attributeQuestion5->unit_id = $UnitId;
                $attributeQuestion5->save(false);
            }
            if(!empty($_POST['attrib6'])){
                $attributeQuestion6 = new Attributes();
                $attributeQuestion6->question = $_POST['attrib6'];
                $attributeQuestion6->dimension_id = 6;
                if (!isset($_POST['check-6'])) $attributeQuestion6->no_dimension = false;
                if (isset($_POST['check-6'])) $attributeQuestion6->no_dimension = true;
                $attributeQuestion6->unit_id = $UnitId;
                $attributeQuestion6->save(false);
            }
            if(!empty($_POST['attrib7'])){
                $attributeQuestion7 = new Attributes();
                $attributeQuestion7->question = $_POST['attrib7'];
                $attributeQuestion7->dimension_id = 7;
                if (!isset($_POST['check-7'])) $attributeQuestion7->no_dimension = false;
                if (isset($_POST['check-7'])) $attributeQuestion7->no_dimension = true;
                $attributeQuestion7->unit_id = $UnitId;
                $attributeQuestion7->save(false);
            }
            if(!empty($_POST['attrib8'])){
                $attributeQuestion8 = new Attributes();
                $attributeQuestion8->question = $_POST['attrib8'];
                $attributeQuestion8->dimension_id = 8;
                if (!isset($_POST['check-8'])) $attributeQuestion8->no_dimension = false;
                if (isset($_POST['check-8'])) $attributeQuestion8->no_dimension = true;
                $attributeQuestion8->unit_id = $UnitId;
                $attributeQuestion8->save(false);
            }
            return $this->redirect(['view', 'unit_id' => $model->unit_id]);
            
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'servicesDataArray' => $servicesDataArray,
            'update' => false
        ]);
    }

    /**
     * Updates an existing Functionalunit model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $functional_unit_id Functional Unit ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($functional_unit_id)
    {
        
       
        $model = $this->findModel($functional_unit_id);
        
            
    
        // $attributes1 = AttributeGroup::find()->joinWith('attributequestions as a')
        //     ->select(['attribute_group_id' => 'tbl_question_group_unit.question_group_unit_id', 'question_id' => 'a.question_unit_id', 'question' => 'a.question', 'no_dimension' => 'a.no_dimension'])
        //     ->andWhere(['a.dimension_id' => 1])
        //     ->andWhere(['tbl_question_group_unit.unit_id' => $_GET['functional_unit_id']])
        //     ->andWhere(['tbl_question_group_unit.importance' => 0])
        //     ->one();
        $attributes1 = Attributes::find()
                        ->where(['dimension_id' => 1,'unit_id' => $_GET['functional_unit_id']])
                        ->one();
        $attributes2 = Attributes::find()
                        ->where(['dimension_id' => 2,'unit_id' => $_GET['functional_unit_id']])
                        ->one();
        $attributes3 = Attributes::find()
                        ->where(['dimension_id' => 3,'unit_id' => $_GET['functional_unit_id']])
                        ->one();
        $attributes4 = Attributes::find()
                        ->where(['dimension_id' => 4,'unit_id' => $_GET['functional_unit_id']])
                        ->one();
        $attributes5 = Attributes::find()
                        ->where(['dimension_id' => 5,'unit_id' => $_GET['functional_unit_id']])
                        ->one();
        $attributes6 = Attributes::find()
                        ->where(['dimension_id' => 6,'unit_id' => $_GET['functional_unit_id']])
                        ->one();
        $attributes7 = Attributes::find()
                        ->where(['dimension_id' => 7,'unit_id' => $_GET['functional_unit_id']])
                        ->one();
        $attributes8 = Attributes::find()
                        ->where(['dimension_id' => 8,'unit_id' => $_GET['functional_unit_id']])
                        ->one();

        $servicesDataArray = UnitServices::find()->all();

        // if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
        if ($this->request->isPost) {
            $attributeQuestion1 = Attributes::find()->where(['attribute_id' => $_POST['question-id-1']])->one();
            $attributeQuestion2 = Attributes::find()->where(['attribute_id' => $_POST['question-id-2']])->one();
            $attributeQuestion3 = Attributes::find()->where(['attribute_id' => $_POST['question-id-3']])->one();
            $attributeQuestion4 = Attributes::find()->where(['attribute_id' => $_POST['question-id-4']])->one();
            $attributeQuestion5 = Attributes::find()->where(['attribute_id' => $_POST['question-id-5']])->one();
            $attributeQuestion6 = Attributes::find()->where(['attribute_id' => $_POST['question-id-6']])->one();
            $attributeQuestion7 = Attributes::find()->where(['attribute_id' => $_POST['question-id-7']])->one();
            $attributeQuestion8 = Attributes::find()->where(['attribute_id' => $_POST['question-id-8']])->one();
            if ($attributes1) {
                if(!empty($_POST['attrib1'])){
                    $attributeQuestion1->question = $_POST['attrib1'];
                    if (!isset($_POST['check-1'])) $attributeQuestion1->no_dimension = false;
                    if (isset($_POST['check-1'])) $attributeQuestion1->no_dimension = true;
                    $attributeQuestion1->save(false);
                }else{
                    $attributeQuestion1->delete();  
                }
            } else {
                if(!empty($_POST['attrib1'])){
                    $attributeQuestion1 = new Attributes();
                    $attributeQuestion1->question = $_POST['attrib1'];
                    $attributeQuestion1->unit_id = $functional_unit_id;
                    $attributeQuestion1->dimension_id = 1;
                    if (!isset($_POST['check-1'])) $attributeQuestion1->no_dimension = false;
                    if (isset($_POST['check-1'])) $attributeQuestion1->no_dimension = true;
                    $attributeQuestion1->save(false);
                }
            }
            if ($attributes2) {
                if(!empty($_POST['attrib2'])){
                    $attributeQuestion2->question = $_POST['attrib2'];
                    if (!isset($_POST['check-2'])) $attributeQuestion2->no_dimension = false;
                    if (isset($_POST['check-2'])) $attributeQuestion2->no_dimension = true;
                    $attributeQuestion2->save(false);
                }else{
                    $attributeQuestion2->delete();  
                }
            } else {
                if(!empty($_POST['attrib2'])){
                    $attributeQuestion2 = new Attributes();
                    $attributeQuestion2->question = $_POST['attrib2'];
                    $attributeQuestion2->unit_id = $functional_unit_id;
                    $attributeQuestion2->dimension_id = 2;
                    if (!isset($_POST['check-2'])) $attributeQuestion2->no_dimension = false;
                    if (isset($_POST['check-2'])) $attributeQuestion2->no_dimension = true;
                    $attributeQuestion2->save(false);
                }
            }
            if ($attributes3) {
                if(!empty($_POST['attrib3'])){
                    $attributeQuestion3->question = $_POST['attrib3'];
                    if (!isset($_POST['check-3'])) $attributeQuestion3->no_dimension = false;
                    if (isset($_POST['check-3'])) $attributeQuestion3->no_dimension = true;
                    $attributeQuestion3->save(false);
                }else{
                    $attributeQuestion3->delete();  
                }
            } else {
                if(!empty($_POST['attrib3'])){
                    $attributeQuestion3 = new Attributes();
                    $attributeQuestion3->question = $_POST['attrib3'];
                    $attributeQuestion3->unit_id = $functional_unit_id;
                    $attributeQuestion3->dimension_id = 3;
                    if (!isset($_POST['check-3'])) $attributeQuestion3->no_dimension = false;
                    if (isset($_POST['check-3'])) $attributeQuestion3->no_dimension = true;
                    $attributeQuestion3->save(false);
                }
            }
            if ($attributes4) {
                if(!empty($_POST['attrib4'])){
                    $attributeQuestion4->question = $_POST['attrib4'];
                    if (!isset($_POST['check-4'])) $attributeQuestion4->no_dimension = false;
                    if (isset($_POST['check-4'])) $attributeQuestion4->no_dimension = true;
                    $attributeQuestion4->save(false);
                }else{
                    $attributeQuestion4->delete();  
                }
            } else {
                if(!empty($_POST['attrib4'])){
                    $attributeQuestion4 = new Attributes();
                    $attributeQuestion4->question = $_POST['attrib4'];
                    $attributeQuestion4->unit_id = $functional_unit_id;
                    $attributeQuestion4->dimension_id = 4;
                    if (!isset($_POST['check-4'])) $attributeQuestion4->no_dimension = false;
                    if (isset($_POST['check-4'])) $attributeQuestion4->no_dimension = true;
                    $attributeQuestion4->save(false);
                }
            }
            if ($attributes5) {
                if(!empty($_POST['attrib5'])){
                    $attributeQuestion5->question = $_POST['attrib5'];
                    if (!isset($_POST['check-5'])) $attributeQuestion5->no_dimension = false;
                    if (isset($_POST['check-5'])) $attributeQuestion5->no_dimension = true;
                    $attributeQuestion5->save(false);
                }else{
                    $attributeQuestion5->delete();  
                }
            } else {
                if(!empty($_POST['attrib5'])){
                    $attributeQuestion5 = new Attributes();
                    $attributeQuestion5->question = $_POST['attrib5'];
                    $attributeQuestion5->unit_id = $functional_unit_id;
                    $attributeQuestion5->dimension_id = 5;
                    if (!isset($_POST['check-5'])) $attributeQuestion5->no_dimension = false;
                    if (isset($_POST['check-5'])) $attributeQuestion5->no_dimension = true;
                    $attributeQuestion5->save(false);
                }
            }
            if ($attributes6) {
                if(!empty($_POST['attrib6'])){
                    $attributeQuestion6->question = $_POST['attrib6'];
                    if (!isset($_POST['check-6'])) $attributeQuestion6->no_dimension = false;
                    if (isset($_POST['check-6'])) $attributeQuestion6->no_dimension = true;
                    $attributeQuestion6->save(false);
                }else{
                    $attributeQuestion6->delete();  
                }
            } else {
                if(!empty($_POST['attrib6'])){
                    $attributeQuestion6 = new Attributes();
                    $attributeQuestion6->question = $_POST['attrib6'];
                    $attributeQuestion6->unit_id = $functional_unit_id;
                    $attributeQuestion6->dimension_id = 6;
                    if (!isset($_POST['check-6'])) $attributeQuestion6->no_dimension = false;
                    if (isset($_POST['check-6'])) $attributeQuestion6->no_dimension = true;
                    $attributeQuestion6->save(false);
                }
            }
            if ($attributes7) {
                if(!empty($_POST['attrib7'])){
                    $attributeQuestion7->question = $_POST['attrib7'];
                    if (!isset($_POST['check-7'])) $attributeQuestion7->no_dimension = false;
                    if (isset($_POST['check-7'])) $attributeQuestion7->no_dimension = true;
                    $attributeQuestion7->save(false);
                }else{
                    $attributeQuestion7->delete();  
                }
            } else {
                if(!empty($_POST['attrib7'])){
                    $attributeQuestion7 = new Attributes();
                    $attributeQuestion7->question = $_POST['attrib7'];
                    $attributeQuestion7->unit_id = $functional_unit_id;
                    $attributeQuestion7->dimension_id = 7;
                    if (!isset($_POST['check-7'])) $attributeQuestion7->no_dimension = false;
                    if (isset($_POST['check-7'])) $attributeQuestion7->no_dimension = true;
                    $attributeQuestion7->save(false);
                }
            }
            if ($attributes8) {
                if(!empty($_POST['attrib8'])){
                    $attributeQuestion8->question = $_POST['attrib8'];
                    if (!isset($_POST['check-8'])) $attributeQuestion8->no_dimension = false;
                    if (isset($_POST['check-8'])) $attributeQuestion8->no_dimension = true;
                    $attributeQuestion8->save(false);
                }else{
                    $attributeQuestion8->delete();  
                }
            } else {
                if(!empty($_POST['attrib8'])){
                    $attributeQuestion8 = new Attributes();
                    $attributeQuestion8->question = $_POST['attrib8'];
                    $attributeQuestion8->unit_id = $functional_unit_id;
                    $attributeQuestion8->dimension_id = 8;
                    if (!isset($_POST['check-8'])) $attributeQuestion8->no_dimension = false;
                    if (isset($_POST['check-8'])) $attributeQuestion8->no_dimension = true;
                    $attributeQuestion8->save(false);
                }
            }
            Yii::$app->session->setFlash('success', 'This is the message');
            return $this->redirect(['view', 'unit_id' => $model->unit_id]);
        }

        if(Yii::$app->user->can('admin')){
            echo $this->getAttributeId();
        }else{
            if($model->region_id == Yii::$app->user->identity->region_id){
                return $this->render('update', [
                    'model' => $model,
                    'servicesDataArray' => $servicesDataArray,
                    //'attributes' => $attributes,
                    'update' => true,
                    'attributes1' => $attributes1,
                    'attributes2' => $attributes2,
                    'attributes3' => $attributes3,
                    'attributes4' => $attributes4,
                    'attributes5' => $attributes5,
                    'attributes6' => $attributes6,
                    'attributes7' => $attributes7,
                    'attributes8' => $attributes8
                    //'items' => $model->services->services_id
                ]);
            }else{
                throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
            }
        }
    }

    /**
     * Deletes an existing Functionalunit model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $functional_unit_id Functional Unit ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($functional_unit_id)
    {
        $this->findModel($functional_unit_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Functionalunit model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $functional_unit_id Functional Unit ID
     * @return Functionalunit the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($functional_unit_id)
    {
        if (($model = Functionalunit::findOne(['unit_id' => $functional_unit_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionDownloadQrcode($id)
    {
        $file = '../../web/administrator/qr-code/' . $id . '_code.png';
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
    public function getUnitId(){
        $AttributeGroup = Functionalunit::find()->select(['unit_id' => 'MAX(unit_id)'])->limit(1)->one();
        return $AttributeGroup->unit_id + 1;
    }
    public function getAttributeId(){
        $AttributeGroup = AttributeGroup::find()->select(['question_group_unit_id' => 'MAX(question_group_unit_id)'])->limit(1)->one();
        return $AttributeGroup->question_group_unit_id + 1;
    }
}
