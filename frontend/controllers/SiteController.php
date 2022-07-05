<?php

namespace frontend\controllers;

use common\models\Comment;
use common\models\CommentV2;
use common\models\CreateCertificate;
use common\models\Customer;
use common\models\CustomerV2;
use common\models\ImportanceRating;
use common\models\NpsRating;
use common\models\NpsRatingV2;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Rating;
use common\models\RatingV2;
use common\models\UnitServices;
use common\models\Message;
use common\models\Pstc;
use common\models\Region;
use common\models\Unit;
use yii\web\ForbiddenHttpException;
use yii\base\ErrorException;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => [
                            'logout',
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    // public function actionIndex($id)
    // {
    //     $con = Yii::$app->db;
    //     $id = base64_decode(base64_decode($id));
    //     $sql1 = 'SELECT * FROM `tbl_event` WHERE `unit_id` =' . $id . ' AND `is_disabled` = 0';

    //     try {
    //         $title = $con->createCommand($sql1)->queryOne();
    //         if (!$title) {
    //             throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
    //         }
    //     } catch (\yii\db\Exception $exception) {
    //         throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
    //     }
    //     $sql2 = 'SELECT * FROM `tbl_question_group` WHERE `unit_id` =' . $id;

    //     try {
    //         $groups = $con->createCommand($sql2)->queryAll();
    //         return $this->render('index', ['groups' => $groups, 'title' => $title]);
    //     } catch (\yii\db\Exception $exception) {
    //         throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
    //     }
    // }
    public function actionIndex()
    {
        $con = Yii::$app->db;
        //$sql = 'SELECT DISTINCT a.`region_id`, b.region_code FROM tbl_unit AS a INNER JOIN tbl_region AS b ON b.region_id = a.region_id WHERE a.`is_disabled` = 0 ORDER BY b.`order` ASC';
        $sql = 'SELECT `region_id`, `region_code` FROM tbl_region ORDER BY `order` ASC';
        $regions = $con->createCommand($sql)->queryAll();
        return $this->render('index',['regions' => $regions]);
    }
    // public function actionCsf($id)
    // {
    //     $con = Yii::$app->db;
    //     $id = base64_decode(base64_decode($id));
    //     //$sql1 = 'SELECT * FROM `tbl_unit` WHERE `unit_id` =' . $id . ' AND `is_disabled` = 0';
    //     $sql1 = 'SELECT a.`unit_id`,
    //                     a.`services_id`,
    //                     c.`services_name`,
    //                     a.`unit_name`, 
    //                     a.`region_id`, 
    //                     a.`unit_url`, 
    //                     a.`date_created`, 
    //                     a.`is_disabled`, 
    //                     b.`region_code`,
    //                     c.`with_pstc_hrdc`
    //             FROM tbl_unit AS a 
    //             INNER JOIN tbl_region AS b 
    //             ON b.`region_id` = a.`region_id`
    //             INNER JOIN  tbl_unit_services AS c
    //             ON c.`services_id` = a.`services_id`
    //             WHERE a.`unit_id` = :unit_id AND a.`is_disabled` = 0'; 
    //     try {
    //         $title = $con->createCommand($sql1,[':unit_id' => $id])->queryOne();
    //         if (!$title) {
    //             throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
    //         }
    //     } catch (\yii\db\Exception $exception) {
    //         //throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
    //         echo '<h1>Not found (#404)</h1>';
    //     }
    //     $sql2 = 'SELECT * FROM `tbl_question_group_unit` WHERE `unit_id` =' . $id . ' AND `importance` = 0';

    //     try {
    //         $groups = $con->createCommand($sql2)->queryAll();
    //         return $this->render('_csf', ['groups' => $groups, 'title' => $title]);
    //     } catch (\yii\db\Exception $exception) {
    //         //throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
    //     } 
    // }
    /**
     * @var mixed $id must convert to base64 2x
     */
    public function actionPostRating()
    {
        $con = Yii::$app->db;
        $id = $_GET['id'];
        //$sql1 = 'SELECT * FROM `tbl_event` WHERE `unit_id` =' . base64_decode(base64_decode($id));
        $sql1 = 'SELECT a.`unit_id` AS `unit_id`,
                                b.`services_id` AS `services_id`,
                                b.`services_name` AS `services_name`,
                                a.`unit_name` AS `event_name`,
                                a.`is_disabled` AS `is_disabled`,
                                a.`date_created` AS `date_created`
                        FROM `tbl_unit` AS a 
                        LEFT OUTER JOIN tbl_unit_services AS b
                        ON b.services_id = a.`services_id` 
                WHERE a.`unit_id` =' . base64_decode(base64_decode($id));

        try {
            $title = $con->createCommand($sql1)->queryOne();
        } catch (\yii\db\Exception $exception) {
            throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
        }

        $id = $_GET['id'];
        $customerId = $this->getLastCustomerId();
        $customerId = $customerId[0]['customer_id'] + 1;


        $sql2 = 'SELECT * FROM `tbl_question_group_unit` WHERE `unit_id` =' . base64_decode(base64_decode($id));
        try {
            $groups = $con->createCommand($sql2)->queryAll();
        } catch (\yii\db\Exception $exception) {
            throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
        }
        //$data = [];
        if(Yii::$app->request->isPost){
            if($title['services_id'] == 12){
                if(empty($_POST['drivers_name'])){
                    $data['message'] = 'blank';
                    return json_encode($data);
                } 
            }
            if (empty($_POST['customer_age']) || empty($_POST['customer_gender']) || empty($_POST['customer_client_type'])) {
                $data['message'] = 'blank';
                return json_encode($data);
            }else{
                $customer = new Customer();
                $customer->customer_id = $customerId;
                $customer->customer_name = $_POST['customer_name'];
                $customer->customer_email = $_POST['customer_email'];
                $customer->client_type = $_POST['customer_client_type'];
                $customer->age_group = $_POST['customer_age'];
                $customer->gender = $_POST['customer_gender'];
                $customer->signature = $_POST['sigText'];
                //if(!empty($_POST['customer_other_info'])) $customer->other_info = $_POST['customer_other_info'];
                if(!empty($_POST['digital-literate'])) $customer->digital_literacy = 1;
                if(!empty($_POST['pwd'])) $customer->pwd = 1;
                if(!empty($_POST['preggy']) && $_POST['customer_gender'] == 'female') $customer->pregnant = 1;
                if(!empty($_POST['senior'])) $customer->senior_citizen = 1;
                $customer->date_created = date("Y-m-d H:i:s");
                $customer->save(false);
                if (!empty($_POST['comments'])) {
                    $comment = new Comment();
                    $comment->customer_id = $customerId;
                    $comment->comment = $_POST['comments'];
                    $comment->other_important_attrib = $_POST['other_important_attrib'];
                    $comment->save(false);
                }
                foreach ($groups as $group) {
                    $j = 0;
                    foreach ($_POST['rating'][$group['question_group_unit_id']] as $rating) {
                        $rating = new Rating();
                        $rating->customer_id = $customerId;
                        $rating->unit_id = base64_decode(base64_decode($id));
                        $rating->question_group_id = base64_decode(base64_decode($_POST['groupId'][$group['question_group_unit_id']][$j]));
                        $rating->question_id = base64_decode(base64_decode($_POST['questionId'][$group['question_group_unit_id']][$j]));
                        if(isset($_POST['drivers_name'])) $rating->drivers_id = $_POST['drivers_name'];
                        $rating->rating_point = $_POST['rating'][$group['question_group_unit_id']][$j];
                        $rating->rating_date = date("Y-m-d H:i:s");
                        $rating->save(false);
                        $j++;
                    }
                }
                $nps = new NpsRating();
                $nps->score = $_POST['nps'];
                $nps->customer_id = $customerId;
                $nps->unit_id = base64_decode(base64_decode($id));
                $nps->rating_date = date("Y-m-d H:i:s");
                $nps->save(false);
    
                $data['message'] = 'success';
                return json_encode($data);
            }
        }else{
            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
        }
    }
    public function actionPostRating2()
    {
        $unit_id = base64_decode(base64_decode($_GET['id']));

        $customer_id = $this->CustomerId();
        $customer = new CustomerV2();
        $comment = new CommentV2();
        $nps = new NpsRatingV2();


        $con = Yii::$app->db;
        $sql1 = 'SELECT a.`unit_id` AS `unit_id`,
                b.`services_id` AS `services_id`,
                b.`services_name` AS `services_name`,
                a.`unit_name` AS `event_name`,
                a.`is_disabled` AS `is_disabled`,
                a.`date_created` AS `date_created`
        FROM `tbl_unit` AS a 
        LEFT OUTER JOIN tbl_unit_services AS b
        ON b.services_id = a.`services_id` 
        WHERE a.`unit_id` =' . $unit_id;

        $sql2 = 'SELECT a.`unit_id`,
                        a.`services_id`,
                        a.`unit_name`, 
                        a.`region_id`, 
                        a.`unit_url`, 
                        a.`date_created`, 
                        a.`is_disabled`, 
                        b.`region_code`,
                        c.`with_pstc_hrdc`
                FROM tbl_unit AS a 
                INNER JOIN tbl_region AS b 
                ON b.`region_id` = a.`region_id`
                INNER JOIN  tbl_unit_services AS c
                ON c.`services_id` = a.`services_id`
                WHERE a.`unit_id` = :unit_id AND a.`is_disabled` = 0';
        $unit = $con->createCommand($sql2,[':unit_id' => $unit_id])->queryOne();


        try {
        $driver = $con->createCommand($sql1)->queryOne();
        } catch (\yii\db\Exception $exception) {
        throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
        }

        if(Yii::$app->request->isPost){
            if($driver['services_id'] == 12){
                if(empty($_POST['drivers_name'])){
                    $data['message'] = 'blank';
                    return json_encode($data);
                } 
            }
            if (empty($_POST['customer_age']) || empty($_POST['customer_gender']) || empty($_POST['customer_client_type'])) {
                $data['message'] = 'blank';
                return json_encode($data);
            }
            $k = 0;
            $data['complaint'] = false;
            foreach ($_POST['rating'][$unit_id] as $complaint) {
                if($_POST['rating'][$unit_id][$k] <= 3){
                    $data['complaint'] = true; 
                    if(empty($_POST['comments'])){  
                        return json_encode($data);
                    } 
                }
                $k++;
            }

            $customer->customer_id = $customer_id;
            $customer->customer_name = $_POST['customer_name'];
            $customer->customer_email = $_POST['customer_email'];
            $customer->client_type = $_POST['customer_client_type'];
            $customer->gender = $_POST['customer_gender'];
            $customer->age_group = $_POST['customer_age'];
            if(!empty($_POST['digital-literate'])) $customer->digital_literacy = $_POST['digital-literate'];
            if(!empty($_POST['pwd'])) $customer->pwd = $_POST['pwd'];
            if(!empty($_POST['preggy']) && $_POST['customer_gender'] == 'female') $customer->pregnant = $_POST['preggy'];
            if(!empty($_POST['senior'])) $customer->senior_citizen = $_POST['senior'];
            $customer->signature = $_POST['sigText'];
            if($unit['with_pstc_hrdc'] == 1) $customer->pstc_id = $_GET['pstc_id'];
            $customer->date_created = date("Y-m-d H:i:s");
            $customer->save(false);
            if (!empty($_POST['comments'])) {
                $comment->customer_id = $customer_id;
                $comment->comment = $_POST['comments'];
                $comment->other_important_attrib = $_POST['other_important_attrib'];
                if($data['complaint']) $comment->is_complaint = true;
                $comment->save(false);
            }
            $i = 0;
            foreach ($_POST['rating'][$unit_id] as $ratecount) {
                $rating = new RatingV2();
                $rating->customer_id = $customer_id;
                $rating->unit_id = $unit_id;
                $rating->question_id = $_POST['questionId'][$unit_id][$i];
                if(isset($_POST['drivers_name'])) $rating->drivers_id = $_POST['drivers_name'];
                $rating->rating_point = $_POST['rating'][$unit_id][$i];
                $rating->rating_date = date("Y-m-d H:i:s");
                $rating->save(false);
                $i++;
            }
            $j = 0;
            foreach ($_POST['importance'][$unit_id] as $importantcount) {
                $importancerating = new ImportanceRating();
                $importancerating->customer_id = $customer_id;
                $importancerating->unit_id = $unit_id;
                $importancerating->question_id = $_POST['questionimportance'][$unit_id][$j];
                if(isset($_POST['drivers_name'])) $importancerating->drivers_id = $_POST['drivers_name'];
                $importancerating->rating_point = $_POST['importance'][$unit_id][$j];
                $importancerating->rating_date = date("Y-m-d H:i:s");
                $importancerating->save(false);
                $j++;
            }
            
            $nps->score = $_POST['nps'];
            $nps->customer_id = $customer_id;
            $nps->unit_id = $unit_id;
            $nps->rating_date = date("Y-m-d H:i:s");
            $nps->save(false);

            if($unit['with_pstc_hrdc'] == 1) $data['pstc_id'] = $_GET['pstc_id'];    
            if($unit['with_pstc_hrdc'] == 1) $data['isPstc'] = true;
            
            $data['message'] = 'success';
            return json_encode($data);
        }else{
            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
        }
    }
    public function actionThankYou()
    {
        return $this->render('_thankyou');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    // public function actionLogin()
    // {
    //     if (!Yii::$app->user->isGuest) {
    //         return $this->goHome();
    //     }

    //     $model = new LoginForm();
    //     if ($model->load(Yii::$app->request->post()) && $model->login()) {
    //         return $this->goBack();
    //     }

    //     $model->password = '';

    //     return $this->render('login', [
    //         'model' => $model,
    //     ]);
    // }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    // public function actionLogout()
    // {
    //     Yii::$app->user->logout();

    //     return $this->goHome();
    // }



    /**
     * Signs user up.
     *
     * @return mixed
     */
    // public function actionSignup()
    // {
    //     $model = new SignupForm();
    //     if ($model->load(Yii::$app->request->post()) && $model->signup()) {
    //         Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
    //         return $this->goHome();
    //     }

    //     return $this->render('signup', [
    //         'model' => $model,
    //     ]);
    // }

    /**
     * Requests password reset.
     *
     * @return mixed
     */






    public function getQuestions()
    {
        $con = Yii::$app->db;
        $sql = 'SELECT a.`unit_id`,
                       a.`unitt_name`,
                       a.`date_created`,
                       b.`question_group_unit_id`,
                       b.`question_group_unit_name`,
                       c.`question_unit_id`,
                       c.`question`
                FROM tbl_event AS a 
                INNER JOIN tbl_question_group_unit AS b ON b.`unit_id` = a.`unit_id` 
                INNER JOIN tbl_question_unit AS c ON c.`quuestion_group_unit_id` = b.`question_group_unit_id`';
        $fetchData = $con->createCommand($sql)->queryAll();
        return $fetchData;
    }
    public function getLastCustomerId()
    {
        $con = Yii::$app->db;
        $sql = 'SELECT MAX(customer_id) AS customer_id FROM tbl_customer LIMIT 1';
        $fetchData = $con->createCommand($sql)->queryAll();
        return $fetchData;
    }
    public function CustomerId()
    {
        $model = CustomerV2::find()->select(['customer_id' => 'MAX(customer_id)'])->limit(1)->one();
        return $model->customer_id + 1;
    }

    public function generateCertificate($name, $image, $imageName, $font_size, $y_axis)
    {
        $certificate = new CreateCertificate();
        $certificate->name = $name;
        $certificate->image = $image;
        $certificate->imagelocation = 'template/';
        $certificate->fontlocation = 'font/';
        $certificate->font_size = $font_size;
        //$certificate->x_axis = 600;
        $certificate->y_axis = $y_axis;
        $certificate->imageName = $imageName;
        $certificate->create();
    }
    public function getMessage($id)
    {
        $con = Yii::$app->db;
        $sql = 'SELECT *  FROM tbl_message WHERE message_id = ' . $id;
        $fetchData = $con->createCommand($sql)->queryAll();
        return $fetchData;
    }
    // public function actionRegionUnits($region_code)
    // {
    //     $con = Yii::$app->db;
    //     $sql = 'SELECT a.`unit_id`,
    //                     a.`unit_name`,
    //                     a.`unit_url` 
    //             FROM `tbl_unit` AS a 
    //             INNER JOIN tbl_region AS b 
    //             ON b.`region_id` = a.`region_id`
    //             WHERE b.`region_code` = :region_code
    //             AND a.`is_disabled` = 0
    //             ORDER BY `unit_name` ASC';
    //     $regions = $con->createCommand($sql, [':region_code' => $region_code])->queryAll();
    //     if ($regions) {
    //         return $this->render('menu', ['regions' => $regions]);
    //     } else {
    //         return $this->render('_blank');
    //     }
    // }
    public function actionRegionUnits($region_code)
    {
        $con = Yii::$app->db;
        $sql = "CALL sp_services(:region_code)";
        
        try{
            $regions = $con->createCommand($sql, [':region_code' => $region_code])->queryAll();
            if ($regions) {
                return $this->render('menu', ['regions' => $regions]);
            } else {
                return $this->render('_blank');
            }
        }catch(yii\db\Exception $ex){
            return $ex;
        }

    }
    // public function actionUnits($region_id){
    //     $model = UnitServices::find()->select(['services_id' => 'services_id','services_name' => 'services_name', 'with_pstc_hrdc'])->all();
         
    //     $region = Region::find()->where(['region_id' => $region_id])->one();
        
    //     if($region){
    //         return $this->render('__menu', ['model' => $model, 'region_id' => $region_id]);
    //     }else{
    //         throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
    //     }
       
    // }

    public function actionSubMenu($region_code,$service_id){
        $con = Yii::$app->db;
        $sql = "SELECT unit_name,unit_url FROM tbl_unit AS a LEFT OUTER JOIN tbl_region AS b ON a.`region_id` = b.`region_id`  WHERE `services_id` = :service_id AND b.region_code = :region_code";
        $menus = $con->createCommand($sql, [':region_code' => $region_code,':service_id' => $service_id])->queryAll();
        return $this->render('_submenu',['menus' => $menus, 'service_id' => $service_id, 'region_code' => $region_code]);
    }

    public function actionPstc($unit_id,$region_id){
        // $model = Pstc::find()->where(['region_id' => $region_id])->all();
        // $unit = Unit::find()->where(['unit_id' => $unit_id])->one();
        // $services = UnitUnitServices::find()->where(['services_id' => $unit->services_id])->one();
        // $region = Region::find()->where(['region_id' => $region_id])->one();
        $con = Yii::$app->db;
        $sql = "SELECT a.`pstc_id`, a.`pstc_name`, c.`services_name`, b.`unit_url`  FROM tbl_pstc AS a 
                LEFT JOIN tbl_unit AS b ON b.`region_id` = a.`region_id` 
                LEFT JOIN tbl_unit_services AS c ON c.`services_id` = b.`services_id` 
                WHERE a.`region_id` = :region_id AND b.`unit_id` = :unit_id AND c.`with_pstc_hrdc` = 1";
        $model = $con->createCommand($sql,[':region_id' => $region_id, ':unit_id' => $unit_id])->queryAll();
        if($model){
            return $this->render('__submenu',['model' => $model, 'region_id' => $region_id]);
        }else{
            throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
        }
        
    }

    public function actionFunctionalUnit(){
        return $this->render('functionalunit');
    }
}
