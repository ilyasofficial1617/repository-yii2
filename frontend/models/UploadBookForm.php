<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Book;
use yii\web\UploadedFile;

class UploadBookForm extends Model {
  public $subject_id;
  public $book_name;
  public $author;
  public $release_year;
  public $file;

  public function rules(){
    return [
      //[['subject_id', 'book_name', 'author', 'release_year'],'required'],
      ['subject_id','number'],
      ['book_name','string'],
      ['author','string'],
      ['release_year','number'],
      [['file'], 'file'],
    ];
  }

  public function upload(){
      if ($this->validate()) {
          $this->file->saveAs('repo-data/' . $this->file->baseName . '.' . $this->file->extension);
          return true;
      } else {
          return false;
      }
  }
}
