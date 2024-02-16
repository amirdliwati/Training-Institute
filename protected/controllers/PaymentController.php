<?php

include "BaseController.php";

class PaymentController extends BaseController
{

    public $_student;
    public $_course;

    const EXTRA_PAYMENT_OPTIONS_TOKEN = 1;

    public function filters()
    {
        return array(
            'postOnly + delete', // we only allow deletion via POST request
            'studentContext +payments,addDiscount',
            'courseContext +payments,addDiscount',
            'checkAccess',
        );
    }

    /*
    public function actionCourse_payments()
    {
        $this->render('course_payments');
    }

    public function actionIndex()
    {
        $this->render('index');
    }
    */

    public function actionGetStudentDropList($course_type_id){
        $courses = Course::model()->with('students')->findAll('status in (:status) AND course_type_id = :course_type_id',array(
            ':status'=>implode(',',array(Course::STATUS_IN_PROGRESS,Course::STATUS_FINISHED)),
            ':course_type_id'=>$course_type_id,
        ));

        $this->renderPartial('partials/students_drop_list',array(
            'courses'=>$courses,
        ));

    }
    public function actionCreate(){
        $this->pageTitle = "نموذج ادخال الفواتير";
        $this->layout = "//layouts/column2";
        $message="";
        $lastPaymentReport = "";
        $payment = new Payment('create');

        $payment->num = 0;
        $payment->date = date('Y-m-d');
        if(isset($_POST['Payment'])){
            $payment->attributes = $_POST['Payment'];
            if(!empty($_POST['Payment']['student_course_id'])){
                $paymentIds = explode(',',$_POST['Payment']['student_course_id']);
                $payment->course_id = $paymentIds[0];
                $payment->student_id = $paymentIds[1];
            }

            if($payment->save()){
                //Build Report message
                $student = $this->loadStudentModel($payment->student_id);
                $name = $student->getName();
                $course = $this->loadCourseModel($payment->course_id);
                $payments = Payment::model()->findAll("student_id=:student_id AND course_id=:course_id", array(
                    ":student_id" => $student->id,
                    ":course_id" => $course->id,
                ));
                $courseCost = intval($course->getCostText());
                $paid = 0;
                foreach ($payments as $payment) {
                    $paid += $payment->amount;
                }
                $discount = intval($this->getStudentDiscount($payment->student_id, $payment->course_id));
                $remaining = $courseCost - $paid - $discount;
                $message .= "<p>تم اضافة الفاتورة بنجاح</p>";
                $message .= "<p>اسم الطالب: $name</p>";
                $message .= "<p>المدفوع: $paid</p>";
                $message .= "المتبقي للدفع: ".$remaining;
                // Unset the attribute to add a new Payment model
                $payment->unsetAttributes();
                $payment->num = 0;
                $payment->date = date('Y-m-d');
                $payment->isNewRecord = true;
            }
        }
        $this->render('create',array(
            'model'=>$payment,
            'message'=>$message,
            'lastPaymentReport'=>$lastPaymentReport,
        ));
    }

    public function actionPayments()
    {
        if (!$this->_student->isAttendingCourse($this->_course->id)) {
            $this->redirect(array('student/view', 'id' => $this->_student->id));
        }
        $this->layout = "//layouts/column2";
        $this->pageTitle = "سجل المدفوعات";
        $dataProvider = new CActiveDataProvider('Payment', array(
            'criteria' => array(
                'condition' => 'student_id=:student_id AND course_id=:course_id',
                'params' => array(
                    ':course_id' => $this->_course->id,
                    ':student_id' => $this->_student->id,
                ),
                //'order'=>'num ASC',
            ),
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));
        $this->render('payments', array(
            'dataProvider' => $dataProvider,
        ));

    }

    public function actionPay()
    {
        if (isset($_POST['Payment'])) {
            $model = new Payment('create');
            $model->attributes = $_POST['Payment'];
            $model->date = date('Y-m-d');
            if ($model->num == 0) {
                $model->num = Payment::model()->getLastPaymentNo($_POST['Payment']['student_id'], $_POST['Payment']['course_id']) + 1;
            }
            if ($model->save()) {
                echo CJSON::encode(array('status' => 'success', 'message' => 'تم اضافة فاتورة جديدة'));
            } else {
                $form = new CActiveForm;
                echo CJSON::encode(array('status' => 'fail', 'message' => $form->errorSummary($model, 'رجاء اصلح الأخطاء التالية:')));
            }
        }
        Yii::app()->end();
    }

