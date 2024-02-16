<?php

/**
 * This is the model class for table "tbl_icdl_card".
 *
 * The followings are the available columns in table 'tbl_icdl_card':
 * @property integer $id
 * @property string $first_name_en
 * @property string $last_name_en
 * @property string $un_code
 * @property integer $payment
 * @property integer $lang
 * @property integer $status
 * @property integer $student_id
 *
 * The followings are the available model relations:
 * @property Student $student
 */
class ICDLCard extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ICDLCard the static model class
	 */

    const LANG_ARABIC = 1;
    const LANG_ENGLISH = 2;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_icdl_card';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('first_name_en, last_name_en,first_name,last_name,father_name,payment, un_code, student_id,lang', 'required','on'=>'create', 'message' => 'الحقل " {attribute} " لايمكن ان يكون فارغا'),
            array('id,first_name_en, last_name_en,first_name,last_name,father_name,payment, un_code, student_id,lang', 'required','on'=>'update', 'message' => 'الحقل " {attribute} " لايمكن ان يكون فارغا'),
            array('payment, lang, status, student_id', 'numerical', 'integerOnly'=>true),
			array('first_name_en, last_name_en', 'length', 'max'=>255),
            array('un_code','length','min'=>10,'message'=>'لايمكن ان يكون طول حقل الكود اقل من 10'),
			array('un_code','length','max'=>10,'message'=>'لايمكن ان يكون طول حقل الكود اكبر من 10'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, first_name_en,first_name,last_name,father_name, last_name_en, un_code, payment, lang, status, student_id', 'safe', 'on'=>'search'),
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
            'tickets'=>array(self::HAS_MANY, 'ICDLTicket', 'icdl_card_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'first_name_en' => 'الاسم الاول (انكليزي)',
			'last_name_en' => 'الاسم الاخير (انكليزي)',
            'first_name'=>'الاسم الاول',
            'last_name'=>'الاسم الاخير',
            'father_name'=>'اسم الاب',
			'un_code' => 'رمز ال UN',
			'payment' => 'المبلغ المدفوع',
			'lang' => 'اللغة',
			'status' => 'الحالة',
			'student_id' => 'معرف الطالب',
		);
	}

    public static function getLanguageArray(){
        return array(
            self::LANG_ARABIC=>'العربية'  ,
            self::LANG_ENGLISH=>'الانكليزية',
        );
    }

    public function getLanguageText(){
        $langArray = self::getLanguageArray();
        return $langArray[$this->lang];
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
		$criteria->compare('first_name_en',$this->first_name_en,true);
		$criteria->compare('last_name_en',$this->last_name_en,true);
        $criteria->compare('first_name',$this->first_name,true);
        $criteria->compare('last_name',$this->last_name,true);
        $criteria->compare('father_name',$this->father_name,true);
		$criteria->compare('un_code',$this->un_code,true);
		$criteria->compare('payment',$this->payment);
		$criteria->compare('lang',$this->lang);
		$criteria->compare('status',$this->status);
		$criteria->compare('student_id',$this->student_id);
        return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}