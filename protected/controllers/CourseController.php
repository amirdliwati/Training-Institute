<?php

include "BaseController.php";

class CourseController extends BaseController
{
    /**
     * This is a testing comment for upload
     *
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';
    public $main_section_title = "";

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

    public function actionAttendanceList()
    {
        if (!isset($_GET['session_id'])) {
            throw new CHttpException(400);
        }
        $session_id = $_GET['session_id'];
        $session = Session::model()->findByPk($session_id);
        if ($session == null) {
            throw new CHttpException(404);
        }
        $this->pageTitle = "عرض حضور الطلاب";
        $this->layout = "//layouts/column2";
        $this->render('attendance_list', array(
            'session' => $session,
        ));
    }

    public function actionDeleteStudent()
    {
        $student = $this->loadStudentModel($_POST['sId']);
        $course = $this->loadModel($_POST['cId']);
        $command = Yii::app()->db->createCommand();
        $command->delete('tbl_payment', 'student_id=:student_id AND course_id=:course_id', array(
            ':student_id' => $student->id,
            ':course_id' => $course->id,
        ));
        $courseSessions = $course->sessions;
        $sessions_id = array();
        foreach ($courseSessions as $session) {
            $sessions_id[] = $session->id;
        }
        $command->reset();
        if (!empty($sessions_id)) {
            $command->delete('tbl_attendance', 'student_id=:student_id AND session_id in (' . implode(',', $sessions_id) . ')', array(
                ':student_id' => $student->id,
            ));
            $command->reset();
        }
        $command->delete('tbl_student_course_assignment', 'student_id=:student_id AND course_id=:course_id', array(
            ':student_id' => $student->id,
            ':course_id' => $course->id,
        ));
        echo CJSON::encode(array(
            'status' => true,
            'message' => 'تمت عملية حذف الطالب بنجاح',
        ));
    }

    public function accessRules()
    {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view', 'alterCourseStatus'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('*'),
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
        $this->layout = "//layouts/column2";
        $course = $this->loadModel($id);
        $this->pageTitle = "لوحة التحكم الخاصة بدورة " . " " . $course->courseType->name;
        $studentDataProvider = new CActiveDataProvider('Student', array(
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));
        // Get the students in the course
        $courseStudents = $course->students;
        foreach ($courseStudents as $student) {
            $student->course_id = $course->id;
        }
        // set Data Provider for course's students
        $studentDataProvider->setData($courseStudents);
        // Render Course (view) page
        $this->render('view', array(
            'model' => $course,
            'students' => $courseStudents,
            'studentDataProvider' => $studentDataProvider,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $this->pageTitle = "إنشاء دورة جديدة";
        $this->layout = "//layouts/column2";
        $courseType = CourseType::model()->findAll();

        if (empty($courseType)) {
            $this->redirect(array('courseType/create'));
        }

        $model = new Course('create');

        $instructorModel = new Instructor;
        if (isset($_GET['Instructor'])) {
            $instructorModel->attributes = $_GET['Instructor'];
        }
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        $model->status = Course::STATUS_NOT_YET_STARTED;
        $model->cost = 0;
        if (isset($_POST['Course'])) {
            $model->attributes = $_POST['Course'];
            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('create', array(
            'model' => $model,
            'instructorModel' => $instructorModel,
        ));
    }

    public function actionDeleteSession($id)
    {
        $session_id = $id;
        $session = Session::model()->findByPk($session_id);
        $sessionNo = $session->num;
        foreach ($session->attendances as $attendance) {
            $attendance->delete();
        }
        if ($session->delete()) {
            echo CJSON::encode(array(
                'status' => true,
                'message' => "تم حذف الجلسة رقم: " . $sessionNo . " من نظام الدورات",
            ));
        } else {
            echo CJSON::encode(array(
                'status' => false,
                'message' => "لم يتمكن النظام من حذف الجلسة",
            ));
        }

    }

    public function actionShowStudentContract($student_id)
    {
        $this->layout = "//layouts/blank";
        $this->pageTitle = "بيان الاشتراك";
        $first_payment = 0;
        if (!empty($_GET['course_id'])) {
            $course_id = intval($_GET['course_id']);
            $course = $this->loadModel($course_id);
            $payments = Payment::model()->findAll('course_id=:course_id AND student_id=:student_id', array(
                ':course_id' => $course_id,
                ':student_id' => $student_id,
            ));
            $cost = $course->getCostText();

            $first_payment = empty($payments) ? null : $payments[0];
            if (!is_null($first_payment)) {
                $first_payment = $first_payment->amount;
            } else {
                $first_payment = 0;
            }

            $courseName = $course->courseType->name;
        } else if (!empty($_GET['course_type_id']) && !empty($_GET['cost']) && !empty($_GET['paid'])) {
            $courseName = CourseType::model()->findByPk(intval($_GET['course_type_id']))->name;
            $cost = $_GET['cost'];
            $first_payment = $_GET['paid'];
        } else {
            throw new CHttpException(400, 'طلب خاطئ');
        }
        $student_id = intval($_GET['student_id']);
        $student = $this->loadStudentModel($student_id);
        $telephoneNo = "لايوجد";
        $mobileNo = "لايوجد";
        $tels = $student->telNo;
        $mobs = $student->mobileNo;
        if (!empty($tels)) {
            $telephoneNo = $tels[0]->number;
        }
        if (!empty($mobs)) {
            $mobileNo = $mobs[0]->number;
        }

        $this->render('student_contract', array(
            'student' => $student,
            'courseName' => $courseName,
            'cost' => $cost,
            'telephoneNo' => $telephoneNo,
            'mobileNo' => $mobileNo,
            'first_payment' => $first_payment,
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
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Course'])) {
            $model->attributes = $_POST['Course'];
            if ($model->save()) {
                echo CJSON::encode(array(
                    'success' => true,
                    'message' => 'The Course Has Been updated!',
                ));
            } else {
                echo CJSON::encode(array(
                    'success' => false,
                    'message' => 'There was an error!',
                ));
            }
        }
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {

        if(isset($_POST['Course'])){
            $model = $this->loadModel(intval($_POST['Course']['id']));

            Yii::app()->db->createCommand()->delete('tbl_payment','course_id=:course_id',array(
                ':course_id'=>$model->id,
            ));
            Yii::app()->db->createCommand()->delete('tbl_student_course_assignment','course_id=:course_id',array(
                ':course_id'=>$model->id,
            ));
            Yii::app()->db->createCommand()->delete('tbl_session','course_id=:course_id',array(
                ':course_id'=>$model->id,
            ));
            Yii::app()->db->createCommand()->delete('tbl_damascus_list_entry','course_id=:course_id',array(
                ':course_id'=>$model->id,
            ));

            if($model->delete()){
                $this->redirect(array('course/admin'));
            }
            Yii::app()->end();
        }
        $model = $this->loadModel(intval($id));
        $this->pageTitle="حذف دورة"." ".$model->courseType->name;


        $this->render('delete', array(
            'model' => $model,
        ));
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('Course');
        $this->pageTitle = "إدارة الدورات";
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Course('search');
        $this->pageTitle = "إدارة الدورات";
        $this->layout = "//layouts/column2";
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Course']))
            $model->attributes = $_GET['Course'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }


    /*
     *
     * The AJAX methods used by the Course Controller
     *
     */

