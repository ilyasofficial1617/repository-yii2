<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Subject;

class AddSubjectForm extends Model {
  public $subject;

  public function rules(){
    return [
      [['subject'],'required'],
      ['subject','string'],
    ];
  }

  public function add(){
    $subject_temp = new Subject();
    $subject_temp->subject = $this->subject;
    return $subject_temp->save();
  }
}
