<?php

use yii\helpers\Html;
use yii\grid\GridView;



/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Repository Yii2';
?>
<div class="book-index">

    <div class="jumbotron">
        <?php echo Html::img('@web/img/logo-pens.png', ['alt'=>'some', 'class'=>'img-fluid']);  ?>
        <!-- <img src="logo-pens.png"> -->
    </div>

    <?php
    if(Yii::$app->user->isGuest) {
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'columns'=>[
                ['class'=>'yii\grid\SerialColumn'],
                [
                    'attribute' => 'subject name',
                    'value' => 'subject.subject',
                ],
                'book_name',
                'author',
                'release_year',
                'semester',
                
            ],
        ]);
    } else  if(Yii::$app->user->identity->admin_level == '1'){
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'columns'=>[
                ['class'=>'yii\grid\SerialColumn'],
                [
                    'attribute' => 'subject name',
                    'value' => 'subject.subject',
                ],
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
            ],
        ]);
    }
    else{
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'columns'=>[
                ['class'=>'yii\grid\SerialColumn'],
                [
                    'attribute' => 'subject name',
                    'value' => 'subject.subject',
                ],
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
            ]
        ]);
    }
    ?>


</div>