    public function actionSetInstructor($id)
    {
        if (!isset($_POST['ajax'])) {
            $instructor = Instructor::model()->findByPk($id);
            echo CJSON::encode(array('instructor_id' => $instructor->id, 'instructor_name' => $instructor->first_name . " " . $instructor->last_name));
            Yii::app()->end();
        }
    }

    public function actionRegisterForCourse()
    {
        if (isset($_POST['course_id'], $_POST['student_id']) && strlen($_POST['student_id']) > 0) {
            $course_id = $_POST['course_id'];
            $course = $this->loadModel($course_id);
            $student_id = explode(',', $_POST['student_id']);
            foreach ($student_id as $id) {
                $course->registerForCourse($id);
            }
            Yii::app()->end();
        } else {
            throw new CHttpException(400, "حدد الطلاب و الدورة بشكل صحيح !");
        }
    }

    public function actionViewStudentContactInfo($cId){
        $this->layout = "//layouts/blank";
        $this->pageTitle = "بيانات الاتصال";

        $courseModel = $this->loadModel(intval($cId));
        $students = $courseModel->students;

        $this->render('contact_info_page',array(
            'model'=>$courseModel,
            'students'=>$students,
        ));
    }

    public function actionCallUpdate()
    {
        if (Yii::app()->request->isAjaxRequest) {
            if (!isset($_GET['id'])) {
                throw new CHttpException(400);
            }
            $course_id = intval($_GET['id']);

            $course = $this->loadModel($course_id);
            echo $this->renderPartial('_form', array(
                'model' => $course,
            ), false, true);
        }
    }

