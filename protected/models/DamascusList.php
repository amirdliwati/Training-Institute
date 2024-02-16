<?php

/**
 * This is the model class for table "tbl_damascus_list".
 *
 * The followings are the available columns in table 'tbl_damascus_list':
 * @property integer $id
 * @property integer $num
 * @property string $date
 * @property string $start_date
 * @property string $end_date
 *
 * The followings are the available model relations:
 * @property DamascusListEntry[] $damascusListEntries
 */
class DamascusList extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'tbl_damascus_list';
    }

    public $course_type_id;
    public $father_name;
    public $first_name;
    public $last_name;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('num, date, start_date, end_date', 'required'),
            array('num', 'numerical', 'integerOnly' => true),
            array('num', 'unique'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, num, date, start_date, end_date,course_type_id,father_name,first_name,last_name', 'safe', 'on' => 'search'),
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
            'damascusListEntries' => array(self::HAS_MANY, 'DamascusListEntry', 'damascus_list_id'),
            'noOfEntries' => array(self::STAT, 'DamascusListEntry', 'damascus_list_id'),
            'courseType' => array(self::BELONGS_TO, 'CourseType', 'course_type_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */

    public function attributeLabels()
    {
        return array(
            'id' => 'معرف لائحة دمشق',
            'num' => 'رقم اللائحة',
            'start_date' => 'تاريخ البداية في اللائحة',
            'end_date' => 'تاريخ النهاية في اللائحة',
            'father_name' => 'اسم الاب',
            'first_name' => 'الاسم الاول',
            'last_name' => 'الكنية',
            'course_type_id' => 'نوع الدورة',
            'date' => 'تاريخ اللائحة',
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


        $criteria->compare('num', $this->num, true);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('start_date', $this->start_date, true);
        $criteria->compare('end_date', $this->end_date, true);

        $listEntryCriteria = new CDbCriteria;

        $damascusListIds = array();

        $nothingToCompare = true;
        if (isset($this->course_type_id) && !empty($this->course_type_id)) {
            $nothingToCompare = false;
            $courses = CourseType::model()->with('courses')->find('t.id=:id', array(':id' => $this->course_type_id))->courses;
            $courseIds = array();
            foreach ($courses as $course) {
                $courseIds[] = $course->id;
            }
            $listEntryCriteria->condition = 'course_id IN (' . implode(',', $courseIds) . ')';
        }


        if (!empty($this->first_name) || !empty($this->last_name) || !empty($this->father_name)) {
            $studentCriteria = new CDbCriteria;

            $studentCriteria->compare('first_name', $this->first_name, true);
            $studentCriteria->compare('last_name', $this->last_name, true);
            $studentCriteria->compare('father_name', $this->father_name, true);
            // This partition of code doesn't function if there is more than one student
            $students = Student::model()->findAll($studentCriteria);

            $nothingToCompare = false;
            $student_ids = array();
            foreach($students as $student){
                $student_ids[]=$student->id;
            }
            $listEntryCriteria->addCondition("student_id IN (" . implode(',', $student_ids) . ")");
        }

        if (!$nothingToCompare) {
            $listEntries = DamascusListEntry::model()->findAll($listEntryCriteria);
            foreach ($listEntries as $entry) {
                $damascusListIds[] = $entry->damascus_list_id;
            }
            if(!empty($damascusListIds)){
                $criteria->condition = 'id in(' . implode(',', $damascusListIds) . ')';
            }else{
                $criteria->condition = 'id =-1';
            }
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return DamascusList the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
