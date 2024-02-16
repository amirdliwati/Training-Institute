<?php

/**
 * This is the model class for table "tbl_instructor".
 *
 * The followings are the available columns in table 'tbl_instructor':
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $tel
 * @property string $mobile
 * @property string $added_date
 * @property string $note
 *
 * The followings are the available model relations:
 * @property Course[] $tblCourses
 * @property CourseType[] $tblCourseTypes
 */
class Instructor extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_instructor';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('first_name, last_name, added_date', 'required','message'=>'الحقل " {attribute} " لايمكن ان يكون فارغا'),
			array('first_name, last_name, tel, mobile', 'length', 'max'=>45),
			array('note', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, first_name, last_name, tel, mobile, added_date, note', 'safe', 'on'=>'search'),
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
            'courseNo' => array(self::STAT, 'Course', 'instructor_id'),
			'tblCourses' => array(self::HAS_MANY, 'Course', 'instructor_id'),

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
			'last_name' => 'الكنية',
			'tel' => 'رقم الهاتف',
			'mobile' => 'رقم المحمول',
			'added_date' => 'تاريخ الانضمام للمعهد',
			'note' => 'ملاحظات',
		);
	}

    public function assignCourse($course_id){
        try{
            Yii::app()->db->createCommand()
                ->insert('tbl_instructor_course_assignment',array(
                    'course_id'=>$course_id,
                    'instructor_id'=>$this->id,
                ));
        }catch (CDbException $e){

        }

    }

    public function getName(){
        return $this->first_name." ".$this->last_name;
    }

    public function isDeletable(){
        if($this->courseNo>0){
            return false;
        }else{
            return true;
        }
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

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('tel',$this->tel,true);
		$criteria->compare('mobile',$this->mobile,true);
		$criteria->compare('added_date',$this->added_date,true);
		$criteria->compare('note',$this->note,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Instructor the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
