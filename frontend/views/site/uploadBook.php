<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$this->title = 'Upload Book';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-upload-book">
  <h1><?= Html::encode($this->title) ?></h1>
  <p>Please fill out the following fields to add book:</p>

  <div class="row">
      <div class="col-lg-5">
          <?php $form = ActiveForm::begin(['id' => 'form-upload-book']); ?>

              <?= $form->field($model, 'subject_id') ?>

              <?= $form->field($model, 'book_name') ?>

              <?= $form->field($model, 'author') ?>

              <?= $form->field($model, 'release_year') ?>

              <div class="form-group">
                  <?= Html::submitButton('Upload', ['class' => 'btn btn-primary', 'name' => 'upload-button']) ?>
              </div>

          <?php ActiveForm::end(); ?>
      </div>
  </div>
</div>
