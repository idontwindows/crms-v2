<?php

namespace frontend\modules\services\controllers;

use Yii;
use common\models\AttributesV2;
use yii\web\NotFoundHttpException;
use common\models\Region;
use common\models\ServiceUnit;
use common\models\Pstc;
use common\models\CustomerV2;
use common\models\CommentV2;
use common\models\RatingV2;
use common\models\NpsRatingV2;
use common\models\Drivers;

class CsfController extends \yii\web\Controller
{
    public function actionIndex($service_unit_id,$region_id)
    {
        $this->findRegion($region_id);
        $serviceunit = $this->findServiceUnit($service_unit_id);
        $model = $this->findAttributes($service_unit_id);
        $drivers = $this->getDrivers($region_id);
        if($serviceunit->is_with_pstc == 1){
            if(!isset($_GET['pstc_id'])){
                throw new NotFoundHttpException('The requested page does not exist.');
            }
            $this->findPstc($_GET['pstc_id'],$region_id);
            return $this->render('index',['model' => $model, 'service_unit_id' => $service_unit_id]);
        }
        return $this->render('index',['model' => $model, 'service_unit_id' => $service_unit_id, 'drivers' => $drivers ]);
    }
    protected function findAttributes($id)
    {
        if (($model = AttributesV2::find()->where(['service_unit_id' => $id])->all()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    protected function findRegion($id)
    {
        if (($model = Region::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    protected function findServiceUnit($id)
    {
        if (($model = ServiceUnit::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    protected function findPstc($id,$region_id)
    {
        if (($model = Pstc::find()->where(['pstc_id' => $id, 'region_id' => $region_id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionPostRating(){

        $customer_id = $this->CustomerId();
        $customer = new CustomerV2();
        $comment = new CommentV2();
        $nps = new NpsRatingV2();

        $request = Yii::$app->request;

        if(Yii::$app->request->isPost){
            $customer->customer_id = $this->generateCustomerId();
            $customer->customer_email = $request->post('customer_email');
            $customer->customer_name = $request->post('customer_name');
            $customer->client_type = $request->post('customer_client_type');
            $customer->gender = $request->post('customer_gender');
            $customer->age_group = $request->post('customer_age');
            if(!empty($request->post('digital-literate'))) $customer->digital_literacy = $request->post('digital-literate');
            if(!empty($request->post('pwd'))) $customer->pwd = $request->post('pwd');
            if(!empty($request->post('preggy')) && $request->post('customer_gender') == 'female') $customer->pregnant = $request->post('preggy');
            if(!empty($request->post('senior'))) $customer->senior_citizen = $request->post('senior');
            $customer->signature = $request->post('sigText');
            $customer->date_created = date("Y-m-d H:i:s");
            $customer->save(false);
        }
    }
    protected function generateCustomerId()
    {
        $model = CustomerV2::find()->select(['customer_id' => 'MAX(customer_id)'])->limit(1)->one();
        return $model->customer_id + 1;
    }
    protected function getDrivers($region_id){
        $model = Drivers::find()->where(['region_id' => $region_id])->all();
        return $model;
    }
    // public function actionInsertattrib(){
    //     for($i=2;$i<=39;$i++){
    //         $con = Yii::$app->db;
    //     $con->createCommand()->batchInsert('tbl_attributes_v2',
    //                 ['question', 'dimension_id','service_unit_id'],
    //                 [
    //                     ['Responsiveness', 1, $i],
    //                     ['Reliability(Quality)', 2, $i],
    //                     ['Access & Facilities', 3, $i],
    //                     ['Communication', 4, $i],
    //                     ['Costs', 5, $i],
    //                     ['Integrity', 6, $i],
    //                     ['Assurance', 7, $i],
    //                     ['Outcome', 8, $i],
    //                 ])
    //                 ->execute();
   
    //     }
    // }
}
