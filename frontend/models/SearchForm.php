<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Book;
//use yii\web\UploadedFile;

class SearchForm extends Model {
  public $category;
  public $value;

  public function rules(){
    return [
      [['category', 'value'],'required'],
      ['category','string'],
      ['value','string'],
    ];
  }

  public function search(){
      
  }
}
