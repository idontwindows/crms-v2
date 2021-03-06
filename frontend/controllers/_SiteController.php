<?php

namespace frontend\controllers;

use common\models\Comment;
use common\models\CreateCertificate;
use common\models\Customer;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Rating;
use common\models\Message;
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
                        'actions' => ['logout'],
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
    //     $sql1 = 'SELECT * FROM `tbl_event` WHERE `event_id` =' . $id . ' AND `is_disabled` = 0';

    //     try {
    //         $title = $con->createCommand($sql1)->queryOne();
    //         if (!$title) {
    //             throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
    //         }
    //     } catch (\yii\db\Exception $exception) {
    //         throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
    //     }
    //     $sql2 = 'SELECT * FROM `tbl_question_group` WHERE `event_id` =' . $id;

    //     try {
    //         $groups = $con->createCommand($sql2)->queryAll();
    //         return $this->render('index', ['groups' => $groups, 'title' => $title]);
    //     } catch (\yii\db\Exception $exception) {
    //         throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
    //     }
    // }
    public function actionIndex($id)
    {
        $con = Yii::$app->db;
        //$id = base64_decode(base64_decode($id));
        $sql1 = 'SELECT * FROM `tbl_unit` WHERE `unit_id` =' . $id . ' AND `is_disabled` = 0';

        try {
            $title = $con->createCommand($sql1)->queryOne();
            if (!$title) {
                throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
            }
        } catch (\yii\db\Exception $exception) {
            throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
        }
        $sql2 = 'SELECT * FROM `tbl_question_group_unit` WHERE `unit_id` =' . $id;

        try {
            $groups = $con->createCommand($sql2)->queryAll();
            return $this->render('index', ['groups' => $groups, 'title' => $title]);
        } catch (\yii\db\Exception $exception) {
            throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
        }
    }
    /**
     * @var mixed $id must convert to base64 2x
     */
    public function actionPostRating()
    {
        $con = Yii::$app->db;
        $id = $_GET['id'];
        //$sql1 = 'SELECT * FROM `tbl_event` WHERE `event_id` =' . base64_decode(base64_decode($id));
        $sql1 = 'SELECT a.`event_id` AS `event_id`,
                        a.`event_name` AS `event_name`,
                        a.`is_disabled` AS `is_disabled`,
                        a.`is_with_certificate` AS `is_with_certificate`,
                        a.`certificate_id` AS `certificate_id`,
                        a.`event_date` AS `event_date`,
                        a.`message_id` AS `message_id`,
                        b.`certificate_name` AS `certificate_name`,
                        b.`font_size` AS `font_size`,
                        b.`y_axis` AS `y_axis`
                FROM `tbl_event` AS a 
                LEFT JOIN tbl_certificate AS b 
                ON b.`certificate_id` = a.`certificate_id`
                WHERE a.`event_id` =' . base64_decode(base64_decode($id));

        try {
            $title = $con->createCommand($sql1)->queryOne();
        } catch (\yii\db\Exception $exception) {
            throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
        }

        $id = $_GET['id'];
        $customerId = $this->getLastCustomerId();
        $customerId = $customerId[0]['customer_id'] + 1;


        $sql2 = 'SELECT * FROM `tbl_question_group` WHERE `event_id` =' . base64_decode(base64_decode($id));
        try {
            $groups = $con->createCommand($sql2)->queryAll();
        } catch (\yii\db\Exception $exception) {
            throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
        }
        
        $certificate_id = $title['message_id'];
        $message = $this->getMessage($certificate_id);
        $message = $message[0]['message'];
        //$message = '<p><b><i>Lorem ipsum dolor sit amet, </i></b></p><p>consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu </p><p>fugiat nulla pariatur.<br></p>';

        $post = function ($customerId, $groups, $id) {
            try {
                $customer = new Customer();
                $customer->customer_id = $customerId;
                $customer->customer_name = $_POST['customer_name'];
                $customer->customer_email = $_POST['customer_email'];
                $customer->date_created = date("Y-m-d H:i:s");
                if ($customer->save(false)) {
                    $comment = new Comment();
                    $comment->customer_id = $customerId;
                    $comment->comment = $_POST['comments'];
                    $comment->other_important_attrib = $_POST['other_important_attrib'];
                    $comment->save(false);
                    foreach ($groups as $group) {
                        $j = 0;
                        foreach ($_POST['rating'][$group['question_group_id']] as $rating) {
                            $rating = new Rating();
                            $rating->customer_id = $customerId;
                            $rating->event_id = base64_decode(base64_decode($id));
                            $rating->question_group_id = base64_decode(base64_decode($_POST['groupId'][$group['question_group_id']][$j]));
                            $rating->question_id = base64_decode(base64_decode($_POST['questionId'][$group['question_group_id']][$j]));
                            $rating->rating_point = $_POST['rating'][$group['question_group_id']][$j];
                            $rating->rating_date = date("Y-m-d");
                            $rating->save(false);
                            $j++;
                        }
                    }
                    return $this->render('_thankyou');
                }
            } catch (yii\base\ErrorException $exception) {
                throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
            }
        };
        try{
            $email = Yii::$app->mailer->compose()
            ->setFrom([Yii::$app->params['supportEmail'] => 'DOST-IX'])
            ->setTo($_POST['customer_email'])
            ->setSubject($title['event_name'])
            ->setHtmlBody($message);
        if ($title['is_with_certificate'] == 1) {
            $certImageName = $_POST['customer_name'] . '_' . $title['event_name'] . '_ECertificate';
            $image = $title['certificate_name'];
            $font_size = $title['font_size'];
            $y_axis = $title['y_axis'];
            $this->generateCertificate($_POST['customer_name'], $image, $certImageName,$font_size,$y_axis);
            $email->attach('attachment/' . $certImageName . '.jpg');
            if ($email->send()) {
                $post($customerId, $groups, $id);
            }
        }
        if ($title['is_with_certificate'] == 0){
            if($email->send()){
                $post($customerId, $groups, $id);
            }
        } 
        }catch(ErrorException $e){
            die($e);
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
        $sql = 'SELECT a.`event_id`,
                       a.`event_name`,
                       a.`event_date`,
                       b.`question_group_id`,
                       b.`question_group_name`,
                       c.`question_id`,
                       c.`question`
                FROM tbl_event AS a 
                INNER JOIN tbl_question_group AS b ON b.`event_id` = a.`event_id` 
                INNER JOIN tbl_question AS c ON c.`quuestion_group_id` = b.`question_group_id`';
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

    public function generateCertificate($name, $image, $imageName,$font_size,$y_axis)
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
}