    public function actionBills()
    {
        $this->pageTitle = "إدارة فواتير المعهد";
        $this->layout = "//layouts/column2";
        $model = new Payment('search');
        $model->unsetAttributes();
        if (isset($_GET['Payment'])) {
            $model->attributes = $_GET['Payment'];
            $studentFirstName = $_GET['student_first_name'];
            $studentLastName = $_GET['student_last_name'];
            $criteria = new CDbCriteria;
            $criteria->compare('first_name', $studentFirstName, true);
            $criteria->compare('last_name', $studentLastName, true);
            $students = Student::model()->findAll($criteria);
            $student_array = array();
            foreach ($students as $student) {
                $student_array[] = $student->id;
            }
            $course_array = array();
            $course_type_id = intval($_GET['Payment']['course_id']);
            if (isset($course_type_id) && $course_type_id > 0) {
                foreach (CourseType::model()->findByPk($course_type_id)->courses as $course) {
                    $course_array[] = $course->id;
                }
            }
            $model->course_id = $course_array;
            $model->student_id = $student_array;
        }
        $this->render('bills', array(
            'paymentModel' => $model,
        ));
    }

    public function actionStudent_payments()
    {
        $this->render('student_payments');
    }

    public function actionAddDiscount()
    {
        $discount = $this->getStudentDiscount($this->_student->id, $this->_course->id);
        echo $this->renderPartial('partials/add_discount_form', array(
            'discount' => $discount,
            'student_id' => $this->_student->id,
            'course_id' => $this->_course->id,
        ), false, true);
        Yii::app()->end();
    }

    public function actionPostDiscount()
    {
        if (!isset($_POST['discount'])) {
            throw new CHttpException(400, 'خطأ في الإدخال');
        }
        $discount = $_POST['discount'];
        $course_id = $_POST['course_id'];
        $student_id = $_POST['student_id'];

        $course = $this->loadCourseModel($course_id);
        $student = $this->loadStudentModel($student_id);

        $payments = Payment::model()->findAll("student_id=:student_id AND course_id=:course_id", array(
            ":student_id" => $student->id,
            ":course_id" => $course->id,
        ));
        $courseCost = $course->cost;
        $paid = 0;
        foreach ($payments as $payment) {
            $paid += $payment->amount;
        }

        if ($discount < 0 || $discount > $courseCost - $paid) {
            echo CJSON::encode(array(
                'status' => false,
                'message' => 'الرقم المدخل قد يكون اكبر من اللازم او خاطئ',
            ));
            Yii::app()->end();
        } else {
            $command = Yii::app()->db->createCommand();
            $rowNum = $command->update('tbl_student_course_assignment', array(
                    'discount' => $discount
                ),
                'student_id=:student_id AND course_id=:course_id',
                array(
                    ':student_id' => $student->id,
                    ':course_id' => $course->id,
                ));
            if ($rowNum == 1) {
                echo CJSON::encode(array(
                    'status' => true,
                    'message' => 'تم اضافة حسم للطالب',
                ));
            } else {
                echo CJSON::encode(array(
                    'status' => false,
                    'message' => 'حدث خطأ في اعطاء حسم للطالب',
                ));
            }
            Yii::app()->end();
        }
    }

    public function actionGetPaymentForm($sId)
    {
        if (Yii::app()->request->isAjaxRequest) {
            if (!isset($_GET['ref'])) {
                throw new CHttpException(400);
            }
            $payment = new Payment;
            $student = $this->loadStudentModel($sId);
            $course = null;
            if (isset($_GET['cId'])) {
                $cId = $_GET['cId'];
                $course = $this->loadCourseModel($cId);
            } else if ($_GET['ref'] == "course_page") {
                throw new CHttpException(400);
            }
            $paymentInfo = array();
            $courseList = array();
            $payment->course_id = "";
            if ($_GET['ref'] == "course_page") {
                $payment->course_id = $cId;
                $payments = Payment::model()->findAll("student_id=:student_id AND course_id=:course_id", array(
                    ":student_id" => $student->id,
                    ":course_id" => $course->id,
                ));
                $courseCost = intval($course->getCostText());
                $paid = 0;
                foreach ($payments as $payment) {
                    $paid += $payment->amount;
                }
                $discount = intval($this->getStudentDiscount($sId, $cId));
                $remaining = $courseCost - $paid - $discount;
                $paymentInfo['cost'] = $courseCost;
                $paymentInfo['paid'] = $paid;
                $paymentInfo['remaining'] = $remaining;
                $paymentInfo['discount'] = $discount;
            } else if ($_GET['ref'] == 'student_page') {
                if (empty($student->courses)) {
                    $courseList[""] = "لايوجد دورات ملتحق بها";
                } else {
                    foreach ($student->courses as $course) {
                        $courseList[$course->id] = $course->courseType->name . " | " . $course->start_date . " ----> " . $course->end_date;
                    }
                }
            }


            $payment->student_id = $sId;
            echo $this->renderPartial('add_form', array(
                'model' => $payment,
                'student' => $student,
                'paymentInfo' => $paymentInfo,
                'courseList' => $courseList,
                'ref' => $_GET['ref'],
            ), false, true);
        } else {
            throw new CHttpException(403);
        }
    }


