<?php

/**
 * This is the model class for table "tbl_student_course_type_assignment".
 *
 * The followings are the available columns in table 'tbl_student_course_type_assignment':
 * @property integer $student_id
 * @property integer $course_type_id
 * @property integer $status
 * @property integer $initial_payment
 * @property integer $initial_payment_num
 * @property string $note
 * @property integer $preferred_time
 * @property string $registration_date
 */
class Registration extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'tbl_student_course_type_assignment';
    }

    public $student = null;
    public $courseType = null;

    const REGISTRATION_METHOD_DIRECT = 0;
    const REGISTRATION_METHOD_REMOTE = 1;

    const TIME_SLOT_1 = "09:00 ----> 10:30";
    const TIME_SLOT_2 = "10:30 ----> 12:00";
    const TIME_SLOT_3 = "12:00 ----> 01:30";
    const TIME_SLOT_4 = "01:30 ----> 03:00";
    const TIME_SLOT_5 = "03:00 ----> 04:30";
    const TIME_SLOT_6 = "04:30 ----> 06:00";
    const TIME_SLOT_7 = "06:00 ----> 07:30";
    const TIME_SLOT_8 = "07:30 ----> 09:00";

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('student_id, course_type_id, status', 'required', 'message' => 'الحقل " {attribute} " لايمكن ان يكون فارغا'),
            array('student_id, course_type_id, status, initial_payment, initial_payment_num', 'numerical', 'integerOnly' => true),
            array('preferred_time,note,initial_payment,initial_payment_num,registration_date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('student_id, course_type_id, status, start_date, end_date, initial_payment', 'safe', 'on' => 'search'),
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
            'student' => array(self::BELONGS_TO, 'Student', 'student_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'student_id' => 'معرف الطالب',
            'course_type_id' => 'نوع الدورة',
            'status' => 'حالة التسجيل',
            'initial_payment' => 'دفعة اولى (ل.س)',
            'initial_payment_num' => 'رقم الفاتورة',
            'note' => 'ملاحظات',
            'preferred_time' => 'الوقت المرغوب',
            'registration_date'=>'تاريخ التسجيل',
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

        $criteria->compare('student_id', $this->student_id);
        $criteria->compare('course_type_id', $this->course_type_id);
        $criteria->compare('status', $this->status);
        $criteria->compare('initial_payment', $this->initial_payment);

        $criteria->order = 'registration_date DESC';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination'=>array(
                'pageSize'=>40,
            ),
        ));
    }

    public function getAvailableTimeSlots()
    {
        $options = array(
            self::TIME_SLOT_1 => "09:00 ----> 10:30",
            self::TIME_SLOT_2 => "10:30 ----> 12:00",
            self::TIME_SLOT_3 => "12:00 ----> 01:30",
            self::TIME_SLOT_4 => "01:30 ----> 03:00",
            self::TIME_SLOT_5 => "03:00 ----> 04:30",
            self::TIME_SLOT_6 => "04:30 ----> 06:00",
            self::TIME_SLOT_7 => "06:00 ----> 07:30",
            self::TIME_SLOT_8 => "07:30 ----> 09:00",
        );
        return $options;
    }
    public function getTimeSlot(){
        $options = $this->getAvailableTimeSlots();
        return $options[$this->preferred_time];
    }

    public function getStudent(){
        if($this->student==null){
            $this->student = Student::model()->findByPk($this->student_id);
        }
        return $this->student;
    }
    public function getCourseType(){
        if($this->courseType==null){
            $this->courseType = CourseType::model()->findByPk($this->course_type_id);
        }
        return $this->courseType;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Registration the static model class
     */


    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
