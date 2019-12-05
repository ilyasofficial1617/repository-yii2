<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Subject;
use yii\helpers\ArrayHelper;
use miloschuman\highcharts\Highcharts;
use common\models\Book;
use yii\data\ActiveDataProvider;

$this->title = 'Dashboard';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-dashboard">
  <h1><?= Html::encode($this->title) ?></h1>

  <div class="row">
      <div class="col-lg-5">
          
          <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data','id' => 'form-dashboard']]); ?>

              <?php
              
            //   $books = new ActiveDataProvider([
            //     'query'=>Book::find()
            //         ->all()
            //   ])->asArray();

                $books = Book::find()
                            ->select(['COUNT(*) AS cnt'])
                            ->groupBy('subject_id')
                            ->all();    

                $subjects = Subject::find()
                            ->select(['subject'])
                            ->all(); 

            //   $sqlBook = 'SELECT COUNT(*)
            //               FROM BOOK
            //               GROUP BY SUBJECT_ID';

            //   $books = Book::findBySql($sqlBook)->all();

            //   $sqlSubject = 'SELECT SUBJECT
            //                  FROM SUBJECT';
              
            //   $subjects = Subject::findBySql($sqlSubject)->all();
              
            //   foreach($books as $temp) {
            //       echo $temp->book_name;
            //   }

              echo Highcharts::widget([
                  'options' => [
                  'title' => ['text' => 'Book Based On Subject'],
                  'xAxis' => [
                      'title' => ['text' => 'Subject'],
                      'categories' => $books
                  ],
                  'yAxis' => [
                      'title' => ['text' => 'Amount']
                  ],
                  'series' => [
                      ['name' => 'Books', 'data' => $subjects],
                  ]
                  ]
              ]);
              ?>

              <h1> </h1>

              <?php
              echo Highcharts::widget([
                'options' => [
                'title' => ['text' => 'Book Based On Semester'],
                'xAxis' => [
                    'categories' => ['Apples', 'Bananas', 'Oranges']
                ],
                'yAxis' => [
                    'title' => ['text' => 'Fruit eaten']
                ],
                'series' => [
                    ['name' => 'Jane', 'data' => [1, 0, 4]]
                ]
                ]
              ]);

              echo Highcharts::widget([
                'options' => [
                'title' => ['text' => 'Book Based On Release Year'],
                'xAxis' => [
                    'categories' => ['Apples', 'Bananas', 'Oranges']
                ],
                'yAxis' => [
                    'title' => ['text' => 'Fruit eaten']
                ],
                'series' => [
                    ['name' => 'Jane', 'data' => [1, 0, 4]],
                    ['name' => 'John', 'data' => [5, 7, 3]]
                ]
                ]
              ]);
              ?>

          <?php ActiveForm::end(); ?>
      </div>
  </div>
</div>
