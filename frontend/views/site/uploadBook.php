<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Subject;
use yii\helpers\ArrayHelper;
$this->title = 'Upload Book';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-upload-book">
  <h1><?= Html::encode($this->title) ?></h1>
  <p>Please fill out the following fields to add book:</p>

  <div class="row">
      <div class="col-lg-5">
          <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data','id' => 'form-upload-book']]); ?>

              <?php
              //use app\models\Country;
              $subject=Subject::find()->all();

              //use yii\helpers\ArrayHelper;
              $listData=ArrayHelper::map($subject,'id','subject');

              echo $form->field($model, 'subject_id')->dropDownList(
                      $listData,
                      ['prompt'=>'Select...']
                      );
              ?>

              <?= $form->field($model, 'book_name') ?>

              <?= $form->field($model, 'author') ?>

              <?= $form->field($model, 'release_year') ?>

              <?= $form->field($model, 'file')->fileInput() ?>

              <?= $form->field($model, 'semester') ?>
              
              <div class="form-group">
                  <?= Html::submitButton('Upload', ['class' => 'btn btn-primary', 'name' => 'upload-button']) ?>
              </div>

          <?php ActiveForm::end(); ?>
      </div>
  </div>
</div>
