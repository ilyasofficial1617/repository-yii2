<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * Login form
 */
class Book extends ActiveRecord
{
    /*public $id;
    public $subject_id;
    public $book_name;
    public $author;
    public $release_year;
    */
    public function rules(){
      return [
        [['subject_id', 'book_name', 'author', 'release_year'],'required'],
        ['subject_id','number'],
        ['book_name','string'],
        ['author','string'],
        ['release_year','number'],
        array ( "subject_id, book_name, author, release_year" , "safe" )
      ];
    }


}
