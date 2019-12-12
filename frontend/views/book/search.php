<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;

$this->title = 'Search Book';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-search">
  <h1><?= Html::encode($this->title) ?></h1>
  <p>Input the fields:</p>

  <div class="row">
      <div class="col-lg-5">
          <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data','id' => 'form-search-book']]); ?>

              <?php

              //use yii\helpers\ArrayHelper;
              $listData=['book_name'=>'book_name','author'=>'author','release_year' => 'release_year','semester'=>'semester','subject'=>'subject'];

              echo $form->field($model, 'category')->dropDownList(
                      $listData,
                      ['prompt'=>'Select...']
                      );
              ?>

              <?= $form->field($model, 'value') ?>

              
              
              <div class="form-group">
                  <?= Html::submitButton('Search', ['class' => 'btn btn-primary', 'name' => 'upload-button']) ?>
              </div>

          <?php ActiveForm::end(); ?>
          <?php
            if($post == True){
              if (Yii::$app->user->identity->admin_level == '1'){
                  echo GridView::widget([
                  'dataProvider' => $books,
                  'columns'=>[
                      ['class'=>'yii\grid\SerialColumn'],
                      'subject_id',
                      'book_name',
                      'author',
                      'release_year',
                      'semester',
                      [
                          'label' => 'Download Here',
                          'format' => 'raw',
                          'value' => function($model) {
                              $url = 'repo-data/'.$model->getLinkFile();
                              return Html::a($model->getLinkFile(),$url);
                          }
                      ],
                      ['class' => 'yii\grid\ActionColumn'],
                  ]
              ]);
            }
            else{
                echo GridView::widget([
                  'dataProvider' => $books,
                  'columns'=>[
                      ['class'=>'yii\grid\SerialColumn'],
                      'subject_id',
                      'book_name',
                      'author',
                      'release_year',
                      'semester',
                      [
                          'label' => 'Download Here',
                          'format' => 'raw',
                          'value' => function($model) {
                              $url = 'repo-data/'.$model->getLinkFile();
                              return Html::a($model->getLinkFile(),$url);
                          }
                      ]
                  ]
              ]);
            }
        }
        ?>
      </div>
  </div>
</div>
