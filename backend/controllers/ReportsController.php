<?php

namespace backend\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use yii\base\Exception;

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
        $con = Yii::$app->db;
        $sqlRatings = 'CALL sp_rating(:datefrom,:dateto,:unit_id,0)';
        $feedbacks = $con->createCommand($sqlRatings,[':datefrom' => $datefrom, ':dateto' => $dateto, 'unit_id' => $unit_id])->queryAll();
        $sqlRatings2 = 'CALL sp_rating(:datefrom,:dateto,:unit_id,1)';
        $importance = $con->createCommand($sqlRatings2,[':datefrom' => $datefrom, ':dateto' => $dateto, 'unit_id' => $unit_id])->queryAll();
        $sqlComments = 'SELECT DISTINCT a.`comment` AS `comments` FROM tbl_comment AS a INNER JOIN tbl_rating AS b ON b.customer_id = a.customer_id WHERE b.unit_id = :unit_id AND b.rating_date BETWEEN :datefrom AND :dateto';
        $comments = $con->createCommand($sqlComments,[':datefrom' => $datefrom, ':dateto' => $dateto, 'unit_id' => $unit_id])->queryAll();
        $sqlCustomers = 'SELECT DISTINCT a.customer_id FROM tbl_customer AS a INNER JOIN tbl_rating AS b ON b.customer_id = a.customer_id WHERE b.unit_id = :unit_id AND b.rating_date BETWEEN :datefrom AND :dateto';
        $customers = $con->createCommand($sqlCustomers,[':datefrom' => $datefrom, ':dateto' => $dateto, 'unit_id' => $unit_id])->queryAll();
        $sqlNps = 'CALL sp_nps_ratings(:datefrom,:dateto,:client_type,:age,:unit_id)';
        $Nps = $con->createCommand($sqlNps,[':datefrom' => $datefrom, ':dateto' => $dateto, ':client_type' => 0,':age' => 'All', ':unit_id' => $unit_id])->queryAll();
        //return $this->render('index',[]);
        $data = [];
        $count = count($feedbacks) + count($importance);
        // $count_devide = $count / 2;
        // $feedbacks = array_slice($ratings,0,$count_devide + 1,false);
        // $importance = array_slice($ratings,$count_devide + 1,$count,false);
        $data['feedbacks'] = $feedbacks;
        $data['importance'] = $importance;
        $data['comments'] = $comments;
        $data['customer'] = $customers;
        $data['nps'] = $Nps;
        $data['count'] = intval($count);

       return $data;
    }
    public function actionUnitApi(){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $con = Yii::$app->db;
        $sql = "SELECT a.unit_id, concat('DOST-',UPPER(b.region_code),' ',a.unit_name) as unit_name FROM tbl_unit as a INNER join tbl_region as b on b.region_id = a.region_id WHERE" . $this->getOrRegions() . ' ORDER BY b.order ASC';
        $unit = $con->createCommand($sql)->queryAll();
        return $unit;
    }
    public function getOrRegions(){
        $userregions = Yii::$app->user->identity->regions;
        $regions = json_decode($userregions);
        $string = "";
        foreach($regions as $region){
            if(count($regions) > 1){
                $string.= ' OR a.`region_id` = '. $region->region_id;
            }
            $string.= ' OR a.`region_id` = '. $region->region_id;
        }
        //$result = str_replace('*','OR',$string);

        return substr($string,3);
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
    public function actionReport2(){
        return $this->render('report2');
    }
}
