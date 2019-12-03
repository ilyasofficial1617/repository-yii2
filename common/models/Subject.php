<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * Login form
 */
class Subject extends ActiveRecord
{
    /*public $id;
    public $subject_id;
    public $book_name;
    public $author;
    public $release_year;
    */
    public function rules(){
      return [
        [['subject'],'required'],
        ['subject','string'],
        array ( "subject" , "safe" )
      ];
    }

    public function getAll() {
        return Post::find()->all();
    }
}
