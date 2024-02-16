<?php

include "BaseController.php";

class SiteController extends BaseController
{
    /**
     * Server Password
     * Declares class-based actions.
     */

    public $main_section_title = "الصفحة الرئيسية";
    const ERROR_MESSAGE_404 = "الطلب غير متوفر";
    const ERROR_MESSAGE_403 = "يوجد خطأ في الطلب";

    public $layout = '//layouts/column2';

    public $welcome_message = "";

    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    public function filters()
    {
        return array(
           'checkAccess -login,sr,srcomplete,home',
        );
    }
    public function actionJson()
    {
        header("content-type: text/json");
        echo json_encode(array(
            'hello' => $this,
            'array' => array(
                'a' => 2214,
            ),
            'hello1' => $this,
        ));
    }

    public function actionUnderConstruction(){
        $this->layout = '//layouts/under_construction';
        $this->render('under_construction');
    }

    /*
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     * @var $course Course
     */

    public function actionTest()
    {

        $course = "Applied Mathematics";
        $this->redirect(array('test2','name'=>urlencode($course)));
    }

    public function  actionTest2($name)
    {
        echo urldecode($name);
    }

    public function actionIndex()
    {
        $this->redirect(array('student/index'));
        $this->layout = '//layouts/column1';
        $this->render('index');
        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
    }

    public function actionHome(){
        Yii::app()->theme = "website";
        $this->render("home");
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        $this->layout = '//layouts/column1';
        $this->pageTitle = "خطأ في التنفيذ";
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * Displays the contact page
     */
    public function actionContact()
    {
        $model = new ContactForm;
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate()) {
                $name = '=?UTF-8?B?' . base64_encode($model->name) . '?=';
                $subject = '=?UTF-8?B?' . base64_encode($model->subject) . '?=';
                $headers = "From: $name <{$model->email}>\r\n" .
                    "Reply-To: {$model->email}\r\n" .
                    "MIME-Version: 1.0\r\n" .
                    "Content-Type: text/plain; charset=UTF-8";

                mail(Yii::app()->params['adminEmail'], $subject, $model->body, $headers);
                Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        $this->render('contact', array('model' => $model));
    }

    /**
     * Displays the login page
     */
    public function actionLogin()
    {
        $model = new LoginForm;
        $this->layout = "//layouts/login";

        $this->welcome_message = "تسجيل الدخول";
        if(isset($_POST['LoginForm'])){
            $model->attributes = $_POST['LoginForm'];
            if($model->validate()){
                $model->login();
                $this->redirect(array("student/index"));
            }
        }
        $this->render('login', array('model' => $model));
    }

    // public view for student registration.

    public function actionSR(){
        $this->layout = "//layouts/login";
        $this->welcome_message = "تسجيل في دورة جديدة";

        $this->render('sr');
    }

    public function actionSRComplete(){
        $this->layout = "//layouts/login";
        $this->welcome_message = "شكرا على اتمام عملية التسجيل";

        $this->render('sr_complete');
    }


    public function filterCheckAccess($filterChain){
        if(Yii::app()->user->isGuest){
            $this->redirect(array('site/login'));
        }
        if(!Yii::app()->user->checkAccess('adminApp')){
            $this->redirect(array('site/login'));
        }else{
            $filterChain->run();
        }
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(array('site/login'));
    }
}