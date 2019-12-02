<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * Login form
 */
class Book extends ActiveRecord
{
    public $id;
    public $subject_id;
    public $book_name;
    public $author;
    public $release_year;



}
