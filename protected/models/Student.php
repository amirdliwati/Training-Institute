<?php

/**
 * This is the model class for table "tbl_student".
 *
 * The followings are the available columns in table 'tbl_student':
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $father_name
 * @property string $mother_name
 * @property string $nationality
 * @property string $qualification
 * @property string $residency
 * @property string $occupation
 * @property string $national_no
 * @property string $img_src
 * @property string $how_to_know_us
 * @property string $DOB
 */
class Student extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'tbl_student';
    }

    const STATUS_WAITING = 1;
    const STATUS_IGNORED = 2;
    const STATUS_RETREAT = 3;

    const STATUS_STUDENT_IS_TRANSFERED = 0;
    const STATUS_STUDENT_IS_NOT_TRANSFERED = 1;
    /**
     * @return array validation rules for model attributes.
     */

    public $student_id_array;
    public $course_id;

    public $tel_num;
    public $mobile_num;

    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('first_name, last_name, father_name', 'required', 'message' => 'الحقل " {attribute} " لايمكن ان يكون فارغا'),
            array('first_name,last_name,father_name,mother_name,nationality,residency,qualification','required','on'=>'data-listing'),
            array('first_name, last_name, father_name, mother_name, nationality, qualification, residency, occupation, img_src, DOB', 'length', 'max' => 255),
            array('national_no', 'length', 'max' => 45),
            array('how_to_know_us', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, first_name, last_name, father_name, mother_name, nationality, qualification, residency, occupation, national_no, img_src, how_to_know_us, DOB', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'registrations' => array(self::HAS_MANY, 'Registration', 'student_id'),
            'mobileNo' => array(self::HAS_MANY, 'PhoneNumber', 'owner_id', 'condition' => 'type=:type', 'params' => array(':type' => PhoneNumber::MOBILE_NUMBER)),
            'telNo' => array(self::HAS_MANY, 'PhoneNumber', 'owner_id', 'condition' => 'type=:type', 'params' => array(':type' => PhoneNumber::HOME_NUMBER)),
            'courses' => array(self::MANY_MANY, 'Course', 'tbl_student_course_assignment(student_id,course_id)'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'first_name' => 'الأسم الأول',
            'last_name' => 'الأسم الأخير',
            'father_name' => 'أسم الأب',
            'mother_name' => 'أسم الأم',
            'nationality' => 'الجنسية',
            'qualification' => 'الشهادة العلمية',
            'residency' => 'الإقامة',
            'occupation' => 'المهنة',
            'national_no' => 'الرقم الوطني',
            'img_src' => 'مسار الصورة',
            'how_to_know_us' => 'كيف عرفتنا',
            'DOB' => 'محل و تاريخ الولادة',
            'tel_num' => 'الهاتف الأرضي',
            'mobile_num' => 'الهاتف الخليوي',
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

    public function waitingSearch()
    {

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->student_id_array);
        $criteria->compare('first_name', $this->first_name, true);
        $criteria->compare('last_name', $this->last_name, true);
        $criteria->compare('national_no', $this->national_no, true);

        return new CActiveDataProvider('Student', array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 30,
            ),
        ));
    }

    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('first_name', $this->first_name, true);
        $criteria->compare('last_name', $this->last_name, true);
        $criteria->compare('father_name', $this->father_name, true);
        $criteria->compare('mother_name', $this->mother_name, true);
        $criteria->compare('nationality', $this->nationality, true);
        $criteria->compare('qualification', $this->qualification, true);
        $criteria->compare('residency', $this->residency, true);
        $criteria->compare('occupation', $this->occupation, true);
        $criteria->compare('national_no', $this->national_no, true);
        $criteria->compare('img_src', $this->img_src, true);
        $criteria->compare('how_to_know_us', $this->how_to_know_us, true);
        $criteria->compare('DOB', $this->DOB, true);

        return new CActiveDataProvider('Student', array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));
    }

    public function getStudentCourseFinancialStatus()
    {
        $course = Course::model()->findByPk($this->getContextCourseId());
        $course->student_id = $this->id;
        return $course->getStudentCourseFinancialStatus();
    }

    public function getAssessmentValue()
    {
        $course_id = $this->getContextCourseId();
        if ($this->isAttendingCourse($course_id)) {
            // Get the discount of the student ...
            $command = Yii::app()->db->createCommand();
            $assignments = $command->select('*')
                ->from('tbl_student_course_assignment')
                ->where('student_id = :student_id AND course_id = :course_id', array(
                    ':student_id' => $this->id,
                    ':course_id' => $course_id,
                ))
                ->queryAll();
            $assignment = $assignments[0];
            return $assignment['grade'];
        } else {
            throw new CHttpException(500);
        }
    }

    public function getMarkValue()
    {
        $course_id = $this->getContextCourseId();
        if ($this->isAttendingCourse($course_id)) {
            // Get the discount of the student ...
            $command = Yii::app()->db->createCommand();
            $assignments = $command->select('*')
                ->from('tbl_student_course_assignment')
                ->where('student_id = :student_id AND course_id = :course_id', array(
                    ':student_id' => $this->id,
                    ':course_id' => $course_id,
                ))
                ->queryAll();
            $assignment = $assignments[0];
            return $assignment['mark'];
        } else {
            throw new CHttpException(500);
        }
    }

    public function getName()
    {
        return $this->first_name . " " . $this->father_name . " " . $this->last_name;
    }

    public function isAttendingCourse($course_id)
    {
        $command = Yii::app()->db->createCommand();
        $rows = $command->select('*')
            ->from('tbl_student_course_assignment')
            ->where('student_id=:student_id AND course_id =:course_id', array(
                ':student_id' => $this->id,
                ':course_id' => $course_id,
            ))->queryAll();
        return !empty($rows);
    }

    public function isTransfered(){
        $entry = DamascusListEntry::model()->find('student_id=:student_id AND course_id=:course_id',array(
            ':student_id'=>$this->id,
            ':course_id'=>$this->getContextCourseId(),
        ));
        if($entry==null){
            return false;
        }else{
            return true;
        }
    }

    public function isDeletable(){
        if(empty($this->courses) && empty($this->registrations) ){
            return true;
        }else{
            return false;
        }

    }
    public function getStudentTransferStatus(){
        if($this->isTransfered()){
            return Student::STATUS_STUDENT_IS_TRANSFERED;
        }else{
            return Student::STATUS_STUDENT_IS_NOT_TRANSFERED;
        }
    }

    public function checkInfoCompleteness(){
        $this->setScenario('data-listing');
        return $this->validate();
    }
    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Student the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getContextCourseId()
    {
        if (isset($this->course_id) && $this->course_id > 0) {
            return $this->course_id;
        } else {
            return 0;
        }
    }

    public static function getAvailaleRegisterationStatus()
    {
        return array(
            self::STATUS_WAITING => 'منتظر',
            self::STATUS_RETREAT => 'منسحب',
            self::STATUS_IGNORED => 'متجاهل',
        );
    }

    public static function getStatusText($statusId)
    {
        $statusArray = self::getAvailaleRegisterationStatus();
        return $statusArray[$statusId];
    }
}
