<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$this->title = 'Add Subject';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-add-subject">
  <h1><?= Html::encode($this->title) ?></h1>
  <p>Please fill out the following fields to add subject:</p>

  <div class="row">
      <div class="col-lg-5">
          <?php $form = ActiveForm::begin(['id' => 'form-add-subject']); ?>

              <?= $form->field($model, 'subject') ?>
              
              <div class="form-group">
                  <?= Html::submitButton('Add', ['class' => 'btn btn-primary', 'name' => 'add-button']) ?>
              </div>

          <?php ActiveForm::end(); ?>
      </div>
  </div>
</div>
