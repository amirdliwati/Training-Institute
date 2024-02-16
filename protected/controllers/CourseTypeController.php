<?php

include "BaseController.php";

class CourseTypeController extends BaseController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
    public $main_section_title = "القائمة الرئيسية";
	/**
	 * @return array action filters
	 */

	public function filters()
	{
		return array(
			'postOnly + delete', // we only allow deletion via POST request
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
        $damascusList = $this->loadModel($id);
        $entries = $damascusList->damascusListEntries;
        $dataProvider = new CActiveDataProvider('DamascusListEntry',array(
            'pagination'=>array(
                'pageSize'=>20,
            ),
        ));
        $dataProvider->setData($entries);
		$this->render('view',array(
			'model'=>$damascusList,
            'entriesDataProvider'=>$dataProvider,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
        $this->layout = '//layouts/column2';
		$model=new CourseType;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['CourseType']))
		{
			$model->attributes=$_POST['CourseType'];
			if($model->save())
				$this->redirect(array('admin'));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
        $this->layout = '//layouts/column2';
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['CourseType']))
		{
			$model->attributes=$_POST['CourseType'];
			if($model->save())
                $this->redirect(array('admin'));
		}


		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{

		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('CourseType');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
        $this->layout = '//layouts/column2';
		$model=new CourseType('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['CourseType']))
			$model->attributes=$_GET['CourseType'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return CourseType the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=CourseType::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

    public function renderUpdateLink($data, $raw)
    {
        return '<a href="' . $this->createUrl('courseType/update', array('id' => $data->id)) . '"><span style="color:#222;font-size:21px;" class="glyphicon glyphicon-pencil"></span></a>';
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
	 * @param CourseType $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='course-type-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();

		}
	}
}
