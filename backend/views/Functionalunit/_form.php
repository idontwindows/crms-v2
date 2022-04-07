<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\QuestionGroupUnit;

/* @var $this yii\web\View */
/* @var $model common\models\Functionalunit */
/* @var $form yii\widgets\ActiveForm */

// if (isset($_GET['functional_unit_id'])) {
//     $attributes1 = QuestionGroupUnit::find()->joinWith('attributequestions as a')
//         ->select(['attribute_id' => 'a.question_unit_id','question' => 'a.question', 'no_dimension' => 'a.no_dimension'])
//         ->andWhere(['a.dimension_id' => 1])
//         ->andWhere(['tbl_question_group_unit.unit_id' => $_GET['functional_unit_id']])
//         ->andWhere(['tbl_question_group_unit.importance' => 0])
//         ->one();
//     $attributes2 = QuestionGroupUnit::find()->joinWith('attributequestions as a')
//         ->select(['attribute_id' => 'a.question_unit_id','question' => 'a.question', 'no_dimension' => 'a.no_dimension'])
//         ->andWhere(['a.dimension_id' => 2])
//         ->andWhere(['tbl_question_group_unit.unit_id' => $_GET['functional_unit_id']])
//         ->andWhere(['tbl_question_group_unit.importance' => 0])
//         ->one();
//     $attributes3 = QuestionGroupUnit::find()->joinWith('attributequestions as a')
//         ->select(['attribute_id' => 'a.question_unit_id','question' => 'a.question', 'no_dimension' => 'a.no_dimension'])
//         ->andWhere(['a.dimension_id' => 3])
//         ->andWhere(['tbl_question_group_unit.unit_id' => $_GET['functional_unit_id']])
//         ->andWhere(['tbl_question_group_unit.importance' => 0])
//         ->one();
//     $attributes4 = QuestionGroupUnit::find()->joinWith('attributequestions as a')
//         ->select(['attribute_id' => 'a.question_unit_id','question' => 'a.question', 'no_dimension' => 'a.no_dimension'])
//         ->andWhere(['a.dimension_id' => 4])
//         ->andWhere(['tbl_question_group_unit.unit_id' => $_GET['functional_unit_id']])
//         ->andWhere(['tbl_question_group_unit.importance' => 0])
//         ->one();
//     $attributes5 = QuestionGroupUnit::find()->joinWith('attributequestions as a')
//         ->select(['attribute_id' => 'a.question_unit_id','question' => 'a.question', 'no_dimension' => 'a.no_dimension'])
//         ->andWhere(['a.dimension_id' => 5])
//         ->andWhere(['tbl_question_group_unit.unit_id' => $_GET['functional_unit_id']])
//         ->andWhere(['tbl_question_group_unit.importance' => 0])
//         ->one();
//     $attributes6 = QuestionGroupUnit::find()->joinWith('attributequestions as a')
//         ->select(['attribute_id' => 'a.question_unit_id','question' => 'a.question', 'no_dimension' => 'a.no_dimension'])
//         ->andWhere(['a.dimension_id' => 6])
//         ->andWhere(['tbl_question_group_unit.unit_id' => $_GET['functional_unit_id']])
//         ->andWhere(['tbl_question_group_unit.importance' => 0])
//         ->one();
//     $attributes7 = QuestionGroupUnit::find()->joinWith('attributequestions as a')
//         ->select(['attribute_id' => 'a.question_unit_id','question' => 'a.question', 'no_dimension' => 'a.no_dimension'])
//         ->andWhere(['a.dimension_id' => 7])
//         ->andWhere(['tbl_question_group_unit.unit_id' => $_GET['functional_unit_id']])
//         ->andWhere(['tbl_question_group_unit.importance' => 0])
//         ->one();
//     $attributes8 = QuestionGroupUnit::find()->joinWith('attributequestions as a')
//         ->select(['attribute_id' => 'a.question_unit_id','question' => 'a.question', 'no_dimension' => 'a.no_dimension'])
//         ->andWhere(['a.dimension_id' => 8])
//         ->andWhere(['tbl_question_group_unit.unit_id' => $_GET['functional_unit_id']])
//         ->andWhere(['tbl_question_group_unit.importance' => 0])
//         ->one();
// }
?>

