<?php

/**
 * This is the model class for table "tbl_icdl_ticket".
 *
 * The followings are the available columns in table 'tbl_icdl_ticket':
 * @property integer $id
 * @property integer $exam_type
 * @property integer $payment
 * @property integer $status
 * @property string $date
 * @property string $time
 * @property integer $icdl_card_id
 */
class ICDLTicket extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ICDLTicket the static model class
	 */

    const STATUS_WAITING = 0;
    const STATUS_ABSENT = 1;
    const STATUS_SUCCESS = 2;
    const STATUS_FAILED = 3;

    const MODULE_1 = 1;
    const MODULE_2 = 2;
    const MODULE_3 = 3;
    const MODULE_4 = 4;
    const MODULE_5 = 5;
    const MODULE_6 = 6;
    const MODULE_7 = 7;

    const TYPE_AFTER_COURSE = 0;
    const TYPE_ALONE = 1;
    const TYPE_OTHER = 2;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_icdl_ticket';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('exam_type, status, payment,date, time, icdl_card_id', 'required','on'=>'create'),

            array('id,exam_type, status, payment,date, time, icdl_card_id', 'required','on'=>'update'),

            array('id,exam_type, payment, status, icdl_card_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, exam_type, payment, status, date, time, icdl_card_id', 'safe', 'on'=>'search'),
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
            'icdlCard'=>array(self::BELONGS_TO,'ICDLCard','icdl_card_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */

    public static function getStatusList(){
        return array(
            self::STATUS_WAITING=>'بالانتظار',
            self::STATUS_ABSENT=>'غائب',
            self::STATUS_SUCCESS=>'ناجح',
            self::STATUS_FAILED=>'راسب',
        );
    }

    public static function getExamTypeList(){
        return array(
            self::TYPE_AFTER_COURSE=>'بعد دورة ضمن المعهد',
            self::TYPE_ALONE=>'امتحان فقط',
            self::TYPE_OTHER => 'أخرى',
        );
    }
    public static function getModuleList(){
        return array(
            self::MODULE_1=>'Module 1',
            self::MODULE_2=>'Module 2',
            self::MODULE_3=>'Module 3',
            self::MODULE_4=>'Module 4',
            self::MODULE_5=>'Module 5',
            self::MODULE_6=>'Module 6',
            self::MODULE_7=>'Module 7',
        );
    }
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'exam_type' => 'نوع الامتحان',
			'payment' => 'الدفعة',
			'status' => 'حالة الطالب',
			'date' => 'التاريخ',
			'time' => 'الوقت',
			'icdl_card_id' => 'بطاقة ال ICDL',
		);
	}

    public function getExamTypeText(){
        $typesArray = $this->getModuleList();
        return $typesArray[$this->exam_type];
    }

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('exam_type',$this->exam_type);
		$criteria->compare('payment',$this->payment);
		$criteria->compare('status',$this->status);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('time',$this->time,true);
		$criteria->compare('icdl_card_id',$this->icdl_card_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}