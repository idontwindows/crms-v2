<?php

namespace backend\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use yii\base\Exception;

use backend\models\TmpRating;
use backend\models\TmpImportance;

class ReportsController extends \yii\web\Controller
{
    // public function behaviors()
    // {
    //     return [
    //         'access' => [
    //             'class' => AccessControl::className(),
    //             'rules' => [
    //                 [
    //                     'actions' => ['error'],
    //                     'allow' => true,
    //                 ],
    //                 [
    //                     'actions' => [
    //                         'reports-api'
    //                     ],
    //                     'allow' => true,
    //                     'roles' => ['@'],
    //                 ],
    //             ],
    //         ],
    //         'verbs' => [
    //             'class' => VerbFilter::className(),
    //             'actions' => [
    //                 'logout' => ['post'],
    //             ],
    //         ],
    //     ];
    // }
    public function actionIndex()
    {   $regions = Yii::$app->user->identity->regions;
        $regions = json_decode($regions);
        //var_dump($regions);
        return $this->render('index',['region']);
    }
    public function actionReportsApi($unit_id,$datefrom,$dateto){
    
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        // if($unit_id == null && $datefrom == '' && $dateto == ''){
        //     return 0;
        // }

        if(isset($_GET['clienttype'])) $client_type = $_GET['clienttype'];

        $emptydata = [];
        $emptydata['unit'] = [];
        $emptydata['feedbacks'] = [];
        $emptydata['importance'] = [];
        $emptydata['comments'] = [];
        $emptydata['customer'] = [];
        $emptydata['nps'] = null;
        $emptydata['count'] = null;
        $emptydata['total_outstanding'] = 0;
        $emptydata['total_vs_outstanding'] =0;

        $con = Yii::$app->db;
        if(isset($_GET['drivers_id'])){
            try{
                $sqlRatings = 'CALL sp_rating_for_drivers(:datefrom,:dateto,:unit_id,0,:drivers_id,:clienttype)';
                $feedbacks = $con->createCommand($sqlRatings,[':datefrom' => $datefrom, ':dateto' => $dateto, 'unit_id' => $unit_id, ':drivers_id' => $_GET['drivers_id'], ':clienttype' => $client_type])->queryAll();
                $sqlRatings2 = 'CALL sp_rating(:datefrom,:dateto,:unit_id,1,:clienttype)';
                $importance = $con->createCommand($sqlRatings2,[':datefrom' => $datefrom, ':dateto' => $dateto, ':unit_id' => $unit_id,':clienttype' => $client_type])->queryAll();
                $sqlComments = 'SELECT DISTINCT a.`comment` AS `comments` FROM tbl_comment AS a INNER JOIN tbl_rating AS b ON b.customer_id = a.customer_id WHERE b.unit_id = :unit_id AND b.rating_date BETWEEN :datefrom AND :dateto AND b.drivers_id = :drivers_id';
                $comments = $con->createCommand($sqlComments,[':datefrom' => $datefrom, ':dateto' => $dateto, ':unit_id' => $unit_id, ':drivers_id' => $_GET['drivers_id']])->queryAll();
                $sqlCustomers = 'SELECT DISTINCT a.customer_id FROM tbl_customer AS a INNER JOIN tbl_rating AS b ON b.customer_id = a.customer_id WHERE b.unit_id = :unit_id AND b.rating_date BETWEEN :datefrom AND :dateto AND b.drivers_id = :drivers_id';
                $customers = $con->createCommand($sqlCustomers,[':datefrom' => $datefrom, ':dateto' => $dateto, ':unit_id' => $unit_id, ':drivers_id' => $_GET['drivers_id']])->queryAll();
                $sqlTotalUnsatisfactory = "SELECT DISTINCT a.`customer_id` FROM tbl_rating AS a INNER JOIN tbl_customer AS b ON b.`customer_id` = a.`customer_id` INNER JOIN `tbl_question_group_unit` AS c ON c.`question_group_unit_id` = a.`question_group_id` WHERE a.`rating_point` BETWEEN 1 AND 3 AND a.unit_id = :unit_id AND a.`rating_date` BETWEEN :datefrom AND :dateto AND a.`drivers_id` = :drivers_id AND c.`importance` = 0 AND IF(2 = :clienttype ,b.`client_type` = 2, IF(5 = :clienttype,b.`client_type` <> 2, b.`client_type` LIKE '%'))";
                $TotalUnsatisfactory = $con->createCommand($sqlTotalUnsatisfactory,[':datefrom' => $datefrom, ':dateto' => $dateto, ':unit_id' => $unit_id, ':drivers_id' => $_GET['drivers_id'], ':clienttype' => $client_type])->queryAll();
                $sqlVSscore = "SELECT COUNT(rating_point) AS vs_score FROM tbl_rating AS a INNER JOIN tbl_customer AS b ON b.`customer_id` = a.`customer_id` INNER JOIN `tbl_question_group_unit` AS c ON c.`question_group_unit_id` = a.`question_group_id` WHERE  a.rating_point = 5 AND a.unit_id = :unit_id AND a.rating_date BETWEEN :datefrom AND :dateto AND a.drivers_id = :drivers_id AND c.`importance` = 0 AND IF(2 = :clienttype ,b.`client_type` = 2, IF(5 = :clienttype,b.`client_type` <> 2, b.`client_type` LIKE '%'))";
                $TotalVSscore  = $con->createCommand($sqlVSscore,[':datefrom' => $datefrom, ':dateto' => $dateto, ':unit_id' => $unit_id, ':drivers_id' => $_GET['drivers_id'], ':clienttype' => $client_type])->queryOne();
                $sqlOutstadingscore = "SELECT COUNT(rating_point) AS outstanding_score FROM tbl_rating AS a INNER JOIN tbl_customer AS b ON b.`customer_id` = a.`customer_id` INNER JOIN `tbl_question_group_unit` AS c ON c.`question_group_unit_id` = a.`question_group_id` WHERE  a.rating_point = 4 AND a.unit_id = :unit_id AND a.rating_date BETWEEN :datefrom AND :dateto AND a.drivers_id = :drivers_id AND c.`importance` = 0 AND IF(2 = :clienttype ,b.`client_type` = 2, IF(5 = :clienttype,b.`client_type` <> 2, b.`client_type` LIKE '%'))";
                $TotalOutstadingscore  = $con->createCommand($sqlOutstadingscore,[':datefrom' => $datefrom, ':dateto' => $dateto, ':unit_id' => $unit_id, ':drivers_id' => $_GET['drivers_id'], ':clienttype' => $client_type])->queryOne();
            }catch(Yii\db\Exception $e){
                return $emptydata;
                //return $e;
            }
        }else{
            try{
                $sqlRatings = 'CALL sp_rating(:datefrom,:dateto,:unit_id,0,:clienttype)';
                $feedbacks = $con->createCommand($sqlRatings,[':datefrom' => $datefrom, ':dateto' => $dateto, ':unit_id' => $unit_id,':clienttype' => $client_type])->queryAll();
                $sqlRatings2 = 'CALL sp_rating(:datefrom,:dateto,:unit_id,1,:clienttype)';
                $importance = $con->createCommand($sqlRatings2,[':datefrom' => $datefrom, ':dateto' => $dateto, ':unit_id' => $unit_id,':clienttype' => $client_type])->queryAll();
                $sqlComments = "SELECT DISTINCT a.`comment` AS `comments` FROM tbl_comment AS a INNER JOIN tbl_rating AS b ON b.customer_id = a.customer_id INNER JOIN tbl_customer AS c ON a.customer_id = c.customer_id WHERE b.unit_id = :unit_id AND b.rating_date BETWEEN :datefrom AND :dateto AND IF(2 = :clienttype ,c.`client_type` = 2, IF(5 = :clienttype,c.`client_type` <> 2, c.`client_type` LIKE '%'))";
                $comments = $con->createCommand($sqlComments,[':datefrom' => $datefrom, ':dateto' => $dateto, ':unit_id' => $unit_id, ':clienttype' => $client_type])->queryAll();
                $sqlCustomers = "SELECT DISTINCT a.customer_id FROM tbl_customer AS a INNER JOIN tbl_rating AS b ON b.customer_id = a.customer_id WHERE b.unit_id = :unit_id AND b.rating_date BETWEEN :datefrom AND :dateto AND IF(2 = :clienttype ,a.`client_type` = 2, IF(5 = :clienttype,a.`client_type` <> 2, a.`client_type` LIKE '%'))";
                $customers = $con->createCommand($sqlCustomers,[':datefrom' => $datefrom, ':dateto' => $dateto, ':unit_id' => $unit_id, ':clienttype' => $client_type])->queryAll();
                $sqlTotalUnsatisfactory = "SELECT DISTINCT a.`customer_id` FROM tbl_rating AS a INNER JOIN tbl_customer AS b ON b.`customer_id` = a.`customer_id` INNER JOIN `tbl_question_group_unit` AS c ON c.`question_group_unit_id` = a.`question_group_id` WHERE a.`rating_point` BETWEEN 1 AND 3 AND a.unit_id = :unit_id AND a.`rating_date` BETWEEN :datefrom AND :dateto AND c.`importance` = 0 AND IF(2 = :clienttype ,b.`client_type` = 2, IF(5 = :clienttype,b.`client_type` <> 2, b.`client_type` LIKE '%'))";
                $TotalUnsatisfactory = $con->createCommand($sqlTotalUnsatisfactory,[':datefrom' => $datefrom, ':dateto' => $dateto, ':unit_id' => $unit_id, ':clienttype' => $client_type])->queryAll();
                $sqlVSscore = "SELECT COUNT(rating_point) AS vs_score FROM tbl_rating AS a INNER JOIN tbl_customer AS b ON b.`customer_id` = a.`customer_id` INNER JOIN `tbl_question_group_unit` AS c ON c.`question_group_unit_id` = a.`question_group_id` WHERE  a.rating_point = 5 AND a.unit_id = :unit_id AND a.rating_date BETWEEN :datefrom AND :dateto  AND c.`importance` = 0 AND IF(2 = :clienttype ,b.`client_type` = 2, IF(5 = :clienttype,b.`client_type` <> 2, b.`client_type` LIKE '%'))";
                $TotalVSscore  = $con->createCommand($sqlVSscore,[':datefrom' => $datefrom, ':dateto' => $dateto, ':unit_id' => $unit_id, ':clienttype' => $client_type])->queryOne();
                $sqlOutstadingscore = "SELECT COUNT(rating_point) AS outstanding_score FROM tbl_rating AS a INNER JOIN tbl_customer AS b ON b.`customer_id` = a.`customer_id` INNER JOIN `tbl_question_group_unit` AS c ON c.`question_group_unit_id` = a.`question_group_id` WHERE  a.rating_point = 4 AND a.unit_id = :unit_id AND a.rating_date BETWEEN :datefrom AND :dateto  AND c.`importance` = 0 AND IF(2 = :clienttype ,b.`client_type` = 2, IF(5 = :clienttype,b.`client_type` <> 2, b.`client_type` LIKE '%'))";
                $TotalOutstadingscore  = $con->createCommand($sqlOutstadingscore,[':datefrom' => $datefrom, ':dateto' => $dateto, ':unit_id' => $unit_id, ':clienttype' => $client_type])->queryOne();
            }catch(Yii\db\Exception $e){
                return $emptydata;
                //return $e;
            }
        }
      
        $sqlUnits = 'SELECT * FROM tbl_unit WHERE unit_id = :unit_id';
        $units = $con->createCommand($sqlUnits,[':unit_id' => $unit_id])->queryAll();
        $sqlNps = 'CALL sp_nps_ratings(:datefrom,:dateto,:client_type,:age,:unit_id)';
        $Nps = $con->createCommand($sqlNps,[':datefrom' => $datefrom, ':dateto' => $dateto, ':client_type' => 0,':age' => 'All', ':unit_id' => $unit_id])->queryAll();
        //return $this->render('index',[]);
        $data = [];
        $count = count($feedbacks) + count($importance);
        // $count_devide = $count / 2;
        // $feedbacks = array_slice($ratings,0,$count_devide + 1,false);
        // $importance = array_slice($ratings,$count_devide + 1,$count,false);

        $data['unit'] = $units;
        $data['feedbacks'] = $feedbacks;
        $data['importance'] = $importance;
        $data['comments'] = $comments;
        $data['customer'] = $customers;
        $data['nps'] = $Nps;
        $data['count'] = intval($count);
        $data['total_outstanding'] = count($customers) - count($TotalUnsatisfactory);
        $data['total_vs_outstanding'] = (int)$TotalOutstadingscore['outstanding_score'] + (int)$TotalVSscore['vs_score'];

       return $data;
    }
    public function actionUnitApi($region_id){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $con = Yii::$app->db;
        //$sql = "SELECT a.unit_id,a.services_id,concat('DOST-',UPPER(b.region_code),' ',a.unit_name) as unit_name FROM tbl_unit as a INNER join tbl_region as b on b.region_id = a.region_id WHERE a.`region_id` IN (" . $this->getOrRegions() . ') AND is_disabled = 0 ORDER BY b.order ASC';
        $sql = "SELECT a.unit_id,a.services_id,concat('DOST-',UPPER(b.region_code),' ',a.unit_name) as unit_name FROM tbl_unit as a INNER join tbl_region as b on b.region_id = a.region_id WHERE a.`region_id` IN (" . $region_id . ') AND is_disabled = 0 ORDER BY b.order ASC';
        $unit = $con->createCommand($sql)->queryAll();
        return $unit;
    }
    public function getOrRegions(){
        $userregions = Yii::$app->user->identity->regions;
        $regions = json_decode($userregions);
        $string = "";
        foreach($regions as $region){
            if(count($regions) > 1){
                $string.= ','. $region->region_id;
            }
            $string.= ','. $region->region_id;
        }
        //$result = str_replace('*','OR',$string);

        return substr($string,1);
    }
    public function actionExporttoexcel($unit_id,$datefrom,$dateto){
        $con = Yii::$app->db;
        $sqlRatings = 'CALL sp_rating(:datefrom,:dateto,:unit_id)';
        $ratings = $con->createCommand($sqlRatings,[':datefrom' => $datefrom, ':dateto' => $dateto, 'unit_id' => $unit_id])->queryAll();
        $sqlUnit = 'SELECT a.`unit_id`,a.`unit_name`,a.`region_id`,b.`region_name`,b.`region_code` FROM tbl_unit AS a INNER JOIN tbl_region AS b ON b.`region_id` = a.`region_id` WHERE unit_id = :unit_id';
        $Units = $con->createCommand($sqlUnit,['unit_id' => $unit_id])->queryOne();
        $sqlCustomers = 'SELECT DISTINCT a.customer_id FROM tbl_customer AS a INNER JOIN tbl_rating AS b ON b.customer_id = a.customer_id WHERE b.unit_id = :unit_id AND b.rating_date BETWEEN :datefrom AND :dateto';
        $customers = $con->createCommand($sqlCustomers,[':datefrom' => $datefrom, ':dateto' => $dateto, 'unit_id' => $unit_id])->queryAll();
        // foreach($ratings as $rating){
        //     echo $rating['question'];
        // }
        $date = date('d-m-y-'.substr((string)microtime(), 1, 8));
        $date = str_replace(".", "", $date);
        $filename = 'crms_'.$date.".xlsx";
        \PhpOffice\PhpSpreadsheet\Shared\File::setUseUploadTempDirectory(true);
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->mergeCells('A1:F1');
        $sheet->mergeCells('A2:F2');
        $sheet->mergeCells('A3:F3');
        $sheet->setCellValue('A1', 'REGION: '. $Units['region_name']);
        $sheet->setCellValue('A2', 'UNIT: '. $Units['unit_name']);
        $sheet->setCellValue('A3', 'DATE: '. $datefrom . ' to ' . $dateto);
        $sheet->setCellValue('A5', 'ATTRIBUTES');
        $sheet->setCellValue('B5', 'Outstanding');
        $sheet->setCellValue('C5', 'Very Satisfactory');
        $sheet->setCellValue('D5', 'Satisfactory');
        $sheet->setCellValue('E5', 'Unsatisfactory');
        $sheet->setCellValue('F5', 'Poor');
        $sheet->mergeCells('A12:F12');
        $sheet->setCellValue('A12', 'RESPONDENT: '.count($customers));
        $i = 6;
        foreach($ratings as $rating){           
            $sheet->setCellValue('A'. $i, $rating['question']);        
            $sheet->setCellValue('B'. $i, $rating['rating5']);
            $sheet->setCellValue('C'. $i, $rating['rating4']);
            $sheet->setCellValue('D'. $i, $rating['rating3']);
            $sheet->setCellValue('E'. $i, $rating['rating2']);
            $sheet->setCellValue('F'. $i, $rating['rating1']);
            $i++;
        }
        try {
        $writer = new Xlsx($spreadsheet);
        ob_end_clean();
        $writer->save($filename);
        $content = file_get_contents($filename);
        }catch(Exception $e){
            exit($e->getMessage());
        }
        header("Content-Disposition: attachment; filename=".$filename);

        unlink($filename);
        exit($content);
    }
    public function actionExport($unit_id,$datefrom,$dateto){
        $con = Yii::$app->db;
        $sqlRatings = 'CALL sp_rating(:datefrom,:dateto,:unit_id,0)';
        $feedbacks = $con->createCommand($sqlRatings,[':datefrom' => $datefrom, ':dateto' => $dateto, 'unit_id' => $unit_id])->queryAll();
        $sqlRatings2 = 'CALL sp_rating(:datefrom,:dateto,:unit_id,1)';
        $importance = $con->createCommand($sqlRatings2,[':datefrom' => $datefrom, ':dateto' => $dateto, 'unit_id' => $unit_id])->queryAll();
        $sqlUnit = 'SELECT a.`unit_id`,a.`unit_name`,a.`region_id`,b.`region_name`,b.`region_code` FROM tbl_unit AS a INNER JOIN tbl_region AS b ON b.`region_id` = a.`region_id` WHERE unit_id = :unit_id';
        $Units = $con->createCommand($sqlUnit,['unit_id' => $unit_id])->queryOne();
        $sqlCustomers = 'SELECT DISTINCT a.customer_id FROM tbl_customer AS a INNER JOIN tbl_rating AS b ON b.customer_id = a.customer_id WHERE b.unit_id = :unit_id AND b.rating_date BETWEEN :datefrom AND :dateto';
        $customers = $con->createCommand($sqlCustomers,[':datefrom' => $datefrom, ':dateto' => $dateto, 'unit_id' => $unit_id])->queryAll();
        $sqlNps = 'CALL sp_nps_ratings(:datefrom,:dateto,:client_type,:age,:unit_id)';
        $Nps = $con->createCommand($sqlNps,[':datefrom' => $datefrom, ':dateto' => $dateto, ':client_type' => 0,':age' => 'All', ':unit_id' => $unit_id])->queryAll();
        // foreach($ratings as $rating){
        //     echo $rating['question'];
        // }
        $date = date('d-m-y-'.substr((string)microtime(), 1, 8));
        $date = str_replace(".", "", $date);
        $filename = 'crms_'.$date.".xlsx";
        $spreadsheet = IOFactory::load('../../web/template/CusSat-Index-Computation-2017.xls');
        $sheet = $spreadsheet->getActiveSheet();
        // $sheet->mergeCells('A1:F1');
        // $sheet->mergeCells('A2:F2');
        // $sheet->mergeCells('A3:F3');
        // $sheet->setCellValue('A1', 'REGION: '. $Units['region_name']);
        // $sheet->setCellValue('A2', 'UNIT: '. $Units['unit_name']);
        // $sheet->setCellValue('A3', 'DATE: '. $datefrom . ' to ' . $dateto);
        // $sheet->setCellValue('A5', 'ATTRIBUTES');
        // $sheet->setCellValue('B5', 'Outstanding');
        // $sheet->setCellValue('C5', 'Very Satisfactory');
        // $sheet->setCellValue('D5', 'Satisfactory');
        // $sheet->setCellValue('E5', 'Unsatisfactory');
        // $sheet->setCellValue('F5', 'Poor');
        // $sheet->mergeCells('A12:F12');
        // $sheet->setCellValue('A12', 'RESPONDENT: '.count($customers));
        //$count = count($ratings);
        //$count_devide = $count / 2;
        $sheet->setCellValue('B5', 'FUNCTIONAL UNIT: '. $Units['unit_name']);
        $sheet->setCellValue('B6', 'FOR THE PERIOD: '. $datefrom . ' to ' . $dateto);
        $i = 11;
        //$item1 = array_slice($ratings,0,$count_devide + 1,true);
        foreach($feedbacks as $rating){           
            $sheet->setCellValue('B'. $i, $rating['question']);        
            $sheet->setCellValue('D'. $i, $rating['rating5']);
            $sheet->setCellValue('F'. $i, $rating['rating4']);
            $sheet->setCellValue('H'. $i, $rating['rating3']);
            $sheet->setCellValue('J'. $i, $rating['rating2']);
            $sheet->setCellValue('L'. $i, $rating['rating1']);
            $i++;
        }
        $j = 19;
        //$item2 = array_slice($ratings,$count_devide + 1,$count,true);
        foreach($importance as $rating){           
            $sheet->setCellValue('B'. $j, $rating['question']);        
            $sheet->setCellValue('D'. $j, $rating['rating5']);
            $sheet->setCellValue('F'. $j, $rating['rating4']);
            $sheet->setCellValue('H'. $j, $rating['rating3']);
            $sheet->setCellValue('J'. $j, $rating['rating2']);
            $sheet->setCellValue('L'. $j, $rating['rating1']);
            $j++;
        }

        foreach($Nps as $Np){
            $sheet->setCellValue('C46', $Np['score1']);        
            $sheet->setCellValue('D46', $Np['score2']);
            $sheet->setCellValue('E46', $Np['score3']);
            $sheet->setCellValue('F46', $Np['score4']);
            $sheet->setCellValue('G46', $Np['score5']);
            $sheet->setCellValue('H46', $Np['score6']);
            $sheet->setCellValue('I46', $Np['score7']);
            $sheet->setCellValue('J46', $Np['score8']);
            $sheet->setCellValue('K46', $Np['score9']);
            $sheet->setCellValue('L46', $Np['score10']);
        }
        $sheet->setCellValue('B23','');  
        try {
        $writer = new Xlsx($spreadsheet);
        ob_end_clean();
        $writer->save($filename);
        $content = file_get_contents($filename);
        }catch(Exception $e){
            exit($e->getMessage());
        }
        header("Content-Disposition: attachment; filename=".$filename);

        unlink($filename);
        exit($content);
    }
    public function actionReport1(){
        return $this->render('report2');
    }
    public function actionGetDriver($region_id){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $con = Yii::$app->db;
        $sql = 'SELECT * FROM tbl_drivers WHERE region_id = :region_id';
        $drivers = $con->createCommand($sql,[':region_id' => $region_id])->queryAll();
        return $drivers;
    }

    public function acttionSatisfactionIndex(){
        $con = Yii::$app->db;
        $sql1 = 'CALL sp_rating2(:date_from,:date_to,:unit_id,:attribute_id,:region_id,:pstc_id,:driver_id)';
        $rating = $con->createCommand($sql1,[
            ':date_from' => '2022-07-10',
            ':date_to' => '2022-07-10',
            ':unit_id ',
            ':attribute_id',
            ':region_id',
            ':pstc_id',
            ':driver_id'
            ])->queryOne();
    }
}