    public function actionCourseUpdate()
    {
        if (!isset($_GET['id'])) {
            throw new CHttpException(400);
        }
        $course_id = intval($_GET['id']);

        try {
            $course = $this->loadModel($course_id);
            $payments = $course->payments;
            $currentProfits = 0;
            foreach ($payments as $payment) {
                $currentProfits = $currentProfits + $payment->amount;
            }
            $courseArray = array(
                'id' => $course->id,
                'name' => $course->getCourseNameText(),
                'description' => $course->courseType->getDescriptionText(),
                'status' => $course->getStatusText(),
                'cost' => $course->getCostText(),
                'startDate' => $course->start_date,
                'endDate' => $course->end_date,
                'note' => $course->getNoteText(),
                'estimatedProfits' => $course->cost * count($course->students),
                'currentProfits' => $currentProfits,
                'success' => true,
            );
            echo CJSON::encode($courseArray);
        } catch (CHttpException $e) {
            echo CJSON::encode(array(
                'success' => false,
            ));
        }

    }

    /*
     * Change the course Status
     */
    public function actionAlterCourseStatus()
    {
        $cId = $_POST['cId'];
        $status = $_POST['status'];
        try {
            $course = $this->loadModel($cId);
        } catch (Exception $e) {
            echo "There is a problem Loading the course";
        }
        $course->status = $status;
        if ($course->save()) {
            echo "The status has been changed successfully";
        } else {
            echo "The Status couldn't be changed";
        }
    }

    public function actionCourses($course_type_id)
    {
        $courseType = CourseType::model()->findByPk($course_type_id);
        if ($courseType == null) {
            throw new CHttpException(404, 'العنصر غير موجود');
        }
        $courses = $courseType->courses(array(
            'condition' => 'status in (:not_yet_started,:in_progress)',
            'params' => array(
                ':not_yet_started' => Course::STATUS_NOT_YET_STARTED,
                ':in_progress' => Course::STATUS_IN_PROGRESS,
            ),
            'order' => 'start_date DESC',
        ));

        echo $this->renderPartial('partials/available_courses', array(
            'courses' => $courses,
        ), false, true);
    }

    public function actionGetCourseDropList($course_type_id)
    {
        $courseType = CourseType::model()->findByPk($course_type_id);
        if ($courseType == null) {
            throw new CHttpException(404, 'العنصر غير موجود');
        }
        $courses = $courseType->courses(array(
            'with' => 'students',
            'condition' => 'status in (:not_yet_started,:in_progress)',
            'params' => array(
                ':not_yet_started' => Course::STATUS_NOT_YET_STARTED,
                ':in_progress' => Course::STATUS_IN_PROGRESS,
            ),
        ));

        $this->renderPartial('partials/courses_drop_list', array(
            'courses' => $courses,
        ));
    }

    public function actionAddCourseSession()
    {
        if (isset($_POST['Session'])) {
            $courseSession = new Session;
            header('Content-Type: application/json');
            $courseSession->attributes = $_POST['Session'];
            $courseSession->num = Session::model()->getLastSessionNo($_POST['Session']['course_id']) + 1;
            if ($courseSession->save()) {
                $session_id = $courseSession->id;
                $course_id = $courseSession->course_id;
                $students = Course::model()->findByPk($course_id)->students;
                foreach ($students as $student) {
                    $attendance = new Attendance;
                    $attendance->attending = Attendance::STATUS_ABSENT;
                    $attendance->student_id = $student->id;
                    $attendance->session_id = $session_id;
                    $attendance->save();
                }
                echo CJSON::encode(array(
                    'success' => true,
                    'message' => 'تم اضافة جلسة درسية جديدة',
                ));
            } else {
                echo CJSON::encode(array(
                    'success' => false,
                    'message' => 'حصل خطأ',
                ));
            }
        }
    }

