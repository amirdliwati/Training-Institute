<?php

include "BaseController.php";

class DamascusListEntryController extends BaseController
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

			//'postOnly + delete', // we only allow deletion via POST request
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
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */

    public function actionGetDamascusListEntryUpdateForm($id){
        $model = $this->loadModel(intval($id));
        $model->setScenario('edit-dates');
        echo $this->renderPartial('partials/edit_entry_dates_form',array(
            'model'=>$model,
        ),false,true);
    }

    public function actionUpdateDates(){
        if(isset($_POST['DamascusListEntry']) && Yii::app()->request->isAjaxRequest){
            $model = $this->loadModel(intval(($_POST['DamascusListEntry']['id'])));
            $model->setScenario('edit-dates');
            $model->damascus_list_no = $model->damascusList->num;
            $model->start_date = $_POST['DamascusListEntry']['start_date'];
            $model->end_date = $_POST['DamascusListEntry']['end_date'];
            if($model->save()){
                echo CJSON::encode(array(
                    'message'=>'تم تعديل تاريخ العنصر المطلوب',
                    'status'=>true,
                ));
            }else{
                echo CJSON::encode(array(
                    'message'=>'لم يتم تعديل تاريخ العنصر',
                    'status'=>false,
                ));
            }
        }else{
            throw new CHttpException(403);
        }
    }
	public function actionCreate()
	{
		$model=new DamascusListEntry;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['DamascusListEntry']))
		{
			$model->attributes=$_POST['DamascusListEntry'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['DamascusListEntry']))
		{
			$model->attributes=$_POST['DamascusListEntry'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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
	public function actionDelete()
	{
        if(isset($_GET['id'])){
            $id = intval($_GET['id']);
            if($this->loadModel($id)->delete()){
                echo CJSON::encode(array(
                    'status'=>true,
                    'message'=>'تم حذف الطالب من لائحة دمشق بنجاح',
                ));
            }else{
                echo CJSON::encode(array(
                    'status'=>false,
                    'message'=>'حدثت مشكلةاثناء حذف الطالب',
                ));
            }
        }else{
            throw new CHttpException(400);
        }


	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('DamascusListEntry');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new DamascusListEntry('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['DamascusListEntry']))
			$model->attributes=$_GET['DamascusListEntry'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return DamascusListEntry the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=DamascusListEntry::model()->findByPk($id);
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
	 * @param DamascusListEntry $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='damascus-list-entry-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
