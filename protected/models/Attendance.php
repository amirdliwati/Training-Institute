<?php

/**
 * This is the model class for table "tbl_attendance".
 *
 * The followings are the available columns in table 'tbl_attendance':
 * @property integer $id
 * @property string $attending
 * @property integer $session_id
 * @property integer $student_id
 *
 * The followings are the available model relations:
 * @property Session $session
 * @property Student $student
 */
class Attendance extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */

    const STATUS_ABSENT = 0;
    const STATUS_PRESENT = 1;
	public function tableName()
	{
		return 'tbl_attendance';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('attending, session_id, student_id', 'required','message'=>'الحقل " {attribute} " لايمكن ان يكون فارغا'),
			array('session_id, student_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, attending, session_id, student_id', 'safe', 'on'=>'search'),
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
			'session' => array(self::BELONGS_TO, 'Session', 'session_id'),
			'student' => array(self::BELONGS_TO, 'Student', 'student_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'معرف الحضور',
			'attending' => 'حالة الحضور',
			'session_id' => 'معرف الجلسة',
			'student_id' => 'معرف الطالب',
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

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('attending',$this->attending,true);
		$criteria->compare('session_id',$this->session_id);
		$criteria->compare('student_id',$this->student_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Attendance the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
