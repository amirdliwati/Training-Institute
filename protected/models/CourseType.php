<?php

/**
 * This is the model class for table "tbl_course_type".
 *
 * The followings are the available columns in table 'tbl_course_type':
 * @property integer $id
 * @property string $name
 * @property string $description
 */
class CourseType extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'tbl_course_type';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'required', 'message' => 'حقل اسم نوع الدورة حقل مطلوب'),
            array('name', 'length', 'max' => 255),
            array('name', 'unique', 'message' => 'نوع الدورة بهذا الاسم موجود مسبقا'),
            array('description', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, description', 'safe', 'on' => 'search'),
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
            'courses' => array(self::HAS_MANY, 'Course', 'course_type_id'),
            'students' => array(self::MANY_MANY, 'Student', 'tbl_student_course_type_assignment(course_type_id,student_id)'),
            'studentWaitingCount' => array(self::STAT,'Registration','course_type_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'معرف نوع الدورة',
            'name' => 'نوع الدورة',
            'description' => 'توصيف الدورة',
        );
    }

    /**
     * @return array  All available course types in the system  (id=>course_type_name)
     */

    public function getAvailableCourseTypes()
    {
        $courseTypes = CourseType::model()->findAll();
        $courseTypesArray = array();
        if (!empty($courseTypes)) {

            $courseTypesArray = CHtml::listData($courseTypes, 'id', 'name');
        }
        return $courseTypesArray;
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
        $criteria->compare('name', $this->name, true);
        $criteria->compare('description', $this->description, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getDescriptionText()
    {
        return isset($this->description) && strlen($this->description) > 0 ? $this->description : "لا يوجد توصيف متوفر لهذه الدورة";
    }

    public function getStudentWaitingList()
    {
        return Yii::app()->db->createCommand()
            ->select('*')
            ->from('tbl_student_course_type_assignment')
            ->where('course_type_id=:course_type_id', array(':course_type_id' => $this->id))
            ->queryAll();
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CourseType the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