    public function actionAddAttendance()
    {

        if (!isset($_GET['session_id'])) {
            throw new CHttpException(400);
        }
        $this->layout = "//layouts/column1";
        $session_id = intval($_GET['session_id']);
        $session = Session::model()->findByPk($session_id);
        $attendanceArray = array();
        foreach ($session->attendances as $attendance) {
            $attendanceArray[$attendance->student_id] = $attendance;
        }
        if (isset($_POST['course_id'])) {
            $session->clearAttendance();
            foreach ($_POST['student_id'] as $student_id) {
                $attendance = Attendance::model()->find('student_id=:student_id AND session_id=:session_id', array(
                    ':session_id' => $session_id,
                    ':student_id' => $student_id,
                ));
                $attendance->attending = Attendance::STATUS_PRESENT;
                $attendance->save();
            }
            $this->redirect(array('view', 'id' => $session->course_id));
        }
        $this->render('attendance_form', array(
            'attendanceArray' => $attendanceArray,
            'session' => $session,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Course the loaded model
     * @throws CHttpException
     */

    public function actionGetCourseSessionOptions()
    {
        if (!isset($_GET['id'])) {
            throw new CHttpException(400);
        }
        $session_id = intval($_GET['id']);
        echo $this->renderPartial('partials/course-session-options', array(
            'session_id' => $session_id,
        ), false, true);
        Yii::app()->end();
    }

    public function actionGetCourseStudentOptions()
    {
        if (!isset($_GET['sId']) || !isset($_GET['cId'])) {
            throw new CHttpException(400);
        }
        $student_id = intval($_GET['sId']);
        $course_id = intval($_GET['cId']);
        if (isset($_GET['ref'])) {
            $ref = $_GET['ref'];
        }
        $model = Course::model()->findByPk($course_id);
        $model->student_id = $student_id;
        echo $this->renderPartial('partials/course-student-options', array(
            'student_id' => $student_id,
            'course_id' => $course_id,
            'ref' => $ref,
            'model' => $model,
        ), false, true);
        Yii::app()->end();
    }


    public function actionGetStudentTransferForm($sId, $cId)
    {
        if (Yii::app()->request->isAjaxRequest) {
            $student_id = intval($sId);
            $course_id = intval($cId);
            echo $this->renderPartial('partials/damascus-list-transfer-form', array(
                    'student_id' => $student_id,
                    'course_id' => $course_id,
                ), false, true
            );
        } else {
            throw new CHttpException(403);
        };

    }

    public function actionTransfer()
    {
        if (Yii::app()->request->isAjaxRequest) {

            $student_id = intval($_POST['student_id']);
            $course_id = intval($_POST['course_id']);
            $d_l_no = intval($_POST['damascus_list_no']);

            $damascusList = DamascusList::model()->find('num=:num', array(
                'num' => $d_l_no,
            ));

            $student = Student::model()->findByPk($student_id);

            if ($damascusList != null) {
                $model = new DamascusListEntry;
                $model->course_id = $course_id;
                $model->student_id = $student_id;
                $model->damascus_list_id = $damascusList->id;
                $model->damascus_list_no = $damascusList->num;
                if ($model->save()) {
                    echo CJSON::encode(array(
                        'status' => true,
                        'message' => 'تم ترحيل الطالب ' . $student->getName(),
                    ));
                } else {
                    echo CJSON::encode(array(
                        'status' => false,
                        'message' => 'حصل خطأ في ترحيل الطالب ' . $student->getName(),
                    ));
                }
            } else {
                echo CJSON::encode(array(
                    'status' => false,
                    'message' => 'لايوجد لائحة بهذا الرقم',
                ));
            }
        } else {
            throw new CHttpException(403);
        }
    }

    public function actionShowStudentContact($course_id, $student_ids)
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

    public function actionTransferStudents()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $student_id = $_POST['student_id'];
            $course_id = intval($_POST['course_id']);
            $d_l_no = intval($_POST['damascus_list_no']);
            $damascusList = DamascusList::model()->find('num=:num', array(
                'num' => $d_l_no,
            ));
            if ($damascusList != null) {
                $ids = explode(',', $student_id);
                $counter = 0;
                $student_array_size = count($ids);
                foreach ($ids as $id) {
                    $model = new DamascusListEntry;
                    $model->course_id = $course_id;
                    $model->student_id = $id;
                    $model->damascus_list_id = $damascusList->id;
                    $model->damascus_list_no = $damascusList->num;
                    if ($model->save()) {
                        $counter += 1;
                    }
                }
                if ($student_array_size == $counter) {
                    echo CJSON::encode(array(
                        'status' => true,
                        'message' => 'تم ترحيل الطلاب بنجاح',
                    ));
                } else {
                    echo CJSON::encode(array(
                        'status' => false,
                        'message' => 'حصل خطأ في ترحيل بعض او كل الطلاب',
                    ));
                }
            } else {
                echo CJSON::encode(array(
                    'status' => false,
                    'message' => 'لايوجد لائحة بهذا الرقم',
                ));
            }


        } else {
            throw new CHttpException(403);
        }
    }

    public function actionCallSessionUpdateForm()
    {
        if (!isset($_GET['id'])) {
            throw new CHttpException(400);
        }
        $session_id = intval($_GET['id']);
        $session = Session::model()->findByPk($session_id);
        if (!isset($session)) {
            throw new CHttpException(404);
        }
        echo $this->renderPartial('partials/create-session-form', array(
            'model' => $session,
        ), false, true);
        Yii::app()->end();
    }

    public function actionUpdateCourseSession()
    {
        if (!isset($_GET['id'])) {
            throw new CHttpException(400);
        }
        $session_id = intval($_GET['id']);
        $session = Session::model()->findByPk($session_id);
        if (!isset($session)) {
            throw new CHttpException(404);
        }
        if (isset($_POST['Session'])) {
            $session->attributes = $_POST['Session'];
            if ($session->save()) {
                echo CJSON::encode(array(
                    'success' => true,
                    'message' => " تم تعديل الجلسة التدريبية رقم:" . $session->num,
                ));
            } else {
                echo CJSON::encode(array(
                    'success' => false,
                    'message' => "حصل خطأ",
                ));
            }
        } else {
            throw new CHttpException(400);
        }
        Yii::app()->end();
    }

    public function renderInfoCompletenessStatus($data, $row)
    {
        if ($data->checkInfoCompleteness()) {
            echo "<span class='label label-success'>بيانات الطالب مكتملة</span>";
        } else {
            echo "<span class='label label-danger'>بيانات الطالب غير مكتملة</span>";
        }
    }

    public function actionEditStudentAssessment($sId, $cId)
    {
        $course = $this->loadModel($cId);
        $student = $this->loadStudentModel($sId);
        if (isset($_GET['ref'])) {
            $ref = $_GET['ref'];
        }
        $student->course_id = $course->id;
        echo $this->renderPartial('partials/edit_student_assessment_form', array(
            'student' => $student,
            'course' => $course,
            'ref' => $ref,
        ), false, true);
        Yii::app()->end();
    }

    public function actionPostStudentAssessment()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $student = $this->loadStudentModel($_POST['student_id']);
            $course = $this->loadModel($_POST['course_id']);
            $mark = intval($_POST['mark']);
            $grade = $_POST['assessment'];
            if ($mark < 0 || $mark > 100 || !is_int($mark)) {
                echo CJSON::encode(array(
                    'status' => false,
                    'message' => 'تأكد من صحة المدخلات: العلامة يجب ان تكون رقما بين ال 1 و ال 100',
                ));
                Yii::app()->end();
            }
            $command = Yii::app()->db->createCommand();
            $rowNo = $command->update('tbl_student_course_assignment', array('grade' => $grade, 'mark' => $mark),
                'student_id=:student_id AND course_id=:course_id'
                , array(
                    ':student_id' => $student->id,
                    ':course_id' => $course->id,
                ));
            if ($rowNo == 1) {
                echo CJSON::encode(array(
                    'status' => true,
                    'ref' => $_POST['ref'],
                    'message' => 'تم ادراج تقييم للطالب',
                ));
            } else {
                echo CJSON::encode(array(
                    'status' => false,
                    'message' => 'الطالب  لديه مسبقا نفس التقييم',
                ));
            }
            Yii::app()->end();
        } else {
            throw new CHttpException(403);
        }
    }

    public function renderViewLink($data, $raw)
    {
        return '<a href="' . $this->createUrl('course/view', array('id' => $data->id)) . '"><span style="color:#222;font-size:21px;" class="glyphicon glyphicon-list-alt"></span></a>';
    }

    // Load Student and Course models
    public function loadModel($id)
    {
        $model = Course::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function loadStudentModel($id)
    {
        $model = Student::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
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

    /**
     * Performs the AJAX validation.
     * @param Course $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'course-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
