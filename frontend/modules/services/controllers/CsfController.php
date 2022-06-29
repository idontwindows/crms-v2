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
use common\models\ImportanceRatingV2;
use common\models\NpsRatingV2;
use common\models\Drivers;
use yii\web\ForbiddenHttpException;

class CsfController extends \yii\web\Controller
{
    public function actionIndex($service_unit_id,$region_id)
    {
        $this->findRegion($region_id);
        $serviceunit = $this->findServiceUnit($service_unit_id);
        $model = $this->findAttributes($service_unit_id);
        $drivers = $this->getDrivers($region_id);
        $request = Yii::$app->request;
        if($serviceunit->is_with_pstc == 1){
            if(!isset($_GET['pstc_id'])){
                throw new NotFoundHttpException('The requested page does not exist.');
            }
            $pstc = $this->findPstc($_GET['pstc_id'],$region_id);
            return $this->render('index',['model' => $model, 'service_unit_id' => $service_unit_id, 'pstc' => $pstc, 'region_id' => $region_id, 'request' => $request, 'serviceunit' => $serviceunit]);
        }else{
            if(isset($_GET['pstc_id'])){
                throw new NotFoundHttpException('The requested page does not exist.');
            }
            return $this->render('index',['model' => $model, 'service_unit_id' => $service_unit_id, 'drivers' => $drivers,'region_id' => $region_id,'request' => $request, 'serviceunit' => $serviceunit]); 
        }
  
        
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

        $customer_id = $this->generateCustomerId();
        $customer = new CustomerV2();
        $nps = new NpsRatingV2();

        $request = Yii::$app->request;

        //$serviceunit = $this->findServiceUnit($request->get('service_unit_id'));

        if(Yii::$app->request->isPost){
            if($request->get('service_unit_id') == 10){
                if(empty($request->post('drivers_name'))){
                    $data['message'] = 'blank';
                    return json_encode($data);
                } 
            }
            if (empty($request->post('customer_age')) || empty($request->post('customer_gender')) || empty($request->post('customer_client_type'))) {
                $data['message'] = 'blank';
                return json_encode($data);
            }
            $k = 0;
            $data['complaint'] = false;
            foreach ($request->post('rating')[$request->get('service_unit_id')] as $complaint) {
                if($request->post('rating')[$request->get('service_unit_id')][$k] <= 3){
                    $data['complaint'] = true; 
                    if(empty($request->post('comments'))){  
                        return json_encode($data);
                    } 
                    if(empty($request->post('customer_email'))){ 
                        $data['message'] = 'blank';
                        return json_encode($data);
                    } 
                }
                $k++;
            }
            //This is to save data on table customer
            $customer->customer_id = $customer_id;
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
            $customer->service_unit_id = $request->get('service_unit_id');
            if(null !== $request->get('pstc_id')) $customer->pstc_id = $request->get('pstc_id');
            if($request->get('service_unit_id') == 10) $customer->driver_id = $request->post('drivers_name');
            $customer->region_id = $request->get('region_id');
            $customer->date_created = date("Y-m-d H:i:s");
            $customer->save(false);

            $comment = new CommentV2();
            $comment->customer_id = $customer_id;
            if(!empty($request->post('comments'))) $comment->comment = $request->post('comments');
            if(!empty($request->post('other_important_attrib'))) $comment->comment = $request->post('other_important_attrib');
            if($data['complaint']) $comment->is_complaint = true;
            if(!empty($request->post('comments')) || !empty($request->post('other_important_attrib'))) $comment->save(false);

            $i=0;
            foreach ($request->post('rating')[$request->get('service_unit_id')] as $rating_score){
                $rating = new RatingV2();
                $rating->customer_id = $customer_id;
                //$rating->service_unit_id = $request->get('service_unit_id');
                $rating->attribute_id = $request->post('questionId')[$request->get('service_unit_id')][$i];
                $rating->rating_point = $request->post('rating')[$request->get('service_unit_id')][$i];
                $rating->rating_date = date("Y-m-d H:i:s");
                $rating->save(false);
                $i++;
            }
      
            $j=0;
            foreach ($request->post('importance')[$request->get('service_unit_id')] as $importance){
                $important = new ImportanceRatingV2();
                $important->customer_id = $customer_id;
                //$important->service_unit_id = $request->get('service_unit_id');
                $important->attribute_id = $request->post('questionimportance')[$request->get('service_unit_id')][$j];
                $important->rating_point = $request->post('importance')[$request->get('service_unit_id')][$j];
                //$important->rating_point = $importance[$j];
                $important->rating_date = date("Y-m-d H:i:s");
                $important->save(false);
                $j++;
            }
            $nps->score = $request->post('nps');
            $nps->customer_id = $customer_id;
            //$nps->service_unit_id = $request->get('service_unit_id');
            $nps->rating_date = date("Y-m-d H:i:s");
            $nps->save(false);

            $data['message'] = 'success';
            $data['region_id'] = $request->get('region_id');
            $data['service_unit_id'] = $request->get('service_unit_id');
            if(null !== $request->get('pstc_id')){
                $data['pstc_id'] = $request->get('pstc_id');
            }else{
                $data['pstc_id'] = 0;
            }
            return json_encode($data);
        }else{
            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
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
