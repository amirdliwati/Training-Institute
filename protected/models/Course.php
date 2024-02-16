<?php

/**
 * This is the model class for table "tbl_course".
 *
 * The followings are the available columns in table 'tbl_course':
 * @property integer $id
 * @property integer $course_type_id
 * @property integer $cost
 * @property string $start_date
 * @property string $end_date
 * @property string $note
 * @property integer $status
 * @property integer $instructor_id
 *
 * The followings are the available model relations:
 * @property CourseType $courseType
 * @property Instructor $instructor
 * @property Session[] $sessions
 * @property Student[] $students
 */
class Course extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */


    //Attributes

    public $instructor_id;
    public $student_id;

    public function tableName()
    {
        return 'tbl_course';
    }

    const STATUS_NOT_YET_STARTED = 0;
    const STATUS_IN_PROGRESS = 1;
    const STATUS_FINISHED = 2;

    const STUDENT_COURSE_FINANCIAL_STATUS_OBLIGED = 0;
    const STUDENT_COURSE_FINANCIAL_STATUS_DONE = 1;

    const STUDENT_GRADE_GOOD = 1;
    const STUDENT_GRADE_VERY_GOOD = 2;
    const STUDENT_GRADE_EXCELLENT = 3;
    const STUDENT_GRADE_NOT_SPECIFIED = 0;

    public $statusArray = array(
        self::STATUS_NOT_YET_STARTED => "لم تبدأ بعد",
        self::STATUS_IN_PROGRESS => "فعالة",
        self::STATUS_FINISHED => "منتهية",
    );

    public $gradesArray = array(
        self::STUDENT_GRADE_GOOD => "جيد",
        self::STUDENT_GRADE_VERY_GOOD => "جيد جدا",
        self::STUDENT_GRADE_EXCELLENT => "ممتاز",
        self::STUDENT_GRADE_NOT_SPECIFIED => "لايوجد",
    );

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('course_type_id,instructor_id,cost, status', 'required', 'message' => 'الحقل " {attribute} " لايمكن ان يكون فارغا'),
            array('status', 'in', 'range' => array(0, 1, 2)),
            array('course_type_id, cost, status', 'numerical', 'integerOnly' => true),
            array('start_date, end_date, note', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, course_type_id, cost, start_date, end_date, note, status', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'courseType' => array(self::BELONGS_TO, 'CourseType', 'course_type_id'),
            'instructor' => array(self::BELONGS_TO, 'Instructor', 'instructor_id'),
            'sessions' => array(self::HAS_MANY, 'Session', 'course_id'),
            'students' => array(self::MANY_MANY, 'Student', 'tbl_student_course_assignment(course_id, student_id)'),
            'payments' => array(self::HAS_MANY, 'Payment', 'course_id'),
            'student_no' => array(self::STAT, 'Student', 'tbl_student_course_assignment(course_id, student_id)'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'معرف الدورة',
            'course_type_id' => 'معرف نوع الدورة',
            'cost' => 'قسط الدورة',
            'start_date' => 'تاريخ بدايةالدورة',
            'end_date' => 'تاريخ نهاية الدورة',
            'note' => 'ملاحظات حول الدورة',
            'status' => 'حالة الدورة',
            'instructor_id' => 'استاذ الدورة',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('course_type_id', $this->course_type_id);
        $criteria->compare('cost', $this->cost);
        $criteria->compare('status', $this->status);
        $criteria->compare('start_date', $this->start_date, true);
        $criteria->compare('end_date', $this->end_date, true);
        $criteria->compare('note', $this->note, true);

        $criteria->order = "start_date desc";
        return new CActiveDataProvider('Course', array(
            'criteria' => $criteria,
        ));
    }
    // ============================================================
    // Custom methods : Borhan Otour
    // ============================================================


    public function isCostEditable()
    {
        if (count($this->payments) == 0) {
            return true;
        } else {
            return false;
        }
    }

    /*
    *
    *	This function register a student in a course removing him/her from the waiting list
    *	and add their initial payment as the first payment to the tbl_payment table
    *
    */
    public function registerForCourse($studentId)
    {
        $command = Yii::app()->db->createCommand();
        try {
            $rows = $command->insert('tbl_student_course_assignment', array(
                'student_id' => $studentId,
                'course_id' => $this->id,
                'grade' => Course::STUDENT_GRADE_NOT_SPECIFIED,
                'mark' => 0,
            ));
        } catch (CException $e) {
            throw new CHttpException(400, 'الطالب مسجل مسبقا في الدورة');
            return;
        }
        $command->reset();
        if ($rows == 1) {

            $courseSessions = $this->sessions;
            foreach ($courseSessions as $session) {
                $attendance = new Attendance;
                $attendance->session_id = $session->id;
                $attendance->student_id = $studentId;
                $attendance->attending = Attendance::STATUS_ABSENT;
                $attendance->save();
            }
            // There is a Chance that the student is in the waiting List .
            // So we Must delete if before Adding It to an active course
            $registration = $command->select('*')
                ->from('tbl_student_course_type_assignment')
                ->where('student_id=:student_id AND course_type_id =:course_type_id', array(
                    ':student_id' => $studentId,
                    ':course_type_id' => $this->courseType->id,
                ))->queryRow();
            $command->reset();
            if (!empty($registration)) {

                $initial_payment = intval($registration['initial_payment']);
                $initial_payment_num = intval($registration['initial_payment_num']);

                if ($initial_payment > 0 && $initial_payment_num > 0) {
                    $payment = new Payment;
                    $payment->student_id = $studentId;
                    $payment->course_id = $this->id;
                    $payment->num = $initial_payment_num;
                    $payment->amount = $initial_payment;
                    $payment->date = $registration['registration_date'];
                    $payment->note = Payment::FROM_INITIAL_PAYMENT;

                    if ($payment->save()) {
                        //echo "Saved!\n";
                    } else {
                        var_dump($payment->errors);
                    }
                    $command->reset();
                }

                $command->delete('tbl_student_course_type_assignment',
                    'student_id=:student_id AND course_type_id =:course_type_id',
                    array(
                        ':student_id' => $studentId,
                        ':course_type_id' => $this->courseType->id,
                    ));
            }


        }
        return $rows == 1;
    }

    public function getStudentCourseFinancialStatus()
    {
        $courseCost = $this->cost;
        $payments = Payment::model()->findAll('student_id=:student_id AND course_id=:course_id', array(
            ':student_id' => $this->student_id,
            ':course_id' => $this->id,
        ));
        $paymentsSum = 0;
        foreach ($payments as $payment) {
            $paymentsSum += $payment->amount;
        }
        $command = Yii::app()->db->createCommand();
        $assignments = $command->select('*')
            ->from('tbl_student_course_assignment')
            ->where('student_id = :student_id AND course_id = :course_id', array(
                ':student_id' => $this->student_id,
                ':course_id' => $this->id,
            ))
            ->queryAll();
        $assignment = $assignments[0];
        $discount = $assignment['discount'];
        $paymentsSum += $discount;
        if ($paymentsSum < $courseCost) {
            return self::STUDENT_COURSE_FINANCIAL_STATUS_OBLIGED;
        } else if ($paymentsSum >= $courseCost) {
            return self::STUDENT_COURSE_FINANCIAL_STATUS_DONE;
        }
    }

    public function getStudent()
    {
        $student = Student::model()->findByPk($this->student_id);
        $student->course_id = $this->id;
        return $student;
    }

    public function getAvailableCourseStatus()
    {
        return $this->statusArray;
    }

    public function getAvailableCourseGrades()
    {
        return $this->gradesArray;
    }

    public function getStatusText()
    {
        return $this->statusArray[$this->status];
    }

    public function getCostText()
    {
        return isset($this->cost) ? $this->cost : 0;
    }

    public function getCourseNameText()
    {
        return $this->courseType->name;
    }

    public function getNoteText()
    {
        return isset($this->note) && strlen($this->note) > 0 ? $this->note : "لايوجد ملاحظات متعلقة بهذه الدورة";
    }

    public function isTransfered()
    {
        $entry = DamascusListEntry::model()->find('student_id=:student_id AND course_id=:course_id', array(
            ':student_id' => $this->student_id,
            ':course_id' => $this->id,
        ));
        if ($entry == null) {
            return false;
        } else {
            return true;
        }
    }

    public function getStudentTransferStatus()
    {
        if ($this->isTransfered()) {
            return Student::STATUS_STUDENT_IS_TRANSFERED;
        } else {
            return Student::STATUS_STUDENT_IS_NOT_TRANSFERED;
        }
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Course the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
