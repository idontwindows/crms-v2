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
        $sqlRatings = 'CALL sp_rating(:datefrom,:dateto,:unit_id)';
        $ratings = $con->createCommand($sqlRatings,[':datefrom' => $datefrom, ':dateto' => $dateto, 'unit_id' => $unit_id])->queryAll();
        $sqlComments = 'SELECT DISTINCT a.`comment` AS `comments` FROM tbl_comment AS a INNER JOIN tbl_rating AS b ON b.customer_id = a.customer_id WHERE b.unit_id = :unit_id AND b.rating_date BETWEEN :datefrom AND :dateto';
        $comments = $con->createCommand($sqlComments,[':datefrom' => $datefrom, ':dateto' => $dateto, 'unit_id' => $unit_id])->queryAll();
        $sqlCustomers = 'SELECT DISTINCT a.customer_id FROM tbl_customer AS a INNER JOIN tbl_rating AS b ON b.customer_id = a.customer_id WHERE b.unit_id = :unit_id AND b.rating_date BETWEEN :datefrom AND :dateto';
        $customers = $con->createCommand($sqlCustomers,[':datefrom' => $datefrom, ':dateto' => $dateto, 'unit_id' => $unit_id])->queryAll();
        
        //return $this->render('index',[]);
        $data = [];
        $data['ratings'] = $ratings;
        $data['comments'] = $comments;
        $data['customer'] = $customers;

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
        $filename = 'crms_'.$date.".xls";
        $spreadsheet = IOFactory::load('../../web/template/crms-template_001.xlsx');
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
        $i = 6;
        foreach($ratings as $rating){           
            // $sheet->setCellValue('A'. $i, $rating['question']);        
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
}
