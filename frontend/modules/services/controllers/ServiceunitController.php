<?php

namespace frontend\modules\services\controllers;

use common\models\Pstc;
use common\models\Region;
use common\models\ServiceUnit;
use common\models\Services;
use yii\web\NotFoundHttpException;

class ServiceunitController extends \yii\web\Controller
{
    public function actionIndex($services_id,$region_id)
    {
        $this->findRegion($region_id);
        $services = $this->findServices($services_id);
        $model = ServiceUnit::find()->where(['services_id' => $services_id,'is_child' => 0])->all();
        return $this->render('index',['model' => $model,'region_id' => $region_id,'services' => $services]);
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
    protected function findSubUnit($id)
    {
        if (($model = ServiceUnit::find()->where(['parent_id' => $id,'is_child' => 1])->all()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    protected function findServices($id)
    {
        if (($model = Services::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionPstc($service_unit_id,$region_id){
        $model = Pstc::find()->where(['region_id' => $region_id])->all();
        $serviceunit = $this->findServiceUnit($service_unit_id);
        $services = $this->findServices($serviceunit->services_id);
        return $this->render('pstc',['model'=>$model,'service_unit_id'=>$service_unit_id, 'region_id'=>$region_id,'serviceunit'=>$serviceunit,'services'=>$services]);
    }
    public function actionSubunit($service_unit_id,$region_id){
        $model = $this->findSubUnit($service_unit_id);
        $serviceunit = $this->findServiceUnit($service_unit_id);
        $services = $this->findServices($serviceunit->services_id);
        return $this->render('subunit',['model'=>$model, 'service_id'=>$service_unit_id, 'region_id'=>$region_id,'serviceunit'=>$serviceunit,'services'=>$services]);
    }
}
