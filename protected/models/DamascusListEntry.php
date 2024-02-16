<?php

/**
 * This is the model class for table "tbl_damascus_list_entry".
 *
 * The followings are the available columns in table 'tbl_damascus_list_entry':
 * @property integer $id
 * @property integer $damascus_list_id
 * @property integer $course_id
 * @property integer $student_id
 * @property date $start_date
 * @property date $end_date
 *
 * The followings are the available model relations:
 * @property DamascusList $damascusList
 * @property Course $course
 * @property Student $student
 */
class DamascusListEntry extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'tbl_damascus_list_entry';
    }

    public $course = null;
    public $student = null;

    public $damascus_list_no;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('damascus_list_id, course_id, student_id,damascus_list_no', 'required'),
            array('start_date,end_date', 'required', 'on' => 'edit-dates'),
            array('damascus_list_id, course_id, student_id', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, damascus_list_id, course_id, student_id,damascus_list_no', 'safe', 'on' => 'search'),
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
            'damascusList' => array(self::BELONGS_TO, 'DamascusList', 'damascus_list_id'),
            'course' => array(self::BELONGS_TO, 'Course', 'course_id'),
            'student' => array(self::BELONGS_TO, 'Student', 'student_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'معرف',
            'damascus_list_id' => 'معرف لائحة دمشق',
            'course_id' => 'معرف الكورس',
            'student_id' => 'معرف الطالب',
            'damascus_list_no' => 'رقم اللائحة',
            'start_date' => 'تاريخ بداية الدورة',
            'end_date' => 'تاريخ نهاية الدورة',
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
        $criteria->compare('damascus_list_id', $this->damascus_list_id);
        $criteria->compare('course_id', $this->course_id);
        $criteria->compare('student_id', $this->student_id);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function loadCourse()
    {
        if ($this->course == null) {
            $this->course = Course::model()->findByPk($this->course_id);
        }
    }

    public function getStudent()
    {
        $this->loadStudent();
        return $this->student;
    }

    public function getCourse()
    {
        $this->loadCourse();
        return $this->course;
    }

    public function getAssessmentValue()
    {
        // Get the discount of the student ...
        $command = Yii::app()->db->createCommand();
        $assignments = $command->select('*')
            ->from('tbl_student_course_assignment')
            ->where('student_id = :student_id AND course_id = :course_id', array(
                ':student_id' => $this->student_id,
                ':course_id' => $this->course_id,
            ))
            ->queryAll();

        if(empty($assignments)){
            return -1;
        }else{
            return $assignments[0]['grade'];
        }
    }

    public function getStartDate()
    {
        if (is_null($this->start_date)) {
            return $this->damascusList->start_date;
        } else {
            return $this->start_date;
        }
    }

    public
    function getEndDate()
    {
        if (is_null($this->end_date)) {
            return $this->damascusList->end_date;
        } else {
            return $this->end_date;
        }
    }

    public
    function loadStudent()
    {
        if ($this->student == null) {
            $this->student = Student::model()->findByPk($this->student_id);
        }
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return DamascusListEntry the static model class
     */
    public
    static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
