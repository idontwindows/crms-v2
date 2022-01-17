<?php

use yii\widgets\ActiveForm;
use yii\bootstrap4\Modal;
//use kartik\rating\StarRating;
/* @var $this yii\web\View */

if (
    isset($_SERVER['HTTPS']) &&
    ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
    isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
    $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https'
) {
    $protocol = 'https://';
} else {
    $protocol = 'http://';
}
$serveruri = $protocol . "$_SERVER[HTTP_HOST]";

//$this->registerCssFile('@web/css/csf.css');
$this->title = 'My Yii Application';

$script1 = 'window.history.forward();';
$this->registerJs($script1, yii\web\View::POS_END, '');

// $script2 = '$(window).on("load",function(){
//     $(".spanner").fadeOut("slow");
// });';

// $script2 = 'window.onload = function(){
//     $(".spanner").fadeOut("slow");
// }';

//@var string $script3 for button back
$script3 = "$(document).ready(function() {
                $('#btn-back').click(function() {
                    window.location.replace('" . $serveruri . '/region/' . $title["region_code"] . "');
                });
            });";
//$this->registerJs($script2, yii\web\View::POS_END, '');
$this->registerJs($script3, yii\web\View::POS_END, '');
$this->registerJsFile('/js/signature_pad.min.js', ['position' => \yii\web\View::POS_END]);
$this->registerJsFile('/js/site.js', ['position' => \yii\web\View::POS_END]);
$this->registerJsFile('/js/sweetalert.min.js', ['position' => \yii\web\View::POS_END]);
$this->registerCss(".modal {background-color: rgba(0, 0, 0,0.5);} .show {display: block;}");
$this->registerCss('.modal-confirm {		
                        color: #434e65;
                        width: 525px;
                    }
                    .modal-confirm .modal-content {
                        padding: 20px;
                        font-size: 16px;
                        border-radius: 5px;
                        border: none;
                    }
                    @media (max-width:390px) {
                        .modal-confirm .modal-content {
                            width:360px;
                        }
                    }
                    @media (max-width:360px) {
                        .modal-confirm .modal-content {
                            width:345px;
                        }
                    }
                    .modal-confirm .modal-header {
                        background: #47c9a2;
                        border-bottom: none;   
                        position: relative;
                        text-align: center;
                        margin: -20px -20px 0;
                        border-radius: 5px 5px 0 0;
                        padding: 35px;
                    }
                    .modal-confirm h4 {
                        text-align: center;
                        font-size: 36px;
                        margin: 10px 0;
                    }
                    .modal-confirm .form-control, .modal-confirm .btn {
                        min-height: 40px;
                        border-radius: 3px; 
                    }
                    .modal-confirm .close {
                        position: absolute;
                        top: 15px;
                        right: 15px;
                        color: #fff;
                        text-shadow: none;
                        opacity: 0.5;
                    }
                    .modal-confirm .close:hover {
                        opacity: 0.8;
                    }
                    .modal-confirm .icon-box {
                        color: #fff;		
                        width: 95px;
                        height: 95px;
                        display: inline-block;
                        border-radius: 50%;
                        z-index: 9;
                        border: 5px solid #fff;
                        padding: 15px;
                        text-align: center;
                    }
                    .modal-confirm .icon-box i {
                        font-size: 64px;
                        margin: -4px 0 0 -4px;
                    }
                    .modal-confirm.modal-dialog {
                        margin-top: 80px;
                    }
                    .modal-confirm .btn, .modal-confirm .btn:active {
                        color: #fff;
                        border-radius: 4px;
                        background: #eeb711 !important;
                        text-decoration: none;
                        transition: all 0.4s;
                        line-height: normal;
                        border-radius: 30px;
                        margin-top: 10px;
                        padding: 6px 20px;
                        border: none;
                    }
                    .modal-confirm .btn:hover, .modal-confirm .btn:focus {
                        background: #eda645 !important;
                        outline: none;
                    }
                    .modal-confirm .btn span {
                        margin: 1px 3px 0;
                        float: left;
                    }
                    .modal-confirm .btn i {
                        margin-left: 1px;
                        font-size: 20px;
                        float: right;
                    }
                    .trigger-btn {
                        display: inline-block;
                        margin: 100px auto;
                    }');
