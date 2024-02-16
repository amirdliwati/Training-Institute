<?php

/**
 * This is the model class for table "tbl_session".
 *
 * The followings are the available columns in table 'tbl_session':
 * @property integer $id
 * @property string $date
 * @property integer $course_id
 * @property integer $DOW
 * @property integer $num
 *
 * The followings are the available model relations:
 * @property Attendance[] $attendances
 * @property Course $course
 */
class Session extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_session';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('date, course_id', 'required','message'=>'الحقل " {attribute} " لايمكن ان يكون فارغا'),
			array('course_id, DOW, num', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, date, course_id, DOW, num', 'safe', 'on'=>'search'),
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
			'attendances' => array(self::HAS_MANY, 'Attendance', 'session_id'),
			'course' => array(self::BELONGS_TO, 'Course', 'course_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'معرف الجلسة',
			'date' => 'تاريخ الجلسة',
			'course_id' => 'الدورة',
			'DOW' => 'يوم الجلسة',
			'num' => 'رقم الجلسة',
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
		$criteria->compare('date',$this->date,true);
		$criteria->compare('course_id',$this->course_id);
		$criteria->compare('DOW',$this->DOW);
		$criteria->compare('num',$this->num);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function getLastSessionNo($course_id)
    {
        $command = Yii::app()->db->createCommand();
        $sessions = $command->select('*')
            ->from('tbl_session')
            ->where('course_id=:course_id', array(
                ':course_id' => $course_id,
            ))
            ->order('num DESC')
            ->queryAll();
        if (empty($sessions)) {
            return 0;
        } else {
            return $sessions[0]['num'];
        }
    }
    public function clearAttendance(){
        $attendances=$this->attendances;
        foreach($attendances as $attendance){
            $attendance->attending = Attendance::STATUS_ABSENT;
            $attendance->save();
        }
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Session the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
