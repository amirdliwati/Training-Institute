<?php

include "BaseController.php";

class InstructorController extends BaseController
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'checkAccess',
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'assign'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $model = $this->loadModel($id);
        $this->layout ="//layouts/column2";
        $this->pageTitle = 'عرض صفحة المدرس ' . $model->first_name . " " . $model->last_name;
        $currentCourses = $model->tblCourses(
            array(
                'conditions' => array('status IN (:started,:not_yet_started)', array(
                    ':started' => Course::STATUS_IN_PROGRESS,
                    ':not_yet_started' => Course::STATUS_NOT_YET_STARTED,
                ),
                ),
            )
        );
        $previousCourses = $model->tblCourses(
            array(
                'conditions' => array('status IN (:finished,:not_yet_started)', array(
                    ':finished' => Course::STATUS_FINISHED,

                ),
                ),
            )
        );
        $this->render('view', array(
            'model' => $model,
            'currentCourses' => $currentCourses,
            'previousCourses' => $previousCourses,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new Instructor;
        $this->pageTitle = "إنشاء مدرس جديد";
        $this->layout = "//layouts/column2";
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Instructor'])) {
            $model->attributes = $_POST['Instructor'];
            $model->added_date = date('Y-m-d');
            if ($model->save())
                $this->redirect(array('admin'));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {

        $model = $this->loadModel($id);
        $this->pageTitle = "تعديل بيانات المدرس " . $model->first_name . " " . $model->last_name;
        $this->layout = "//layouts/column2";
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Instructor'])) {
            $model->attributes = $_POST['Instructor'];
            if ($model->save())
                $this->redirect(array('admin'));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $instructor = $this->loadModel($id);
        if($instructor->isDeletable()){
            $instructor->delete();
            $this->redirect(array('instructor/admin'));
        }else{
            throw new CHttpException(400);
        }
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('Instructor');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionAssign($id)
    {
        $model = $this->loadModel($id);
        $name = $model->first_name . " " . $model->last_name;
        $this->pageTitle = "تعيين الأستاذ: " . $name . " في دورة";
        $this->layout = "//layouts/column1";
        if (isset($_POST['instructor_id']) && isset($_POST['course_id'])) {
            $course_id = $_POST['course_id'];
            if (Course::model()->findByPk($course_id) == null) {
                throw new CHttpException(404, "الدورة غير موجودة");
            }
            $model->assignCourse($course_id);
            $this->redirect(array('view', 'id' => $model->id));
        }
        $this->render('assign', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $this->layout = "//layouts/column2";
        $this->pageTitle = "لوحة ادارة المدرسين";
        $model = new Instructor('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Instructor'])) {
            $model->attributes = $_GET['Instructor'];
        }
        $this->render('admin', array(
            'model' => $model,
        ));
    }
    public function renderViewLink($data, $raw)
    {
        return '<a href="' . $this->createUrl('instructor/view', array('id' => $data->id)) . '"><span style="color:#222;font-size:21px;" class="glyphicon glyphicon-user"></span></a>';
    }

    public function renderUpdateLink($data, $raw)
    {
        return '<a href="' . $this->createUrl('instructor/update', array('id' => $data->id)) . '"><span style="color:#222;font-size:21px;" class="glyphicon glyphicon-pencil"></span></a>';
    }
    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Instructor the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Instructor::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
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
     * Performs the AJAX validation.
     * @param Instructor $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'instructor-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
