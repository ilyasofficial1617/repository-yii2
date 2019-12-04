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
    /*
    @property integer $id
    @property integer $subject_id
    @property string $book_name
    @property string $author
    @property integer $release_year
    @property string $filename
    @property integer $semester

    */
    public function rules(){
      return [
        [['subject_id', 'book_name', 'author', 'release_year', 'filename'],'required'],
        ['subject_id','number'],
        ['book_name','string'],
        ['author','string'],
        ['release_year','number'],
        ['filename','string'],
        ['semester','number'],
        array ( "subject_id, book_name, author, release_year, filename, semester" , "safe" )
      ];
    }

    public function getAll(){
      return Post::find()->all();
    }

    public function getLinkFile(){
      $data = Book::findOne($this->id);

      $link = $data->filename;
      return $link;
    }

}
