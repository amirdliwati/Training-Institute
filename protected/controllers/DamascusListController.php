<?php

include "BaseController.php";

class DamascusListController extends BaseController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

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
				'users'=>array('admin'),
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
        $entriesDataProvider = new CActiveDataProvider('DamascusListEntry');
        foreach ($damascusList->damascusListEntries as $entry) {
            $entry->getStudent()->course_id = $entry->getCourse()->id;
        }
        $entriesDataProvider->setData($damascusList->damascusListEntries);
        $this->pageTitle = "لوحة ادارة لائحة دمشق رقم: " . $damascusList->num;

        $this->render('view',array(
            'model'=>$damascusList,
            'entriesDataProvider'=>$entriesDataProvider,
        ));
    }
    /**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
        if (isset($_POST['DamascusList'])) {
            $model = new DamascusList;
            $model->attributes = $_POST['DamascusList'];
            if ($model->save()) {
                echo $this->renderPartial('d_list_options',array('model'=>$model),false,true);
            } else {
                echo "حدث خطأ عند انشاء لائحة دمشق جديدة";
            }
        }
        Yii::app()->end();
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['DamascusList']))
		{
			$model->attributes=$_POST['DamascusList'];
			if($model->save()){
               echo CJSON::encode(array(
                    'status'=>true,
                    'message'=>'تمت عملية التعديل بنجاح',
               ));
            }else{
                echo CJSON::encode(array(
                    'status'=>false,
                    'message'=>'هناك خطأ حصل اثناء التعديل',
                ));
            }

		}
        Yii::app()->end();

	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
        if(Yii::app()->request->isAjaxRequest){
            $damascusList = $this->loadModel($id);
            foreach($damascusList->damascusListEntries as $entry){
                try{
                    $entry->delete();
                }catch (CDbException $e ){
                    echo CJSON::encode(array(
                        'status'=>false,
                        'message'=>'يوجد خطأ في حذف اللائحة',
                    ));
                }
            }
            if($damascusList->delete()){
                echo CJSON::encode(array(
                    'status'=>true,
                    'message'=>'تم حذف الائحة بنجاح',
                ));
            }else{
                echo CJSON::encode(array(
                    'status'=>false,
                    'message'=>'يوجد خطأ في حذف اللائحة',
                ));
            }
        }else{
            throw new CHttpException(403);
        }
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('DamascusList');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
        $this->pageTitle = "إدارة لوائح دمشق";
		$model=new DamascusList('search');
		$model->unsetAttributes();  // clear any default values
        if(isset($_GET['DamascusList'])){
            $model->attributes=$_GET['DamascusList'];
            $model->course_type_id = $_GET['DamascusList']['course_type_id'];
            $model->first_name = $_GET['DamascusList']['first_name'];
            $model->last_name = $_GET['DamascusList']['last_name'];
            $model->father_name = $_GET['DamascusList']['father_name'];
        }
		$this->render('admin',array(
			'model'=>$model,
		));
	}

    public function actionPrintDamascusList()
    {
        if (!isset($_GET['damascus_list_id'])) {
            throw new CHttpException(400, 'طلب خاطئ');
        }
        $this->layout = "//layouts/blank";
        $this->pageTitle = "طباعة لائحة دمشق";
        $damascus_list_id = intval($_GET['damascus_list_id']);
        $damascusList = $this->loadModel($damascus_list_id);
        $entries = $damascusList->damascusListEntries;
        $this->render('print_damascus_list', array(
            'damascusList' => $damascusList,
            'entries' => $entries,
        ));
    }
    public function actionGetDamascusListOptions(){
        if(isset($_GET['id'])){
            $id = intval($_GET['id']);
            $model = DamascusList::model()->findByPk($id);
            echo $this->renderPartial('d_list_options',array('model'=>$model),false,true);
        }else{
            throw new CHttpException(400,'خطأ في الطلب');
        }
        Yii::app()->end();
    }

    public function actionGetUpdateForm($id)
    {
        $model = DamascusList::model()->findByPk($id);
        echo $this->renderPartial('damascus_list_update', array(
            'model' => $model,
        ), false, true);
        Yii::app()->end();
    }
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return DamascusList the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=DamascusList::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
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
	 * @param DamascusList $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='damascus-list-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
