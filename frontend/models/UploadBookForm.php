<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Book;

class UploadBookForm extends Model {
  public $subject_id;
  public $book_name;
  public $author;
  public $release_year;

  public function rules(){
    return [
      [['subject_id', 'book_name', 'author', 'release_year'],'required'],
      ['subject_id','number'],
      ['book_name','string'],
      ['author','string'],
      ['release_year','number'],
    ];
  }

  public function add(){
    $book_temp = new Book();
    $book_temp->subject_id = $this->subject_id;
    $book_temp->book_name = $this->book_name;
    $book_temp->author = $this->book_name;
    $book_temp->release_year = $this->release_year;
    return $book_temp->save();
  }
}
