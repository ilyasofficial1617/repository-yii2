<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class UploadFileForm extends Model {
  public $file;
  public function rules(){
    return [
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
