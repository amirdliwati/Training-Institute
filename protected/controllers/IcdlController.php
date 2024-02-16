<?php

include "BaseController.php";

class IcdlController extends BaseController
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
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
        if(Yii::app()->request->isAjaxRequest){
            $model=new ICDLCard('create');
            if(isset($_POST['ICDLCard']))
            {
                $model->attributes=$_POST['ICDLCard'];
                if($model->save()){
                    echo CJSON::encode(array(
                        'status'=>true,
                        'message'=>'تم إنشاء بطاقة ICDL جديدة بالرقم: '.$model->un_code,
                    ));
                }else{

                    echo CJSON::encode(array(
                        'status'=>false,
                        'message'=>$model->getErrors(),
                    ));
                }
            }else{
                throw new CHttpException(400);
            }
        }else{
            throw new CHttpException(400);
        }
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

		if(isset($_POST['ICDLCard']))
		{
            $model->setScenario('update');
			$model->attributes=$_POST['ICDLCard'];
			if($model->save()){
                echo CJSON::encode(array(
                    'status'=>true,
                    'message'=>'تم تعديل البطاقة ICDL: '.$model->un_code,
                ));
            }else{
                echo CJSON::encode(array(
                    'status'=>false,
                    'message'=>'فشل في تعديل البطاقة',
                ));
            }

		}


	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete()
	{
		if(isset($_POST['id'])){
            $ICDLCard = $this->loadModel(intval($_POST['id']));
            if($ICDLCard->delete()){
                echo CJSON::encode(array(
                   'status'=>true,
                   'message'=>'تم حذف بطاقة ال ICDL '.$ICDLCard->un_code,
                ));
            }else{
                echo CJSON::encode(array(
                    'status'=>false,
                    'message'=>'فشل في حذف بطاقة ال ICDL',
                ));
            }
        }else{
            throw new CHttpException(400);
        }
	}

    public function actionGetICDLCardDetails($id){
        $icdlCard = $this->loadModelWithTickets(intval($id));

        echo $this->renderPartial('partial/icdlCardDetails',array(
            'model'=>$icdlCard,
        ),false,true);
    }

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
        $this->pageTitle = "بطاقات ال ICDL";

		$ICDLCardModel=new ICDLCard('search');
        $ICDLCardModel->unsetAttributes();
        if(isset($_GET['ICDLCard'])){
            $ICDLCardModel->attributes = $_GET['ICDLCard'];
        }
		$this->render('index',array(
			'ICDLCardModel'=>$ICDLCardModel,
		));
	}

    public function actionExams(){
        $this->pageTitle = "امتحانات ال ICDL";
        $ICDLTicket = new ICDLTicket('search');
        $ICDLTicket->unsetAttributes();
        if(isset($_GET['ICDLTicket'])){
            $ICDLTicket->attributes = $_GET['ICDLTicket'];
        }

        $this->render('exams',array(
            'ICDLTicketModel'=>$ICDLTicket,
        ));
    }
    public function actionPrintExams(){
        $this->layout = "//layouts/blank";

        $this->pageTitle = "طباعة اسماء امتحان ICDL";
        $criteria = new CDbCriteria();

        if(isset($_GET['date'],$_GET['time'])){
            if(strlen($_GET['date'])>0 && strlen($_GET['time'])>0){
                $criteria->compare('date',$_GET['date']);
                $criteria->compare('time',$_GET['time']);
            }else{
                $this->redirect(array('icdl/exams','rel'=>'print-exam'));
            }
        }else{
            throw new CHttpException(400);
        }
        $ICDLTickets = ICDLTicket::model()->with('icdlCard')->findAll($criteria);
        $this->render('print_exams',array(
            'tickets'=>$ICDLTickets,
        ));

    }

    /**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new ICDLCard('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ICDLCard']))
			$model->attributes=$_GET['ICDLCard'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=ICDLCard::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
    public function loadICDLTicketModel($id)
    {
        $model=ICDLTicket::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }
    public function loadModelWithTickets($id)
    {
        $model=ICDLCard::model()->with('tickets')->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    public function actionGetICDLCardCreateForm(){
        $ICDLCard = new ICDLCard('create');
        $ICDLCard->student_id = intval(130);
        echo $this->renderPartial('_form',array(
            'model'=>$ICDLCard,
        ),false,true);
    }

    public function actionGetICDLTicketCreateForm($id){
        $ICDLCard = $this->loadModel(intval($id));
        $model = new ICDLTicket('create');
        $model->icdl_card_id = $ICDLCard->id;
        echo $this->renderPartial('partial/icdl-ticket-form',array(
            'model'=>$model,
            'ICDLCard'=>$ICDLCard,
        ),false,true);
    }
    public function actionICDLTicketCreate(){
        if(Yii::app()->request->isAjaxRequest){
            if(isset($_POST['ICDLTicket'])){
                $model = new ICDLTicket('create');
                $model->attributes =$_POST['ICDLTicket'];
                if($model->save()){
                    echo CJSON::encode(array(
                        'status'=>true,
                        'message'=>'تم ادخال تذكرة امتحان بنجاح ',
                    ));
                }else{
                    echo CJSON::encode(array(
                        'status'=>false,
                        'message'=>'حدث خطأ عند ادخال تذكرة امحتان. تأكد من اكتمال ادخال البيانات',
                    ));
                }
            }else{
                throw new CHttpException(400);
            }
        }else{
            throw new CHttpException(400);
        }

    }

    public function actionGetICDLTicketUpdateForm($id){
        $ticketModel = $this->loadICDLTicketModel(intval($id));

        echo $this->renderPartial('partial/icdl-ticket-form',array(
            'model'=>$ticketModel,
            'ICDLCard'=>$ticketModel->icdlCard,
        ),false,true);
    }
    public function actionICDLTicketUpdate($id){

        if(isset($_POST['ICDLTicket'])){
            $model = $this->loadICDLTicketModel(intval($id));
            $model->setScenario('update');
            $model->attributes = $_POST['ICDLTicket'];
            if($model->save()){
                echo CJSON::encode(array(
                    'status'=>true,
                    'message'=>'تم تعديل بيانات التذكرة بنجاح',
                ));
            }else{
                echo CJSON::encode(array(
                    'status'=>false,
                    'message'=>'فشل في تعديل بيانات التذكرة. تأكد من اكتمال البيانات',
                ));
            }
        }else{
            throw new CHttpException(400);
        }
    }
    public function actionICDLTicketDelete()
    {
        if(isset($_POST['id'])){
            $model = $this->loadICDLTicketModel(intval($_POST['id']));
            if($model->delete()){
                echo CJSON::encode(array(
                    'status'=>true,
                    'message'=>'تم حذف التذكرة بنجاح',
                ));
            }else{
                echo CJSON::encode(array(
                    'status'=>false,
                    'message'=>'حدث خطأ عند حذف التذكرة',
                ));
            }
        }else{
            throw new CHttpException(400);
        }
    }

    public function actionGetTicketList($id){
        $model = $this->loadModelWithTickets(intval($id));
        echo $this->renderPartial('partial/ticket-list',array(
            'model'=>$model,
        ),false,true);
    }
    public function actionGetICDLCardUpdateForm($id){
        $ICDLCard = $this->loadModel(intval($id));
        echo $this->renderPartial('_form',array(
            'model'=>$ICDLCard,
        ),false,true);
    }
	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */

    public function renderICDLCardOptions($data,$row){
        echo $this->renderPartial('partial/icdlCardOptions',array(
            'model'=>$data,
        ),false,false);
    }
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='icdlcard-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
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
}