    public function actionGetPaymentOptions($id)
    {
        $payment = $this->loadModel($id);
        echo $this->renderPartial('partials/payment_options', array(
            'payment' => $payment,
        ), false, true);
        Yii::app()->end();
    }

    public function actionGetUpdateForm($id)
    {
        $payment = Payment::model()->findByPk($id);
        echo $this->renderPartial('partials/payment_update', array(
            'model' => $payment,
        ), false, true);
        Yii::app()->end();
    }

    public function actionUpdatePayment($id)
    {
        $payment = $this->loadModel($id);
        if (isset($_POST['Payment'])) {
            $payment->setScenario('update');
            $payment->note = $_POST['Payment']['note'];
            $payment->num = $_POST['Payment']['num'];
            $payment->date = $_POST['Payment']['date'];
        }
        if ($payment->save()) {
            echo CJSON::encode(array(
                'status' => true,
                'message' => 'تم تعديل الفاتورة بنجاح',
            ));
        } else {
            echo CJSON::encode(array(
                'status' => false,
                'message' => 'فشلت محاولة التعديل',
            ));
        }
        Yii::app()->end();
    }

    public function actionGetPaymentInfo($sId, $cId)
    {
        $student = $this->loadStudentModel($sId);
        $course = $this->loadCourseModel($cId);
        $payments = Payment::model()->findAll("student_id=:student_id AND course_id=:course_id", array(
            ":student_id" => $student->id,
            ":course_id" => $course->id,
        ));
        $courseCost = intval($course->getCostText());
        $paid = 0;
        foreach ($payments as $payment) {
            $paid += $payment->amount;
        }
        $discount = intval($this->getStudentDiscount($sId, $cId));
        $remaining = $courseCost - $paid - $discount;
        echo CJSON::encode(array(
            'cost' => $courseCost,
            'paid' => $paid,
            'remaining' => $remaining,
            'discount' => $discount,
        ));
        Yii::app()->end();
    }

    public function getStudentDiscount($student_id, $course_id)
    {
        // Get the discount of the student ...
        $command = Yii::app()->db->createCommand();
        $assignments = $command->select('*')
            ->from('tbl_student_course_assignment')
            ->where('student_id = :student_id AND course_id = :course_id', array(
                ':student_id' => $student_id,
                ':course_id' => $course_id,
            ))
            ->queryAll();
        $assignment = $assignments[0];
        return $assignment['discount'];
    }

    public function actionDeletePayment()
    {
        if (!isset($_POST['id'])) {
            throw new CHttpException(403);
        }

        if ($_POST['extra_payment_options_token'] == PaymentController::EXTRA_PAYMENT_OPTIONS_TOKEN) {
            $ref = "bills";
        } else {
            $ref = "payments";
        }
        $id = intval($_POST['id']);
        $payment = $this->loadModel($id);
        if ($payment->delete()) {
            echo CJSON::encode(array(
                'status' => true,
                'message' => 'تم حذف الفاتورة بنجاج',
                'ref' => $ref,
            ));
        } else {
            echo CJSON::encode(array(
                'status' => false,
                'message' => 'لم يتمكن النظام من حذف الفاتورة',
            ));
        }
    }

    public function filterStudentContext($filterChain)
    {
        // make sure the have the student context available
        if (!isset($_GET['sId'])) {
            throw new CHttpException(403, 'The request is not valid!');
        } else {
            $this->_student = $this->loadStudentModel($_GET['sId']);
        }
        $filterChain->run();
    }

    public function filterCourseContext($filterChain)
    {
        // make sure the have the student context available
        if (!isset($_GET['cId'])) {
            throw new CHttpException(403, 'The request is not valid!');
        } else {
            $this->_course = $this->loadCourseModel($_GET['cId']);
        }
        $filterChain->run();
    }

    public function loadStudentModel($student_id)
    {
        if (isset($_GET['ref'])) {
            if ($_GET['ref'] == "student_page") {
                $student = Student::model()->with("courses", "courses.courseType")->findByPk($student_id);
            } else if ($_GET['ref'] == "course_page") {
                $student = Student::model()->findByPk($student_id);
            }
        } else {
            $student = Student::model()->findByPk($student_id);
        }
        if ($student == null) {
            throw new CHttpException(404);
        } else {
            return $student;
        }
    }

    public function filterCheckAccess($filterChain)
    {
        if (Yii::app()->user->isGuest) {
            $this->redirect(array('site/login'));
        }
        if (!Yii::app()->user->checkAccess('adminApp')) {
            $this->redirect(array('site/login'));
        } else {
            $filterChain->run();
        }
    }

    public function loadCourseModel($course_id)
    {
        $course = Course::model()->with('students')->findByPk($course_id);
        if ($course == null) {
            throw new CHttpException(404);
        } else {
            return $course;
        }
    }

    public function loadModel($id)
    {
        $payment = Payment::model()->findByPk($id);
        if ($payment == null) {
            throw new CHttpException(404);
        } else {
            return $payment;
        }
    }

}