// $this->registerCss('#signature{
//                         border: 1px solid #ddd;
//                         width: 500px;
//                     }
//                     @media (max-width:390px) {
//                         #signature{
//                             border: 1px solid #ddd;
//                             width: 300px;
//                         }
//                     }');
?>
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
<div class="site-csf">
    <?php $form = ActiveForm::begin([
        //'id' => 'smileys',
        'id' => 'submit-rating',
        'action' => false,
        'action' => ['post-rating', 'id' => $_GET['id']],
        //'options' => ['onsubmit' => 'return validate()'],
    ]); ?>
    <!-- <form id="smileys" ng-submit="submit()">
        <input type="hidden" name="_csrf-frontend" value="{{csrfToken}}" autocomplete="off"> -->
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div class="card mb-3 mt-0 border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-center">
                        <img src="/images/dostlogo.png" class="rounded float-left w-25" alt="...">
                        <div class="float-left ml-3  head-title">
                            <h1 class="header-title mb-0"><b><span class="text-primary">D</span>EPARTMENT</b></h1>
                            <h1 class="header-title mb-0"><b><span class="text-primary">O</span>F</b></h1>
                            <h1 class="header-title mb-0"><b><span class="text-primary">S</span>CIENCE AND</b></h1>
                            <h1 class="header-title mb-0"><b><span class="text-primary">T</span>ECHNOLOGY</b></h1>
                        </div>
                    </div>
                    <h2 class="d-flex align-items-center justify-content-center csf-title">CUSTOMER SATISFACTION FEEDBACK</h2>
                </div>
            </div>
            <div class="card mb-3 mt-0 border-0">
                <div class="card-body">
                    <h4 class="card-title"><?= $title['unit_name'] ?></h4>
                    <p class="card-text">This questionaire aims to solicit your honest assessment of our <?= strtolower($title['unit_name']) ?> services.
                        Please take a minute in filling out this form and help us serve you better. </p>
                    <div class="form-group form-email">
                        <label for="txtEmail"><b>Email</b> (<span class="text-info">Optional</span>)</label>
                        <input type="text" class="form-control" id="txtEmail" name="customer_email" placeholder="Type your email here..." autofocus="" aria-required="true" aria-invalid="">
                        <div class="invalid-feedback invalid-feedback-email"></div>
                    </div>
                    <!--                     
                    <div class="form-group">
                        <label for="txtDate"><b>Date</b> (<span class="text-danger">Required</span>)</label>
                        <div class="datepicker date input-group">
                            <input type="text" placeholder="Choose Date" class="form-control" id="txtDate" required>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                    </div>
                    -->
                    <div class="form-group form-name">
                        <label for="txtName"><b>Name</b> (<span class="text-info">Optional</span>)</label>
                        <input type="text" class="form-control" id="txtName" name="customer_name" placeholder="Type your name here..." aria-required="true" aria-invalid="">
                        <div class="invalid-feedback invalid-feedback-name"></div>
                    </div>
                    <div class="row">
                        <div class="form-group form-client-type col-md-6">
                            <label for="select-gender"><b>Client type</b> (<span class="text-danger">Required</span>)</label>
                            <select name="customer_client_type" id="select-client-type" class="form-control">
                                <option value="" disabled selected>Select Client type...</option>
                                <option value="1">General Public</option>
                                <option value="2">Internal Employees</option>
                                <option value="3">Governement Employees</option>
                                <option value="4">Businesses/Organization</option>
                            </select>
                        </div>
                        <div class="form-group form-gender col-md-6">
                            <label for="select-gender"><b>Gender</b> (<span class="text-danger">Required</span>)</label>
                            <select name="customer_gender" id="select-gender" class="form-control">
                                <option value="" disabled selected>Select gender...</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                        <div class="form-group form-age col-md-6">
                            <label for="select-age"><b>Age Group</b> (<span class="text-danger">Required</span>)</label>
                            <select name="customer_age" id="select-age" class="form-control">
                                <option value="" disabled selected>Select age group...</option>
                                <option value="15-19">15-19</option>
                                <option value="20-29">20-29</option>
                                <option value="30-39">30-39</option>
                                <option value="40-49">40-49</option>
                                <option value="50-59">50-59</option>
                                <option value="60-69">60-69</option>
                                <option value="70-79">70-79</option>
                                <option value="80+">80+</option>
                            </select>
                        </div>
                        <div class="form-group form-client-type col-md-6">
                            <label for="select-info"><b>Other Information</b> (<span class="text-info">Optional</span>)</label>
                            <select name="customer_other_info" id="select-other-info" class="form-control">
                                <option value="" disabled selected>Select info...</option>
                                <option value="1">Person with disabilities</option>
                                <option value="2">Pregnant woman</option>
                                <option value="3">Senior Citizen</option>
                            </select>
                        </div>
                    </div>

                </div>
            </div>
            <?php $g = 0; ?>
            <?php foreach ($groups as $group) { ?>
                <?php
                $con = Yii::$app->db;
                $sql1 = 'SELECT a.`unit_id`,
                                a.`unit_name`,
                                a.`date_created`,
                                b.`question_group_unit_id`,
                                b.`question_group_unit_name`,
                                c.`question_unit_id`,
                                c.`question`
                            FROM tbl_unit AS a 
                            INNER JOIN tbl_question_group_unit AS b ON b.`unit_id` = a.`unit_id` 
                            INNER JOIN tbl_question_unit AS c ON c.`question_group_unit_id` = b.`question_group_unit_id`
                            WHERE a.`unit_id` =' . base64_decode(base64_decode($_GET['id'])) . ' AND c.`question_group_unit_id`=' . $group['question_group_unit_id'];
                try {
                    $questions = $con->createCommand($sql1)->queryAll();
                } catch (\yii\db\Exception $exception) {
                    //throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
                    return $exception;
                }

                ?>
                <div class="card mb-3 border-0">
                    <div class="card-header">
                        <b><?= $group['question_group_unit_name'] ?></b> (<span class="text-danger">Required</span>)
                    </div>
                    <ul class="list-group list-group-flush">
      
                        <?php 
                        $count = count($questions);
                        $count_devide = intval($count / 2);
                        $q = 0; 
                        ?>
                        <?php foreach ($questions as $question) { ?>
                            <li class="list-group-item">
                                <div class="form-group">
                                    <div class="d-flex align-items-center justify-content-center question-description">
                                        <b><?= $question['question'] ?></b>
                                        <input type="hidden" id="custId" name="questionId[<?= $group['question_group_unit_id'] ?>][<?= $q ?>]" value="<?= base64_encode(base64_encode($question['question_unit_id'])) ?>">
                                        <input type="hidden" id="groupId" name="groupId[<?= $group['question_group_unit_id'] ?>][<?= $q ?>]" value="<?= base64_encode(base64_encode($group['question_group_unit_id'])) ?>">
                                    </div>
                                    <div class="d-flex align-items-center justify-content-center" id="smileys">
                                    <?php if($group['importance'] == 0){?>
                                        <div class="checkboxgroup">
                                            <input type="radio" name="<?= 'rating[' . $group['question_group_unit_id'] . '][' . $q . ']' ?>" value="5" class="smiley5" id="radio1" required>
                                            <label for="radio1"><b>Outstanding</b></label>
                                        </div>
                                        <div class="checkboxgroup">
                                            <input type="radio" name="<?= 'rating[' . $group['question_group_unit_id'] . '][' . $q . ']' ?>" value="4" class="smiley4" id="radio2" required>
                                            <label for="radio2"><b>Very Satisfactory</b></label>
                                        </div>
                                        <div class="checkboxgroup">
                                            <input type="radio" name="<?= 'rating[' . $group['question_group_unit_id'] . '][' . $q . ']' ?>" value="3" class="smiley3" id="radio3" required>
                                            <label for="radio3"><b>Satisfactory</b></label>
                                        </div>
                                        <div class="checkboxgroup">
                                            <input type="radio" name="<?= 'rating[' . $group['question_group_unit_id'] . '][' . $q . ']' ?>" value="2" class="smiley2" id="radio4" required>
                                            <label for="radio4"><b>Unsatisfactory</b></label>
                                        </div>
                                        <div class="checkboxgroup">
                                            <input type="radio" name="<?= 'rating[' . $group['question_group_unit_id'] . '][' . $q . ']' ?>" value="1" class="smiley1" id="radio5" required>
                                            <label for="radio5"><b>Poor</b></label>
                                        </div>
                                    <?php }else{?>
                                        <div class="checkboxgroup">
                                            <input type="radio" name="<?= 'rating[' . $group['question_group_unit_id'] . '][' . $q . ']' ?>" value="5" class="numero5" id="radio1" required>
                                            <label for="radio1"><b>Very Important</b></label>
                                        </div>
                                        <div class="checkboxgroup">
                                            <input type="radio" name="<?= 'rating[' . $group['question_group_unit_id'] . '][' . $q . ']' ?>" value="4" class="numero4" id="radio2" required>
                                            <label for="radio2"><b>Important</b></label>
                                        </div>
                                        <div class="checkboxgroup">
                                            <input type="radio" name="<?= 'rating[' . $group['question_group_unit_id'] . '][' . $q . ']' ?>" value="3" class="numero3" id="radio3" required>
                                            <label for="radio3"><b>Moderately Important</b></label>
                                        </div>
                                        <div class="checkboxgroup">
                                            <input type="radio" name="<?= 'rating[' . $group['question_group_unit_id'] . '][' . $q . ']' ?>" value="2" class="numero2" id="radio4" required>
                                            <label for="radio4"><b>Slightly Important</b></label>
                                        </div>
                                        <div class="checkboxgroup">
                                            <input type="radio" name="<?= 'rating[' . $group['question_group_unit_id'] . '][' . $q . ']' ?>" value="1" class="numero1" id="radio5" required>
                                            <label for="radio5"><b>Not at all Important</b></label>
                                        </div>
                                    <?php }?>
                                    </div>
                                </div>
                            </li>
                            <?php $q++; ?>
                        <?php } ?>
                    </ul>
                </div>
                <?php $g++; ?>
            <?php } ?>
            <div class="card mb-3 mt-0 border-0 col col-lg-12">
                <div class="card-body">
                    <p class="card-text"><b>Considering your complete experience with our agency, how likely would you recommend our services to others?</b> (<span class="text-danger">Required</span>)</p>
                    <div class="d-flex align-items-center justify-content-center">
                        <div class="form-group">
                            <!-- <?php
                                    // echo StarRating::widget([
                                    //     'name' => 'rating_20',
                                    //     'id' => 'rating',
                                    //     'pluginOptions' => [
                                    //         'size' => 'md',
                                    //         'stars' => 10,
                                    //         'step' => 1,
                                    //         'min' => 0,
                                    //         'max' => 10,
                                    //         'displayOnly' => false
                                    //     ],
                                    // ]);
                                    ?> -->
                            <div class="d-flex align-items-center justify-content-center" id="nps">
                                <div class="checkbox-nps checkboxgroup">
                                    <input type="radio" name="nps" value="1" class="number1" id="nps-radio1" required>

                                </div>
                                <div class="checkbox-nps checkboxgroup">
                                    <input type="radio" name="nps" value="2" class="number2" id="nps-radio2" required>

                                </div>
                                <div class="checkbox-nps checkboxgroup">
                                    <input type="radio" name="nps" value="3" class="number3" id="nps-radio3" required>

                                </div>
                                <div class="checkbox-nps checkboxgroup">
                                    <input type="radio" name="nps" value="4" class="number4" id="nps-radio4" required>

                                </div>
                                <div class="checkbox-nps checkboxgroup">
                                    <input type="radio" name="nps" value="5" class="number5" id="nps-radio5" required>
                                </div>
                                <div class="checkbox-nps checkboxgroup">
                                    <input type="radio" name="nps" value="6" class="number6" id="nps-radio6" required>

                                </div>
                                <div class="checkbox-nps checkboxgroup">
                                    <input type="radio" name="nps" value="7" class="number7" id="nps-radio7" required>

                                </div>
                                <div class="checkbox-nps checkboxgroup">
                                    <input type="radio" name="nps" value="8" class="number8" id="nps-radio8" required>

                                </div>
                                <div class="checkbox-nps checkboxgroup">
                                    <input type="radio" name="nps" value="9" class="number9" id="nps-radio9" required>

                                </div>
                                <div class="checkbox-nps checkboxgroup">
                                    <input type="radio" name="nps" value="10" class="number10" id="nps-radio10" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-3 mt-0 border-0">
                <div class="card-body">
                    <p class="card-text"><b>Please indicate other important attribute/s which you think is important to your needs.</b> (<span class="text-info">Optional</span>)</p>
                    <div class="form-group">
                        <textarea class="form-control" name="other_important_attrib" id="Textarea1" rows="3"></textarea>
                    </div>
                </div>
            </div>
            <div class="card mb-3 mt-0 border-0">
                <div class="card-body">
                    <p class="card-text"><b>Please write your comment/suggestions below.</b> (<span class="text-info">Optional</span>)</p>
                    <div class="form-group">
                        <textarea class="form-control" name="comments" id="Textarea2" rows="3"></textarea>
                    </div>
                </div>
            </div>

            <div class="card mb-3 mt-0 border-0">
                <div class="card-body">
                    <p class="card-text"><b>Signature</b> (<span class="text-danger">Required</span>)</p>
                    <div class="form-group">
                        <div class="text-center">
                            <canvas id="signature" width="286" height="150" style="border: 1px solid #ddd;"></canvas>
                            <input type="hidden" id="sigText" name="sigText">
                            <br>
                            <button type="button" class="btn btn-warning btn-sm" id="clear-signature">Clear</button>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-blue btn-lg"><i class="fa fa-paper-plane" aria-hidden="true"></i> Submit</button>
        </div>
        <div class="col-md-1"></div>
    </div>

    <!-- </form> -->
    <?php ActiveForm::end(); ?>
</div>

<!-- <div class="spanner">
    <div class="loader"></div>
</div> -->

<!-- Modal HTML -->
<div id="myModalGreate" class="modal">
    <div class="modal-dialog modal-confirm">
        <div class="modal-content animate__bounceIn">
            <div class="modal-header justify-content-center">
                <div class="icon-box">
                    <i class="material-icons">&#xE876;</i>
                </div>
            </div>
            <div class="modal-body text-center">
                <h4>Great!</h4>
                <p>Your response has been recorded.</p>
                <a href="<?= $serveruri . '/csf/' . $_GET['id'] ?>" class="btn btn-primary btn-lg"><i class="fa fa-circle-check" aria-hidden="true"></i> OK</a>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        swal("Disclaimer", "The DOST is committed to protect and respect your personal data privacy. All information collected will only be used for documentation purposes and will not be published in any platform.", "warning");
    });
</script>