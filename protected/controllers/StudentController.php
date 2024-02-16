<?php

include "BaseController.php";

class StudentController extends BaseController
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';
    public $_student;
    public $main_section_title;
    public $_course;

    public $_course_type_id;
    public $_registration = array();

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'studentContext + register,payments,getRegisterForWaitForm', // To enforce the student context when asking for the listed actions
            'courseContext +payments', // To enforce the course context when asking for the listed actions
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
                'actions' => array('index', 'view', 'register', 'RetrieveWaitingList', 'Waitinglist', 'create', 'update', 'payments'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }


    public function actionGetPrintContractForm($sId)
    {
        $student = $this->loadModel($sId);
        if (empty($_GET['course_type_id'])) {
            throw new CHttpException(400);
        }
        $this->renderPartial('print-contract-form', array('student' => $student, 'course_type_id' => $_GET['course_type_id']));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->pageTitle = 'لوحة ادارة طالب';
        $studentModel = $this->loadModel($id);

        $courseDataProvider = new CActiveDataProvider('Course');
        $courses = $studentModel->courses;
        foreach ($courses as $course) {
            $course->student_id = $studentModel->id;
        }
        $courseDataProvider->setData($courses);

        $this->render('view', array(
            'model' => $studentModel,
            'courseDataProvider' => $courseDataProvider,
            'onWaitRegistrations' => $studentModel->registrations,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $this->pageTitle = "تسجيل طالب جديد";
        $this->layout = '//layouts/column2';
        $studentModel = new Student('create');
        $phoneNoModel = new PhoneNumber('create');
        $mobileNoModel = new PhoneNumber('create');
        $mobileNoModel->setScenario('mobile_no');
        $phoneNoModelExtra = new PhoneNumber('create');
        $mobileNoModelExtra = new PhoneNumber('create');
        $mobileNoModelExtra->setScenario('mobile_no');
        $registrationModel = new Registration;
        $message = "";
        if (isset($_POST['Student'])) {
            //$student = Student::model()->find('national_no=:national_no', array(
            //  ':national_no' => $_POST['Student']['national_no'],
            //));
            //if ($student == null) {
            $studentModel->attributes = $_POST['Student'];
            $registrationModel->attributes = $_POST['Registration'];
            $valid = $studentModel->validate() && $registrationModel->course_type_id > 0;
            if ($valid) {
                $father_name = $studentModel->father_name;
                $first_name = $studentModel->first_name;
                $last_name = $studentModel->last_name;
                $queryStudent = Student::model()->find('first_name=:first_name AND last_name=:last_name AND father_name=:father_name', array(
                    ':first_name' => $first_name,
                    ':last_name' => $last_name,
                    ':father_name' => $father_name,
                ));
                if ($queryStudent == null) {
                    $studentModel->save(false);
                    $registrationModel->student_id = $studentModel->id;
                    $registrationModel->status = Student::STATUS_WAITING;
                    $registrationModel->registration_date = date('Y-m-d');
                    $registrationModel->save();

                    //Phone Number Model
                    $phoneNoModel->number = $_POST['PhoneNumber'][1]['number'];
                    $phoneNoModel->type = PhoneNumber::HOME_NUMBER;
                    $phoneNoModel->owner_id = $studentModel->id;
                    $phoneNoModel->save();
                    $phoneNoModelExtra->number = $_POST['PhoneNumber'][3]['number'];
                    $phoneNoModelExtra->type = PhoneNumber::HOME_NUMBER;
                    $phoneNoModelExtra->owner_id = $studentModel->id;
                    $phoneNoModelExtra->save();

                    //Mobile Number Model
                    $mobileNoModel->number = $_POST['PhoneNumber'][2]['number'];
                    $mobileNoModel->type = PhoneNumber::MOBILE_NUMBER;
                    $mobileNoModel->owner_id = $studentModel->id;
                    $mobileNoModel->save();
                    $mobileNoModelExtra->number = $_POST['PhoneNumber'][4]['number'];
                    $mobileNoModelExtra->type = PhoneNumber::MOBILE_NUMBER;
                    $mobileNoModelExtra->owner_id = $studentModel->id;
                    $mobileNoModelExtra->save();

                    $link = CHtml::link($studentModel->first_name . " " . $studentModel->last_name,
                        $this->createUrl('view', array(
                            'id' => $studentModel->id
                        )));
                    $message = "تم تسجيل الطالب بنجاح " . $link;
                } else {
                    $link = CHtml::link($queryStudent->first_name . " " . $queryStudent->last_name,
                        $this->createUrl('view', array(
                            'id' => $queryStudent->id
                        )));
                    $message = " الطالب " . $link . " موجود مسبقا";
                }
                $studentModel = new Student('create');
                $phoneNoModel = new PhoneNumber('create');
                $mobileNoModel = new PhoneNumber('create');
                $registrationModel = new Registration;
                $phoneNoModelExtra = new PhoneNumber('create');
                $mobileNoModelExtra = new PhoneNumber('create');
            }
            //}
        }
        $phoneNoModel->clearErrors();
        $mobileNoModel->clearErrors();
        $phoneNoModelExtra->clearErrors();
        $mobileNoModelExtra->clearErrors();
        $mobileNoModelExtra->setScenario('mobile_no');
        $mobileNoModel->setScenario('mobile_no');
        $this->render('create', array(
            'registrationModel' => $registrationModel,
            'studentModel' => $studentModel,
            'phoneNoModel' => $phoneNoModel,
            'mobileNoModel' => $mobileNoModel,
            'phoneNoModelExtra' => $phoneNoModelExtra,
            'mobileNoModelExtra' => $mobileNoModelExtra,
            'message' => $message,
        ));
    }

    public function actionViewContactInfo($ids, $ctid)
    {
        $this->layout = "//layouts/blank";
        $this->pageTitle = "بيانات الاتصال";
        $criteria = new CDbCriteria;
        $criteria->compare('student_id', explode(',', $ids));
        $criteria->compare('course_type_id', $ctid);
        $registrations = Registration::model()->findAll($criteria);
        $this->render("view_contact_info", array(
            'registrations' => $registrations,
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
        $model = $this->loadModel($id);

        if (count($model->telNo) > 0) {
            $phoneNoModel = $model->telNo[0];
            if (count($model->telNo) > 1) {
                $phoneNoModelExtra = $model->telNo[1];
            } else {
                $phoneNoModelExtra = new PhoneNumber('create');
            }
        } else {
            $phoneNoModelExtra = new PhoneNumber('create');
            $phoneNoModel = new PhoneNumber('create');
        }
        if (count($model->mobileNo) > 0) {
            $mobileNoModel = $model->mobileNo[0];
            if (count($model->mobileNo) > 1) {
                $mobileNoModelExtra = $model->mobileNo[1];
            } else {
                $mobileNoModelExtra = new PhoneNumber('create');
            }
        } else {
            $mobileNoModelExtra = new PhoneNumber('create');
            $mobileNoModel = new PhoneNumber('create');
        }
        $mobileNoModelExtra->setScenario('mobile_no');
        $mobileNoModel->setScenario('mobile_no');
        $message = "";
        $this->pageTitle = "تعديل بيانات الطالب " . $model->first_name . " " . $model->last_name;
        if (isset($_GET['ajax_validate'])) {
            $this->performAjaxValidation($model);
            Yii::app()->end();
        }
        if (isset($_POST['Student'])) {
            $model->attributes = $_POST['Student'];
            if ($model->save()) {
                if (strlen($_POST['PhoneNumber'][1]['number']) > 0) {
                    $phoneNoModel->number = $_POST['PhoneNumber'][1]['number'];
                    if ($phoneNoModel->isNewRecord) {
                        $phoneNoModel->owner_id = $model->id;
                        $phoneNoModel->type = PhoneNumber::HOME_NUMBER;
                    }
                    $phoneNoModel->save();
                } else {
                    if (!$phoneNoModel->isNewRecord) {
                        $phoneNoModel->delete();
                    }
                }
                if (strlen($_POST['PhoneNumber'][3]['number']) > 0) {
                    $phoneNoModelExtra->number = $_POST['PhoneNumber'][3]['number'];
                    if ($phoneNoModelExtra->isNewRecord) {
                        $phoneNoModelExtra->owner_id = $model->id;
                        $phoneNoModelExtra->type = PhoneNumber::HOME_NUMBER;
                    }
                    $phoneNoModelExtra->save();
                } else {
                    if (!$phoneNoModelExtra->isNewRecord) {
                        $phoneNoModelExtra->delete();
                    }
                }
                if (strlen($_POST['PhoneNumber'][2]['number']) > 0) {
                    $mobileNoModel->number = $_POST['PhoneNumber'][2]['number'];
                    if ($mobileNoModel->isNewRecord) {
                        $mobileNoModel->owner_id = $model->id;
                        $mobileNoModel->type = PhoneNumber::MOBILE_NUMBER;
                    }
                    $mobileNoModel->save();
                } else {
                    if (!$mobileNoModel->isNewRecord) {
                        $mobileNoModel->delete();
                    }
                }
                if (strlen($_POST['PhoneNumber'][4]['number']) > 0) {
                    $mobileNoModelExtra->number = $_POST['PhoneNumber'][4]['number'];
                    if ($mobileNoModelExtra->isNewRecord) {
                        $mobileNoModelExtra->owner_id = $model->id;
                        $mobileNoModelExtra->type = PhoneNumber::MOBILE_NUMBER;
                    }
                    $mobileNoModelExtra->save();
                } else {
                    if (!$mobileNoModelExtra->isNewRecord) {
                        $mobileNoModelExtra->delete();
                    }
                }
                $this->redirect(array('view', 'id' => $model->id));
            }
        }
        $this->render('update', array(
            'model' => $model,
            'phoneNoModel' => $phoneNoModel,
            'mobileNoModel' => $mobileNoModel,
            'mobileNoModelExtra' => $mobileNoModelExtra,
            'phoneNoModelExtra' => $phoneNoModelExtra,
            'message' => $message,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $student = $this->loadModel($id);
        $name = $student->getName();
        if ($student->isDeletable()) {
            $phoneNo = $student->mobileNo;
            $telNo = $student->telNo;
            foreach ($phoneNo as $no) {
                $no->delete();
            }
            foreach ($telNo as $no) {
                $no->delete();
            }
            $student->delete();
            $this->redirect(array('student/index'));
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
        $this->pageTitle = "لوحة ادارة الطلاب";
        $this->layout = "//layouts/column2";
        $model = new Student('search');
        $model->id = -1;
        if (isset($_GET['Student'])) {
            $model->unsetAttributes();
            $model->attributes = $_GET['Student'];
            $attributes = $model->getAttributes();
            foreach ($attributes as $key => $value) {
                $attributes[$key] = trim($value);
            }
            $model->setAttributes($attributes);
        }
        $this->render('index', array(
            'model' => $model,
        ));
    }


    public function actionGetStudentUpdateForm($id, $cTId)
    {
        if (Yii::app()->request->isAjaxRequest) {
            $model = $this->loadModel(intval($id));

            if (count($model->telNo) > 0) {
                $phoneNoModel = $model->telNo[0];
                if (count($model->telNo) > 1) {
                    $phoneNoModelExtra = $model->telNo[1];
                } else {
                    $phoneNoModelExtra = new PhoneNumber('create');
                }
            } else {
                $phoneNoModelExtra = new PhoneNumber('create');
                $phoneNoModel = new PhoneNumber('create');
            }
            if (count($model->mobileNo) > 0) {
                $mobileNoModel = $model->mobileNo[0];
                if (count($model->mobileNo) > 1) {
                    $mobileNoModelExtra = $model->mobileNo[1];
                } else {
                    $mobileNoModelExtra = new PhoneNumber('create');
                }
            } else {
                $mobileNoModelExtra = new PhoneNumber('create');
                $mobileNoModel = new PhoneNumber('create');
            }
            $mobileNoModelExtra->setScenario('mobile_no');
            $mobileNoModel->setScenario('mobile_no');
            $registration = Registration::model()->find('student_id=:student_id AND course_type_id=:cTId', array(
                ':student_id' => $model->id,
                ':cTId' => intval($cTId),
            ));
            echo $this->renderPartial('_form', array(
                'studentModel' => $model,
                'phoneNoModel' => $phoneNoModel,
                'phoneNoModelExtra' => $phoneNoModelExtra,
                'mobileNoModel' => $mobileNoModel,
                'mobileNoModelExtra' => $mobileNoModelExtra,
                'registration' => $registration,
            ), false, true);
        } else {
            throw new CHttpException(400);
        }

    }

    public function actionShowStudentContact($student_ids)
    {
        if (strlen($student_ids) == 0) {
            throw new CHttpException(500);
        } else {
            $contacts = PhoneNumber::model()->findAll('owner_id in (' . $student_ids . ') AND type=:type', array(
                ':type' => PhoneNumber::MOBILE_NUMBER,
            ));
        }
        $numbers = '';
        if (empty($contacts)) {
            $numbers = 'لايوجد ارقام هواتف خليوية للطلاب المختارين';
        } else {
            foreach ($contacts as $contact) {
                $numbers .= $contact->number . " ";
            }
        }

        echo $this->renderPartial('partials/showStudentContact', array(
            'numbers' => $numbers,
        ), false, true);
    }

    public function actionGetWaitingListCount()
    {
        if (isset($_GET['course_type_id']) && strlen($_GET['course_type_id']) > 0) {
            $course_type_id = $_GET['course_type_id'];
            $courseType = $this->loadCourseTypeModel($course_type_id);
            echo CJSON::encode(array(
                'caption' => "عدد الطلاب المنتظرين في دورة " . $courseType->name . ": ",
                'studentCount' => $courseType->studentWaitingCount,
                'isSpecificCourse' => true,
            ));
        } else {
            $command = Yii::app()->db->createCommand("select COUNT(*) from tbl_student_course_type_assignment");
            $row = $command->queryRow();
            echo CJSON::encode(array(
                'caption' => "عدد الطلاب في لائحة الانتظار: ",
                'studentCount' => $row['COUNT(*)'],
                'isSpecificCourse' => false,
            ));
        }


    }

    public function actionGetStudentCourseOptions()
    {
        if (!isset($_GET['sId']) || !isset($_GET['cId'])) {
            throw new CHttpException(400);
        }
        if (isset($_GET['ref'])) {
            $ref = $_GET['ref'];
        }
        $student_id = intval($_GET['sId']);
        $course_id = intval($_GET['cId']);
        $student = $this->loadModel($student_id);
        $course = $this->loadCourseModel($course_id);
        echo $this->renderPartial('partials/student_course_options', array(
            'student' => $student,
            'course' => $course,
            'ref' => $ref,
        ), false, true);
        Yii::app()->end();
    }

    public function actionGetRegisterForWaitForm()
    {
        $model = new Registration;
        $model->student_id = $this->_student->id;
        echo $this->renderPartial('partials/register_for_wait', array(
            'model' => $model,
            'student' => $this->_student,
        ), false, true);
        Yii::app()->end();
    }

    public function actionUpdateStudentInfo($id, $cTId)
    {
        if (isset($_POST['Student']) && Yii::app()->request->isAjaxRequest) {
            $model = $this->loadModel(intval($id));

            if (count($model->telNo) > 0) {
                $phoneNoModel = $model->telNo[0];
                if (count($model->telNo) > 1) {
                    $phoneNoModelExtra = $model->telNo[1];
                } else {
                    $phoneNoModelExtra = new PhoneNumber('create');
                }
            } else {
                $phoneNoModelExtra = new PhoneNumber('create');
                $phoneNoModel = new PhoneNumber('create');
            }
            if (count($model->mobileNo) > 0) {
                $mobileNoModel = $model->mobileNo[0];
                if (count($model->mobileNo) > 1) {
                    $mobileNoModelExtra = $model->mobileNo[1];
                } else {
                    $mobileNoModelExtra = new PhoneNumber('create');
                }
            } else {
                $mobileNoModelExtra = new PhoneNumber('create');
                $mobileNoModel = new PhoneNumber('create');
            }
            $mobileNoModelExtra->setScenario('mobile_no');
            $mobileNoModel->setScenario('mobile_no');
            $model->attributes = $_POST['Student'];
            if ($model->save()) {
                if (strlen($_POST['PhoneNumber'][1]['number']) > 0) {
                    $phoneNoModel->number = $_POST['PhoneNumber'][1]['number'];
                    if ($phoneNoModel->isNewRecord) {
                        $phoneNoModel->owner_id = $model->id;
                        $phoneNoModel->type = PhoneNumber::HOME_NUMBER;
                    }
                    $phoneNoModel->save();
                } else {
                    if (!$phoneNoModel->isNewRecord) {
                        $phoneNoModel->delete();
                    }
                }
                if (strlen($_POST['PhoneNumber'][3]['number']) > 0) {
                    $phoneNoModelExtra->number = $_POST['PhoneNumber'][3]['number'];
                    if ($phoneNoModelExtra->isNewRecord) {
                        $phoneNoModelExtra->owner_id = $model->id;
                        $phoneNoModelExtra->type = PhoneNumber::HOME_NUMBER;
                    }
                    $phoneNoModelExtra->save();
                } else {
                    if (!$phoneNoModelExtra->isNewRecord) {
                        $phoneNoModelExtra->delete();
                    }
                }
                if (strlen($_POST['PhoneNumber'][2]['number']) > 0) {
                    $mobileNoModel->number = $_POST['PhoneNumber'][2]['number'];
                    if ($mobileNoModel->isNewRecord) {
                        $mobileNoModel->owner_id = $model->id;
                        $mobileNoModel->type = PhoneNumber::MOBILE_NUMBER;
                    }
                    $mobileNoModel->save();
                } else {
                    if (!$mobileNoModel->isNewRecord) {
                        $mobileNoModel->delete();
                    }
                }
                if (strlen($_POST['PhoneNumber'][4]['number']) > 0) {
                    $mobileNoModelExtra->number = $_POST['PhoneNumber'][4]['number'];
                    if ($mobileNoModelExtra->isNewRecord) {
                        $mobileNoModelExtra->owner_id = $model->id;
                        $mobileNoModelExtra->type = PhoneNumber::MOBILE_NUMBER;
                    }
                    $mobileNoModelExtra->save();
                } else {
                    if (!$mobileNoModelExtra->isNewRecord) {
                        $mobileNoModelExtra->delete();
                    }
                }
                if (isset($_POST['Registration'])) {
                    $registration = Registration::model()->find('student_id=:student_id AND course_type_id=:cTId', array(
                        ':student_id' => $model->id,
                        ':cTId' => intval($cTId),
                    ));
                    $registration->registration_date = date('Y-m-d');
                    $registration->initial_payment_num = $_POST['Registration']['initial_payment_num'];
                    $registration->initial_payment = $_POST['Registration']['initial_payment'];
                    $registration->save(false);
                }
                echo CJSON::encode(array(
                    'status' => true,
                    'message' => 'تم تعديل البيانات الشخصية للطالب بنجاح',
                    'studentId' => $registration->student_id,
                ));
            } else {
                echo CJSON::encode(array(
                    'status' => false,
                    'message' => 'حصل خطأ اثناء تعديل البيانات الشخصية للطالب',
                ));
            }


        } else {
            throw new CHttpException(400);
        }
    }

    public function actionGetWaitingListSummary()
    {
        $command = Yii::app()->db->createCommand();
        $rows = $command->select('count("*") as count,course_type_id,name')
            ->from('tbl_student_course_type_assignment t1')
            ->join('tbl_course_type t2', 't1.course_type_id=t2.id')
            ->group('t1.course_type_id')
            ->order('count DESC')
            ->queryAll();
        echo $this->renderPartial('waiting_list_summary', array(
            'summaryData' => $rows,
        ), false, true);
    }

    public function actionGetPaymentForm($sId, $cId)
    {
        if (Yii::app()->request->isAjaxRequest) {
            $ref = "";
            if (isset($_GET['ref'])) {
                $ref = $_GET['ref'];
            }
            $course = $this->loadCourseModel($cId);
            $student = $this->loadModel($sId);
            $model = new Payment;
            $model->student_id = $student->id;
            $model->course_id = $course->id;
            echo $this->renderPartial('partials/add_payment_form', array(
                'ref' => $ref,
                'model' => $model,
                'student' => $student,
                'course' => $course,
            ), false, true);
        } else {
            throw new CHttpException(403);
        }
    }

    public function actionRegisterForWait()
    {
        if (isset($_POST['Registration'])) {
            $model = new Registration;
            $model->attributes = $_POST['Registration'];
            $model->status = Student::STATUS_WAITING;
            $model->registration_date = date('Y-m-d');
            try {
                if ($model->save()) {
                    echo CJSON::encode(array(
                        'status' => true,
                        'message' => 'تم تسجيل الطالب في لائحة الانتظار بنجاح',
                        'studentId' => $model->student_id,
                    ));

                } else {
                    echo CJSON::encode(array(
                        'status' => false,
                        'message' => "حدث خطا في التسجيل الرجاء عاود المحاولة",
                    ));
                }
            } catch (CDbException $e) {
                echo CJSON::encode(array(
                    'status' => false,
                    'message' => "يبدو ان الطالب موجود مسبقا في لائحة الانتظار",
                ));
            }
        }
    }


    public function actionGetPlainPhones($student_id)
    {
        $ids = explode(',', $student_id);
        $students = [];
        foreach ($ids as $id) {
            $students[] = Student::model()->findByPk($id);
        }
        echo $this->renderPartial('partials/students_phone_no', array(
            'students' => $students,
        ), false, true);

    }

    public function actionUpdateRegistration()
    {
        if (isset($_POST['Registration'])) {
            $student_id = intval($_POST['Registration']['student_id']);
            $course_type_id = intval($_POST['Registration']['course_type_id']);
            $registration = Registration::model()->find('student_id = :student_id AND course_type_id = :course_type_id', array(
                ':student_id' => $student_id,
                ':course_type_id' => $course_type_id,
            ));
            $registration->attributes = $_POST['Registration'];
            $registration->registration_date = $_POST['Registration']['registration_date'];
            if ($registration->save()) {
                echo CJSON::encode(array(
                    'status' => true,
                    'message' => 'تم تعديل بيانات انتظار الطالب بنجاح',
                    'studentId' => $registration->student_id,
                ));
            } else {
                echo CJSON::encode(array(
                    'status' => false,
                    'message' => "حدث خطا في التسجيل الرجاء عاود المحاولة",
                ));
            }

            Yii::app()->end();
        }
    }

    public function actionRegister()
    {
        $model = new Registration;
        $message = "املأ البيانات المطلوبة لتسجيل الطالب في لائحة انظار لدورة:";
        if (isset($_POST['Registration'])) {
            $model->attributes = $_POST['Registration'];
            $model->status = Student::STATUS_WAITING;
            $model->student_id = $this->_student->id;
            $model->registration_date = date('Y-m-d');
            if ($model->save()) {
                $this->redirect(array('student/index'));
            } else {
                $message = "الطالب موجود أصلا في لائحة الانتظار";
            }
        }
        $this->render('register_for_wait', array(
            'model' => $model,
            'message' => $message,
            'student' => $this->_student,
        ));
    }

    /*
     *
     * @param : retrieve all waiting list students in a specific course
     */
    public function actionWaitinglist()
    {
        $this->pageTitle = "لوائح الإنتظار";
        $this->layout = "//layouts/flat";
        $registration = new Registration('search');
        /*
        //If the value of the drop down list (name: course_type_id )is set to a value not empty
        if (isset($_GET['course_type_id']) && strlen($_GET['course_type_id']) > 0) {
            $this->_course_type_id = $_GET['course_type_id'];
            $courseType = CourseType::model()->findByPk($this->_course_type_id);
            if ($courseType == null) {
                throw new CHttpException(404, 'ل يوجد دورة بهذا الأسم');
            }
            $studentWaitingListInCourse = $courseType->getStudentWaitingList();

            if (!empty($studentWaitingListInCourse)) {
                $studentModel->student_id_array = array();
            }
            foreach ($studentWaitingListInCourse as $student) {
                $studentModel->student_id_array[] = $student['student_id'];
            }
        }*/
        $registration->unsetAttributes();
        if (isset($_GET['Registration'])) {
            $registration->attributes = $_GET['Registration'];

        }

        $this->render('waiting_list', array(
            'registrationModel' => $registration,
        ));
    }

    public function actionRetrieveWaitingList($course_type_id)
    {
        /*if (!Yii::app()->request->isAjaxRequest){
            throw new CHttpException(403,'Access Denied');
        }*/
        $connection = Yii::app()->db;
        $command = $connection->createCommand();
        $students = $command->select('*')
            ->from('tbl_student s')
            ->join('tbl_student_course_type_assignment a', 's.id = a.student_id')
            ->where('course_type_id = :course_type_id and status = :status', array(
                ':course_type_id' => $course_type_id,
                ':status' => Student::STATUS_WAITING,
            ))
            ->queryAll();
        header('Content-Type: application/json; charset="UTF-8"');
        echo json_encode($students);
        Yii::app()->end();
    }

    public function actionGetRegistrationUpdateForm()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $student_id = $_GET['sId'];
            $course_type_id = $_GET['cTId'];
            $registration = Registration::model()->find('student_id = :student_id AND course_type_id = :course_type_id', array(
                ':student_id' => $student_id,
                ':course_type_id' => $course_type_id,
            ));
            echo $this->renderPartial('partials/register_for_wait', array(
                'model' => $registration,
            ), false, true);
            Yii::app()->end();
        } else {
            throw new CHttpException(403);
        }
    }

    public function actionDeleteFromRegistration()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $course_type_id = $_GET['cTId'];
            $student_id = $_GET['sId'];
            $ref = $_GET['ref'];
            $command = Yii::app()->db->createCommand();
            $num = $command->delete('tbl_student_course_type_assignment',
                'student_id = :student_id AND course_type_id = :course_type_id',
                array(
                    ':student_id' => $student_id,
                    ':course_type_id' => $course_type_id,
                ));
            if ($num > 0) {
                echo CJSON::encode(array(
                    'status' => true,
                    'message' => 'تم حذف الطالب من الانتظار',
                    'ref' => $ref,
                ));
            } else {
                echo CJSON::encode(array(
                    'status' => false,
                    'message' => 'حدث خطأ اثناء الحذف. حدث الصفحة ثم عاود المحاولة من جديد',
                ));
            }
            Yii::app()->end();
        }
    }

    public function actionGetStudentsNames($term)
    {
        echo CJSON::encode(array(
            array(
                'label' => 'Hello World!',
                'value' => 2,
            ),
        ));
    }

    public function actionGetRegistrationOptions()
    {
        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_GET['ref'])) {
                $ref = $_GET['ref'];
            } else {
                $ref = 'waiting_list';
            }
            $student_id = $_GET['sId'];
            $course_type_id = $_GET['cTId'];
            echo $this->renderPartial('partials/registrationOptionsList', array(
                'student_id' => $student_id,
                'course_type_id' => $course_type_id,
                'ref' => $ref,
            ), false, true);

        } else {
            throw new CHttpException(403);
        }
    }

    public function actionAddPayment()
    {
        if (isset($_POST['Payment'])) {
            $ref = $_POST['ref'];
            $model = new Payment('create');
            $model->attributes = $_POST['Payment'];
            $model->date = date('Y-m-d');
            if ($model->num == 0) {
                $model->num = Payment::model()->getLastPaymentNo($_POST['Payment']['student_id'], $_POST['Payment']['course_id']) + 1;
            }
            if ($model->save()) {
                $student = $this->loadModel($model->student_id);
                $course = $this->loadCourseModel($model->course_id);
                echo CJSON::encode(array('ref' => $ref, 'success' => true, 'message' => 'تم اضافة فاتورة جديدة للطالب ' . $student->getName() . " - دورة " . $course->getCourseNameText()));
            } else {
                $form = new CActiveForm;
                echo CJSON::encode(array('success' => false, 'message' => $form->errorSummary($model, 'رجاء اصلح الأخطاء التالية:')));
            }
        }
        Yii::app()->end();
    }

    public function actionRegisterForCourse()
    {
        if (!isset($_POST['student_id']) || !isset($_POST['course_id'])) {
            throw new CHttpException(400);
        }
        $student_id = intval($_POST['student_id']);
        $course_id = intval($_POST['course_id']);
        $course = $this->loadCourseModel($course_id);
        $this->_student = $this->loadModel($student_id);
        header('Content-Type: application/json; charset="UTF-8"');
        if ($course->registerForCourse($this->_student->id)) {
            echo CJSON::encode(array(
                'success' => 'true',
            ));
        } else {
            echo CJSON::encode(array(
                'success' => 'false',
            ));
        }
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Student('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Student']))
            $model->attributes = $_GET['Student'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }


    // The set of filter used

    public function filterStudentContext($filterChain)
    {
        // make sure the have the student context available
        if (!isset($_GET['sId'])) {
            throw new CHttpException(403, 'The request is not valid!');
        } else {
            $this->_student = $this->loadModel($_GET['sId']);
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

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Student the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Student::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function loadCourseModel($id)
    {
        $model = Course::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function renderCourseTypeName($data, $row)
    {
        if (empty($this->_registration) && isset($this->_course_type_id)) {
            $this->_registration = $data->registrations(array(
                'condition' => 'course_type_id=:course_type_id',
                'params' => array(
                    ':course_type_id' => $this->_course_type_id,
                ),
            ));
        }
        if (!empty($this->_registration)) {
            return CourseType::model()->findByPk($this->_registration[0]->course_type_id)->name;
        } else {
            return 'No course chosen!';
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

    public function renderViewLink($data, $raw)
    {
        return '<a href="' . $this->createUrl('student/view', array('id' => $data->id)) . '"><span style="color:#222;font-size:21px;" class="glyphicon glyphicon-user"></span></a>';
    }

    public function renderUpdateLink($data, $raw)
    {
        return '<a href="' . $this->createUrl('student/update', array('id' => $data->id)) . '"><span style="color:#222;font-size:21px;" class="glyphicon glyphicon-pencil"></span></a>';
    }

    public function loadCourseTypeModel($course_type_id)
    {
        $courseType = CourseType::model()->findByPk($course_type_id);
        if ($courseType == null) {
            throw new CHttpException(404);
        } else {
            return $courseType;
        }
    }

    public function renderInfoCompletenessStatus($data, $row)
    {
        if ($data->getStudent()->checkInfoCompleteness()) {
            echo "<span class='label label-success'>مكتملة</span>";
        } else {
            echo "<span class='label label-danger'>غير مكتملة</span>";
        }
    }

    public function renderInfoCompletenessStatusForStudentListing($data, $row)
    {
        if ($data->checkInfoCompleteness()) {
            echo "<span class='label label-success'>مكتملة</span>";
        } else {
            echo "<span class='label label-danger'>غير مكتملة</span>";
        }
    }

    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'student-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
