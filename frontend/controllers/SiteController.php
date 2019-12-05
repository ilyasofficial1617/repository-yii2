<?php
namespace frontend\controllers;

use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\models\UploadBookForm;
use frontend\models\AddSubjectForm;
use frontend\models\DashboardForm;
use frontend\models\SearchForm;
use common\models\Book;
use common\models\Subject;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup', 'upload-book', 'add-subject'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['upload-book'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['add-subject'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    ////custom action ////
    public function actionUploadBook(){
      //if not admin
      if (Yii::$app->user->identity->admin_level != '1'){
        $this->redirect(['site/index']);
      }

      $model = new UploadBookForm();

        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->upload()) {
                // file is uploaded successfully

                $book_temp = new Book();
                //assign value
                $book_temp->subject_id =  $model->subject_id;
                $book_temp->book_name =  $model->book_name;
                $book_temp->author =  $model->author;
                $book_temp->release_year =  $model->release_year;
                $book_temp->filename =  $model->file->baseName . '.' . $model->file->extension;
                $book_temp->semester =  $model->semester;
                //saved
                if($book_temp->save()){
                  Yii::$app->session->setFlash('success', 'Berhasil menambahkan buku '.$model->book_name);
                  return $this->render('uploadBook', ['model' => new UploadBookForm()]);
                }



            }
        }
        //throw new \yii\base\UserException("false upload()");

        return $this->render('uploadBook', ['model' => $model]);

      /*$model = new UploadBookForm();
      if ($model->load(Yii::$app->request->post()) && $model->upload()) {
          Yii::$app->session->setFlash('success', 'Berhasil menambahkan buku '.$model->book_name);
          return $this->render('uploadBook', [
              'model' => new UploadBookForm(),
          ]);
      }

      return $this->render('uploadBook', [
          'model' => $model,
      ]);*/
      /*
      $model = new UploadBookForm();

        if (Yii::$app->request->isPost) {
            $model->file = UploadedFile::getInstance($model, 'file');

            if ($model->file && $model->validate()) {
              Yii::$app->session->setFlash('success', 'Berhasil menambahkan buku '.$model->book_name);

              $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
              $model->imageFile->saveAs('repo-data/' . $model->file->baseName . '.' . $model->file->extension);

              return $this->render('uploadBook', [
                  'model' => new UploadBookForm(),
              ]);
            }
        }

        return $this->render('uploadBook', [
            'model' => new UploadBookForm(),
        ]);*/
        /*
        $model = new UploadBookForm();

        if (Yii::$app->request->isPost) {
            $model->file = UploadedFile::getInstance($model, 'file');

            if ($model->file && $model->validate()) {
                $model->file->saveAs('repo-data/' . $model->file->baseName . '.' . $model->file->extension);
            }
        }

        return $this->render('uploadBook', ['model' => $model]);
        */
    }

    public function actionSearch(){
        
        $model = new SearchForm();
        if ($model->load(Yii::$app->request->post())) {
          
            $value="%".$model->value."%";
            $query = Book::find()
                    ->where("$model->category LIKE :val")
                    ->addParams([':val'=>$value]);
            $books = new ActiveDataProvider([
                'query'=>$query,
            ]);
            return $this->render('search',['books'=>$books,'model' => $model]);
        }

        return $this->render('search', [
            'model' => $model,
        ]);

        /*$model = new SearchForm();
        return $this->render('search', ['model' => $model]);*/
    }

    ////custom action ////
    public function actionAddSubject()
    {
      //if not admin
      if (Yii::$app->user->identity->admin_level != '1'){
        $this->redirect(['site/index']);
      }

        $model = new AddSubjectForm();
        if ($model->load(Yii::$app->request->post()) && $model->add()) {
            Yii::$app->session->setFlash('success', 'Berhasil menambahkan subject '.$model->subject);
            return $this->render('addSubject', [
                'model' => new AddSubjectForm(),
            ]);
        }
        //belum ada submit
        return $this->render('addSubject', [
            'model' => $model,
        ]);
    }

    public function actionDashboard()
    {
        return $this->render('dashboard');
    }


    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $books = new ActiveDataProvider([
                'query'=>Book::find()
                    ->orderBy('id DESC')
                    ->limit(5),
        ]);
        return $this->render('index',['books'=>$books]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($user = $model->verifyEmail()) {
            if (Yii::$app->user->login($user)) {
                Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
                return $this->goHome();
            }
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }
}