<div class="functionalunit-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="card mb-3">
        <div class="card-header bg-primary text-white">
            Part I - Information
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'services_id')->dropDownList(
                        ArrayHelper::map($items, 'services_id', 'services_name'),
                        [
                            'prompt' => 'Select Services...',
                            // 'onchange' => '$.post("",function(){

                            // });'
                           'disabled' => !$model->isNewRecord ? true : false
                        ],

                        [
                            'options' => function () use ($model, $update) {
                                if ($update == true) {
                                    return [$model->services->services_id => ['selected' => true]];
                                }
                            }
                        ]
                    )->label('Functional Units') ?>
                </div>
                <div class="col-md-6"></div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header bg-primary text-white">
            Part II - Attributes
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <!-- <th scope="col">#</th> -->
                        <th scope="col" colspan="2" class="text-center col-9">Attributes</th>
                        <th scope="col" class="text-center col-2">Dimensions</th>
                        <th scope="col" class="text-center col-1">No Dimension</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>
                            <?= Html::hiddenInput('question-id-1', $update == true && $attributes1 ? $attributes1->attribute_id : '') ?>
                            <?= Html::input('text', 'attrib1', $update == true && $attributes1 ? $attributes1->question : '', ['class' => 'form-control']) ?>
                        </td>
                        <td>Responsiveness</td>
                        <td class="text-center">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="check-1" class="custom-control-input" id="check-1" <?= $update == true && $attributes1 ? ($attributes1->no_dimension == 1 ? 'checked' : '') : '' ?>>
                                <label class="custom-control-label" for="check-1"></label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td>
                            <?= Html::hiddenInput('question-id-2', $update == true && $attributes2 ? $attributes2->attribute_id : '') ?>
                            <?= Html::input('text', 'attrib2', $update == true && $attributes2 ? $attributes2->question : '', ['class' => 'form-control']) ?>
                        </td>
                        <td>Reliability (Quality)</td>
                        <td class="text-center">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="check-2" class="custom-control-input" id="check-2" <?= $update == true && $attributes2 ? ($attributes2->no_dimension == 1 ? 'checked' : '') : '' ?>>
                                <label class="custom-control-label" for="check-2"></label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">3</th>
                        <td>
                            <?= Html::hiddenInput('question-id-3', $update == true && $attributes3 ? $attributes3->attribute_id : '') ?>
                            <?= Html::input('text', 'attrib3', $update == true && $attributes3 ? $attributes3->question : '', ['class' => 'form-control']) ?>
                        </td>
                        <td>Access & Facilities</td>
                        <td class="text-center">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="check-3" class="custom-control-input" id="check-3" <?= $update == true && $attributes3 ? ($attributes3->no_dimension == 1 ? 'checked' : '') : '' ?>>
                                <label class="custom-control-label" for="check-3"></label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">4</th>
                        <td>
                            <?= Html::hiddenInput('question-id-4', $update == true && $attributes4 ? $attributes4->attribute_id : '') ?>
                            <?= Html::input('text', 'attrib4', $update == true && $attributes4 ? $attributes4->question : '', ['class' => 'form-control']) ?>
                        </td>
                        <td>Communiction</td>
                        <td class="text-center">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="check-4" class="custom-control-input" id="check-4" <?= $update == true && $attributes4 ? ($attributes4->no_dimension == 1 ? 'checked' : '') : '' ?>>
                                <label class="custom-control-label" for="check-4"></label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">5</th>
                        <td>
                            <?= Html::hiddenInput('question-id-5', $update == true && $attributes5 ? $attributes5->attribute_id : '') ?>
                            <?= Html::input('text', 'attrib5', $update == true && $attributes5 ? $attributes5->question : '', ['class' => 'form-control']) ?>
                        </td>
                        <td>Costs</td>
                        <td class="text-center">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="check-5" class="custom-control-input" id="check-5" <?= $update == true && $attributes5 ? ($attributes5->no_dimension == 1 ? 'checked' : '') : '' ?>>
                                <label class="custom-control-label" for="check-5"></label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">6</th>
                        <td>
                            <?= Html::hiddenInput('question-id-6', $update == true && $attributes6 ? $attributes6->attribute_id : '') ?>
                            <?= Html::input('text', 'attrib6', $update == true && $attributes6 ? $attributes6->question : '', ['class' => 'form-control']) ?>
                        </td>
                        <td>Integrity</td>
                        <td class="text-center">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="check-6" class="custom-control-input" id="check-6" <?= $update == true && $attributes6 ? ($attributes6->no_dimension == 1 ? 'checked' : '') : '' ?>>
                                <label class="custom-control-label" for="check-6"></label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">7</th>
                        <td>
                            <?= Html::hiddenInput('question-id-7', $update == true && $attributes7 ? $attributes7->attribute_id : '') ?>
                            <?= Html::input('text', 'attrib7', $update == true && $attributes7 ? $attributes7->question : '', ['class' => 'form-control']) ?>
                        </td>
                        <td>Assurance</td>
                        <td class="text-center">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="check-7" class="custom-control-input" id="check-7" <?= $update == true && $attributes7 ? ($attributes7->no_dimension == 1 ? 'checked' : '') : '' ?>>
                                <label class="custom-control-label" for="check-7"></label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">8</th>
                        <td>
                            <?= Html::hiddenInput('question-id-8', $update == true && $attributes8 ? $attributes8->attribute_id : '') ?>
                            <?= Html::input('text', 'attrib8', $update == true && $attributes8 ? $attributes8->question : '', ['class' => 'form-control']) ?>
                        </td>
                        <td>Outcome</td>
                        <td class="text-center">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="check-8" class="custom-control-input" id="check-8" <?= $update == true && $attributes8 ? ($attributes8->no_dimension == 1 ? 'checked' : '') : '' ?>>
                                <label class="custom-control-label" for="check-8"></label>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- <?= $form->field($model, 'region_id')->textInput() ?> -->


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Save' : 'Update', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>