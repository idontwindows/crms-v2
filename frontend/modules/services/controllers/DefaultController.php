<?php

namespace frontend\modules\services\controllers;


use common\models\Region;
use common\models\Services;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Default controller for the `services` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex($region_id)
    {
        $this->findRegion($region_id);
        $model = Services::find()->all();
        return $this->render('index',
            [
                'model' => $model,
                'region_id' => $region_id
            ]
        );
    }
    protected function findRegion($id)
    {
        if (($model = Region::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
