<?php

namespace backend\controllers;


use Yii;

use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use common\models\Event;
use common\models\QuestionGroup;
use common\models\Question;
use common\models\Certificate;
use common\models\Message;
use common\models\CreateCertificate;

/**
 * Events controller
 */
class EventsController extends \yii\web\Controller
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
                            'api-event',
                            'create',
                            'post-event',
                            'upload',
                            'preview',
                            'view',
                            'api-customer',
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
    public function actionApiEvent()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $sessionid = Yii::$app->session->getId();
        $con = Yii::$app->db;
        $sql = "SELECT a.`event_id` AS `event_id`,
                        a.`event_name` AS `event_name`,
                        a.`is_disabled` AS `is_disabled`,
                        a.`is_with_certificate` AS `is_with_certificate`,
                        a.`certificate_id` AS `certificate_id`,
                        a.`event_url` AS `event_url`,
                        a.`event_date` AS `event_date`,
                        b.`certificate_id` AS `certificate_id`,
                        b.`certificate_name` AS `certificate_name`
                FROM `tbl_event` AS a 
                LEFT JOIN tbl_certificate AS b 
                ON b.`certificate_id` = a.`certificate_id`
                ORDER BY a.`event_id` DESC";
        $fetchData = $con->createCommand($sql)->queryAll();
        return $fetchData;
    }
    public function actionCreate()
    {

        if (Yii::$app->request->isPost) {

            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);

            //$error = [];
            $message_validation = '';
            //$validation_error = '';
            $isblank = false;
            if (empty($request->event)) $isblank = true;
            if (empty($request->date)) $isblank = true;
            if (empty($request->mailText)) $isblank = true;

            foreach ($request->question as $question) {
                if (empty($question->parentAttrib)) {
                    $isblank = true;
                }
                foreach ($question->items as $item) {
                    if (empty($item->childAttrib)) {
                        $isblank = true;
                    }
                }
            }
            if (empty($request->certificate)) {
                $cert_bool = false;
            } else {
                if (empty($request->fontsize)) $isblank = true;
                if (empty($request->yaxis)) $isblank = true;
                $cert_bool = true;
            }

            if ($isblank == false) {
                $certificate_id = $this->getLastCertId();
                $certificate_id = $certificate_id[0]['certificate_id'] + 1;
                $certificate = new Certificate();
                $certificate->certificate_id = $certificate_id;
                $certificate->certificate_name = $request->certificate;
                $certificate->font_size = $request->fontsize;
                $certificate->y_axis = $request->yaxis;
                $certificate->save(false);

                $message_id = $this->getLastMsgId();
                $message_id = $message_id[0]['message_id'] + 1;
                $message = new Message();
                $message->message_id = $message_id;
                $message->message = $request->mailText;
                $message->save(false);

                $event_id = $this->getLastEventId();
                $event_id = $event_id[0]['event_id'] + 1;
                $event = new Event();
                $event->event_name =  $request->event;
                $event->is_with_certificate = $cert_bool;
                $event->certificate_id = !empty($request->certificate) ?  $certificate_id : 'NULL';
                $event->event_url = 'http://localhost:8084/site/index?id=' . base64_encode(base64_encode($event_id));
                $event->message_id = $message_id;
                $event->save(false);

                foreach ($request->question as $question) {
                    $question_group_id = $this->getLastQuestionGroupId();
                    $question_group_id = $question_group_id[0]['question_group_id'] + 1;
                    $parent = new QuestionGroup();
                    $parent->question_group_id = $question_group_id;
                    $parent->question_group_name = $question->parentAttrib;
                    $parent->event_id = $event_id;
                    $parent->save(false);
                    foreach ($question->items as $item) {
                        $child = new Question();
                        $child->question = $item->childAttrib;
                        $child->question_group_id = $question_group_id;
                        $child->save(false);
                    }
                }
                return 'success';
            } else {
                //Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return $postdata;
            }
        }
        return $this->render('_create');
    }
    public function getLastQuestionGroupId()
    {
        $con = Yii::$app->db;
        $sql = 'SELECT MAX(question_group_id) AS question_group_id FROM tbl_question_group LIMIT 1';
        $fetchData = $con->createCommand($sql)->queryAll();
        return $fetchData;
    }
    public function getLastEventId()
    {
        $con = Yii::$app->db;
        $sql = 'SELECT MAX(event_id) AS event_id FROM tbl_event LIMIT 1';
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

    public function actionPreview($name, $image, $font_size, $y_axis)
    {
        $certificate = new CreateCertificate();
        $certificate->name = $name;
        $certificate->image = $image;
        $certificate->imagelocation = '../../frontend/web/template/';
        $certificate->fontlocation = '../../frontend/web/font/';
        $certificate->font_size = $font_size;
        //$certificate->x_axis = 600;
        $certificate->y_axis = $y_axis;
        $certificate->preview();
    }

    public function actionView($event_id){
        return $this->render('_customer',['event_id' => $event_id]);
    }
    public function actionApiCustomer($event_id){
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
                        WHERE a.`event_id` = :event_id";
        $data_customer = $con->createCommand($sql_customer,[':event_id' => $event_id])->queryAll();
        $sql_question_grp = "SELECT  question_group_id,question_group_name as `parentAttrib` FROM tbl_question_group WHERE event_id = :event_id";
        $data_question_grp = $con->createCommand($sql_question_grp,[':event_id' => $event_id])->queryAll();

        $sql_rating = "SELECT a.`question` AS `childAttrib`,
                              b.`rating_point` AS `score`
                       FROM tbl_question AS a 
                       INNER JOIN tbl_rating AS b
                       ON b.`question_id` = a.`question_id`
                       WHERE b.`customer_id` = :customer_id AND a.`question_group_id` = :question_group_id";

        for($i = 0; $i < count($data_customer); $i++){
            $data_customer[$i]['questions'] = $data_question_grp;
            $data_customer[$i]['drilldown'] = false;
            for($j = 0; $j < count($data_customer[$i]['questions']); $j++){
                $question_group_id = $data_customer[$i]['questions'][$j]['question_group_id'];
                $customer_id = $data_customer[$i]['customer_id'];
                $data_rating = $con->createCommand($sql_rating,[':customer_id' => $customer_id, ':question_group_id' => $question_group_id])->queryAll();
                $data_customer[$i]['questions'][$j]['items'] = $data_rating;
            }
        }
        if(empty($data_customer)){
            $message = ['message' => 'Data is empty'] ;
            return $message;
        }else{
            return $data_customer;
        }
        //return $data_customer;
    }
}