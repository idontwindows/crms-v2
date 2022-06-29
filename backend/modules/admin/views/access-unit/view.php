<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use common\models\Services;
use common\models\ServiceUnit;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = 'Assign Unit: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Unit Access', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$this->registerCss('.ms-container {
    width: 100%;
}
.ms-container .ms-selectable .ms-list {
    height: 500px;
}
.ms-container .ms-selection .ms-list {
    height: 500px;
}');
$this->registerJs('$("#my-select").multiSelect({
    selectableHeader: "<b>Available Units:</b>",
    selectionHeader: "<b>Assigned Units:</b>",
    selectableOptgroup: true,
    afterSelect: function(values){
        alert("Select value: "+values);
      },
});');



?>
<div class="user-view">

<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
    <select multiple="multiple" id="my-select" name="my-select[]">
    <?php 
    $services = Services::find()->all();
    foreach ($services as $service){
        echo '<optgroup label="'.$service->services_name.'">';
        $serviceunits = ServiceUnit::find()->where(['services_id'=> $service->services_id,'is_child' => 0])->all();
        foreach($serviceunits as $serviceunit){
            echo '<option value="'.$serviceunit->service_unit_id.'">'. $serviceunit->service_unit_name .'</option>';
        }
        
    } 
    ?>
</optgroup>
    </select>
    </div>
    <div class="col-md-1"></div>
</div>


</div>
