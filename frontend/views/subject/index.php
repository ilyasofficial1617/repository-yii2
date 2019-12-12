<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Subjects';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subject-index">

    <h1><?= Html::encode($this->title) ?></h1>

 <!--   <p> -->
        <!--<?= Html::a('Create Subject', ['create'], ['class' => 'btn btn-success']) ?>-->
 <!--   </p> -->


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'subject',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
