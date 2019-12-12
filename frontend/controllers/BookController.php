<?php

namespace frontend\controllers;

use Yii;
use common\models\Book;
use common\models\Subject;
use frontend\models\UploadFileForm;
use frontend\models\SearchForm;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;

/**
 * BookController implements the CRUD actions for Book model.
 */
class BookController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Book models.
     * @return mixed
     */
    public function actionIndex()
    {
        /*$subQuery = (new Query)->select('subject')->from('subject')->where("id = book.id");
        $query = (new Query)->select(['subject'=>$subQuery, 'book_name','author','release_year','filename','semester'])->from('book');*/

        $dataProvider = new ActiveDataProvider([
            'query' => Book::find(),
            'pagination' => [
                    'pageSize'=>5,
            ],
                
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Book model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Book model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Book();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Book model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $newFile = new UploadFileForm();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $newFile->file = UploadedFile::getInstance($newFile, 'file');
            if($newFile->file !== null){
                if($newFile->upload()){
                    $model->filename =  $newFile->file->baseName . '.' . $newFile->file->extension; 
                    $this->actionDeleteFile($id);
                    $model->save();
                }
            }
            //return $this->redirect(['view', 'id' => $model->id]);
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
            'newFile' => $newFile,
        ]);
    }

    public function actionUpdateSubject($id,$idBook){
        return $this->redirect(array('subject/update','id'=>$id,'idBook'=>$idBook));
    }

    /**
     * Deletes an existing Book model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        //delete file
        $model = Book::findOne($id);
        $filepath ='repo-data/'.$model->filename;
        unlink($filepath);
        //delete data
        $model->delete();
        return $this->redirect(['index']);
    }
    public function actionDeleteFile($id){
        //delete file
        $model = Book::findOne($id);
        $filepath ='repo-data/'.$model->filename;
        unlink($filepath);
    }

        public function actionSearch(){

        $model = new SearchForm();
        if ($model->load(Yii::$app->request->post())) {
            $post = True;
            $value="%".$model->value."%";
            if($model->category == 'subject'){
              $subQuery = Subject::find()
                          ->select(['id'])
                          ->where("subject LIKE :val")
                          ->addParams([':val'=>$value]);
              $query = Book::find()
                      ->where(['=','subject_id',$subQuery]);
            }
            else{
              $query = Book::find()
                      ->where("$model->category LIKE :val")
                      ->addParams([':val'=>$value]);
            }
            $books = new ActiveDataProvider([
                  'query'=>$query,
              ]);
            return $this->render('search',['books'=>$books,'model' => $model,'post'=>$post]);

        }
        $post = False;
        return $this->render('search', [
            'model' => $model,'post'=>$post
        ]);

        /*$model = new SearchForm();
        return $this->render('search', ['model' => $model]);*/
    }


    /**
     * Finds the Book model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Book the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Book::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
