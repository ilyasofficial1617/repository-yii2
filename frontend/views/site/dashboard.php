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
      <div class="col-lg-12">

          <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data','id' => 'form-dashboard']]); ?>

            <?php

            //   $books = new ActiveDataProvider([
            //     'query'=>Book::find()
            //         ->all()
            //   ])->asArray();

                // $subjects = Subject::find()
                //             ->select(['subject'])
                //             ->all();

            //   $sqlBook = 'SELECT COUNT(*) AS cnt
            //               FROM BOOK
            //               GROUP BY SUBJECT_ID';

            //   $books = Book::findBySql($sqlBook)->all();

            //   $sqlSubject = 'SELECT SUBJECT
            //                  FROM SUBJECT';

            //   $subjects = Subject::findBySql($sqlSubject)->all();

            //   foreach($books as $temp) {
            //       echo $temp->book_name;
            //   }

            $booksBySubject = Book::find()
            ->select(['subject_id'])
            ->all();

            $booksBySemester = Book::find()
            ->select(['semester'])
            ->where(['not', ['semester' => null]])
            ->orderBy(['semester' => SORT_ASC])
            ->all();

            $booksSemesterArray = Book::find()
            ->select(['semester'])
            ->where(['not', ['semester' => null]])
            ->orderBy(['semester' => SORT_ASC])
            ->distinct()
            ->all();

            $booksByRelease = Book::find()
            ->select(['release_year'])
            ->orderBy(['release_year' => SORT_ASC])
            ->all();

            $booksReleaseArray = Book::find()
            ->select(['release_year'])
            ->orderBy(['release_year' => SORT_ASC])
            ->distinct()
            ->all();

            $subjects = Subject::find()->all();

            //use yii\helpers\ArrayHelper;
            $subjects = ArrayHelper::getColumn($subjects,'subject');
            $booksBySubject = ArrayHelper::getColumn($booksBySubject,'subject_id');
            $booksBySemester = ArrayHelper::getColumn($booksBySemester,'semester');
            $booksByRelease = ArrayHelper::getColumn($booksByRelease, 'release_year');
            $booksSemesterArray = ArrayHelper::getColumn($booksSemesterArray,'semester');
            $booksReleaseArray = ArrayHelper::getColumn($booksReleaseArray, 'release_year');

            $booksBySubject_sum = array_count_values($booksBySubject);
            $booksBySemester_sum = array_count_values($booksBySemester);
            $booksByRelease_sum = array_count_values($booksByRelease);

            $i = 0;
            foreach($booksBySubject_sum as $temp) {
                $arraySubject[$i] = $temp;
                $i++;
            }

            $i = 0;
            foreach($booksBySemester_sum as $temp) {
                $arraySemester[$i] = $temp;
                $i++;
            }

            $i = 0;
            foreach($booksByRelease_sum as $temp) {
                $arrayRelease[$i] = $temp;
                $i++;
            }
            ?>

            <h1> </h1>

            <?php
            echo Highcharts::widget([
                'options' => [
                'title' => ['text' => 'Book Based On Subject'],
                'xAxis' => [
                    'title' => ['text' => 'Subject'],
                    'categories' => $subjects
                ],
                'yAxis' => [
                    'title' => ['text' => 'Amount']
                ],
                'series' => [
                    ['name' => 'Books', 'data' => $arraySubject],
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
                    'title' => ['text' => 'Semester'],
                    'categories' => $booksSemesterArray
                ],
                'yAxis' => [
                    'title' => ['text' => 'Amount']
                ],
                'series' => [
                    ['name' => 'Books', 'data' => $arraySemester],
                ]
                ]
            ]);
            ?>

            <h1> </h1>

            <?php
            echo Highcharts::widget([
                'options' => [
                'title' => ['text' => 'Book Based On Release Year'],
                'xAxis' => [
                    'title' => ['text' => 'Release Year'],
                    'categories' => $booksReleaseArray
                ],
                'yAxis' => [
                    'title' => ['text' => 'Amount']
                ],
                'series' => [
                    ['name' => 'Books', 'data' => $arrayRelease],
                ]
                ]
            ]);
            ?>

          <?php ActiveForm::end(); ?>
      </div>
  </div>
</div>
