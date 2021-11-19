<?php

namespace backend\controllers;


use Yii;

use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use common\models\Unit;
use common\models\QuestionGroupUnit;
use common\models\QuestionUnit;
use common\models\Certificate;
use common\models\Message;
use common\models\CreateCertificate;

/**
 * Events controller
 */
class UnitController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => [
                            'index',
                            'api-unit',
                            'create',
                            'post-event',
                            'upload',
                            'preview',
                            'view',
                            'api-customer',
                            'api-region',
                            'update',
                            'update-api'
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionApiUnit()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $sessionid = Yii::$app->session->getId();
        $con = Yii::$app->db;
        $sql = "SELECT `unit_id`,
                        `unit_name`,
                        `unit_url` 
                FROM `tbl_unit`
                WHERE " . $this->getOrRegions() .
                " ORDER BY `unit_id` DESC";
        $fetchData = $con->createCommand($sql)->queryAll();
        return $fetchData;
    }
    public function actionCreate()
    {
        if (Yii::$app->request->isPost) {
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);
            $message = 'success';
            if (empty($request->region)) $message = 'empty';
            if (empty($request->unitname)) $message = 'empty';
            //if(empty($request->mailText)) $message = 'empty';
            foreach ($request->question as $question) {
                if (empty($question->parentAttrib)) {
                    $message = 'empty';
                }
                foreach ($question->items as $item) {
                    if (empty($item->childAttrib)) {
                        $message = 'empty';
                    }
                }
            }
            if ($message == 'success') {
                $unit_id = $this->getLastUnitId();
                $unit_id = $unit_id[0]['unit_id'] + 1;
                $unit = new Unit();
                $unit->unit_id = $unit_id;
                $unit->unit_name =  $request->unitname;
                $unit->region_id = $request->region;
                $unit->unit_url = 'http://localhost:8084/site/index?id=' . base64_encode(base64_encode($unit_id));
                $unit->save(false);

                foreach ($request->question as $question) {
                    $question_group_id = $this->getLastQuestionGroupId();
                    $question_group_id = $question_group_id[0]['question_group_unit_id'] + 1;
                    $parent = new QuestionGroupUnit();
                    $parent->question_group_unit_id = $question_group_id;
                    $parent->question_group_unit_name = $question->parentAttrib;
                    $parent->unit_id = $unit_id;
                    $parent->save(false);
                    foreach ($question->items as $item) {
                        $child = new QuestionUnit();
                        $child->question = $item->childAttrib;
                        $child->question_group_unit_id = $question_group_id;
                        $child->save(false);
                    }
                }
                return $message;
            }
            return $postdata;
        }
        return $this->render('_create');
    }
    public function actionUpdate($unit_id)
    {
        //$question_group_unit_id = 6;
        if(Yii::$app->request->isPost){
            return;
        }
        return $this->render('_update');
    }
    public function actionUpdateApi($unit_id){
        $con = Yii::$app->db;
        $sql_question_grp = "SELECT  question_group_unit_id,question_group_unit_name as `parentAttrib` FROM tbl_question_group_unit WHERE unit_id = :unit_id";
        $data_question_grp = $con->createCommand($sql_question_grp, [':unit_id' => $unit_id])->queryAll();
        $sql_question = "SELECT a.`question` AS `childAttrib`
                       FROM tbl_question_unit AS a 
                       WHERE a.`question_group_unit_id` = :question_group_unit_id";
        $sql_unit = 'SELECT unit_name AS unitname, region_id AS region FROM tbl_unit WHERE unit_id = :unit_id';
        $data_unit = $con->createCommand($sql_unit, [':unit_id' => $unit_id])->queryAll();
        for($i = 0; $i < count($data_question_grp); $i++){
            $data_question = $con->createCommand($sql_question,[':question_group_unit_id' => $data_question_grp[$i]['question_group_unit_id']])->queryAll();
            $data_question_grp[$i]['items'] = $data_question;
        }
        $json = '{"question":'.json_encode($data_question_grp).',"unitname":'.json_encode($data_unit[0]['unitname']).',"region":'.json_encode($data_unit[0]['region']).'}';
        return $json;
    }
    public function getLastQuestionGroupId()
    {
        $con = Yii::$app->db;
        $sql = 'SELECT MAX(question_group_unit_id) AS question_group_unit_id FROM tbl_question_group_unit LIMIT 1';
        $fetchData = $con->createCommand($sql)->queryAll();
        return $fetchData;
    }
    public function getLastUnitId()
    {
        $con = Yii::$app->db;
        $sql = 'SELECT MAX(unit_id) AS unit_id FROM tbl_unit LIMIT 1';
        $fetchData = $con->createCommand($sql)->queryAll();
        return $fetchData;
    }
    public function getLastCertId()
    {
        $con = Yii::$app->db;
        $sql = 'SELECT MAX(certificate_id) AS certificate_id FROM tbl_certificate LIMIT 1';
        $fetchData = $con->createCommand($sql)->queryAll();
        return $fetchData;
    }
    public function getLastMsgId()
    {
        $con = Yii::$app->db;
        $sql = 'SELECT MAX(message_id) AS message_id FROM tbl_message LIMIT 1';
        $fetchData = $con->createCommand($sql)->queryAll();
        return $fetchData;
    }
    public function actionUpload()
    {
        try {
            /* Getting file name */
            $filename = $_FILES['file']['name'];
            /* Location */
            $location = '../../frontend/web/template/';
            /* Upload file */
            move_uploaded_file($_FILES['file']['tmp_name'], $location . $filename);
        } catch (yii\base\ErrorException $e) {
            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
        }
    }

    public function actionView($unit_id)
    {
        return $this->render('_customer', ['unit_id' => $unit_id]);
    }
    public function actionApiCustomer($unit_id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $con = Yii::$app->db;
        $sql_customer = "SELECT DISTINCT b.`customer_id` AS `customer_id`,
                                        b.`customer_name` AS `customer_name`,
                                        b.`customer_email` AS `email`,
                                        a.`rating_date` AS `date`,
                                        true as `drilldown`
                        FROM tbl_rating AS a 
                        INNER JOIN tbl_customer AS b 
                        ON b.`customer_id` = a.`customer_id` 
                        WHERE a.`unit_id` = :unit_id";
        $data_customer = $con->createCommand($sql_customer, [':unit_id' => $unit_id])->queryAll();
        $sql_question_grp = "SELECT  question_group_unit_id,question_group_unit_name as `parentAttrib` FROM tbl_question_group_unit WHERE unit_id = :unit_id";
        $data_question_grp = $con->createCommand($sql_question_grp, [':unit_id' => $unit_id])->queryAll();

        $sql_rating = "SELECT a.`question` AS `childAttrib`,
                              b.`rating_point` AS `score`
                       FROM tbl_question_unit AS a 
                       INNER JOIN tbl_rating AS b
                       ON b.`question_id` = a.`question_unit_id`
                       WHERE b.`customer_id` = :customer_id AND a.`question_group_unit_id` = :question_group_id";

        for ($i = 0; $i < count($data_customer); $i++) {
            $data_customer[$i]['questions'] = $data_question_grp;
            $data_customer[$i]['drilldown'] = false;
            for ($j = 0; $j < count($data_customer[$i]['questions']); $j++) {
                $question_group_id = $data_customer[$i]['questions'][$j]['question_group_unit_id'];
                $customer_id = $data_customer[$i]['customer_id'];
                $data_rating = $con->createCommand($sql_rating, [':customer_id' => $customer_id, ':question_group_id' => $question_group_id])->queryAll();
                $data_customer[$i]['questions'][$j]['items'] = $data_rating;
            }
        }
        if (empty($data_customer)) {
            $message = ['message' => 'Data is empty'];
            return $message;
        } else {
            return $data_customer;
        }
        //return $data_customer;
    }
    public function actionApiRegion()
    {
        $region = Yii::$app->user->identity->regions;
        //Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        // $con = Yii::$app->db;
        // $sqlRegion = "SELECT region_id,
        //                     IF(region_id = 1,'Region I',
        //                     IF(region_id = 2,'Region II',
        //                     IF(region_id = 3,'Region III',
        //                     IF(region_id = 4,'Region IV-A',
        //                     IF(region_id = 5,'Region V',
        //                     IF(region_id = 6,'Region VI',
        //                     IF(region_id = 7,'Region VII',
        //                     IF(region_id = 8,'Region VIII',
        //                     IF(region_id = 9,'Region IX',
        //                     IF(region_id = 10,'Region X',
        //                     IF(region_id = 11,'Region XI',
        //                     IF(region_id = 12,'Region XII',
        //                     IF(region_id = 13,'Region IV-B',
        //                     IF(region_id = 14,'CARAGA',
        //                     IF(region_id = 15,'CAR',
        //                     IF(region_id = 16,'NCR',
        //                     IF(region_id = 17,'ARMM',
        //                     IF(region_id = 18,'ROS',''
        //                     )))))))))))))))))) AS region_name
        //             FROM tbl_region";
        // $data = $con->createCommand($sqlRegion)->queryAll();
        return $region;
    }
    public function getOrRegions(){
        $userregions = Yii::$app->user->identity->regions;
        $regions = json_decode($userregions);
        $string = "";
        foreach($regions as $region){
            if(count($regions) > 1){
                $string.= ' OR `region_id` = '. $region->region_id;
            }
            $string.= ' OR `region_id` = '. $region->region_id;
        }
        //$result = str_replace('*','OR',$string);

        return substr($string,3);
    }
}
