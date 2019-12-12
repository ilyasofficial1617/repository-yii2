<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\models\UploadFileForm;
use common\models\Subject;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Book */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="book-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?php
        $subject=Subject::find()->all();
        $listData=ArrayHelper::map($subject,'id','subject');
        echo $form->field($model, 'subject_id')->dropDownList($listData,['prompt'=>'Select...'])->label('Subject Name');
                    
    ?>

    <div class="form-group">
        <?= 
        Html::a('Update Subject', ['update-subject', 'id' => $model->subject_id,'idBook'=>$model->id], ['class' => 'btn btn-primary']) 
        ?>
    </div>

    <?= $form->field($model, 'book_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'author')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'release_year')->textInput() ?>

    <?= $form->field($newFile, 'file')->FileInput()->label('Change File') ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
