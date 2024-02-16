<?php

/**
 * This is the model class for table "tbl_phone_number".
 *
 * The followings are the available columns in table 'tbl_phone_number':
 * @property integer $id
 * @property string $number
 * @property integer $type
 * @property integer $owner_id
 */
class PhoneNumber extends CActiveRecord
{

    const HOME_NUMBER = 1;
    const MOBILE_NUMBER = 2;



    /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_phone_number';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('number, type, owner_id', 'required','message'=>'الحقل " {attribute} " لايمكن ان يكون فارغا'),
			array('type, owner_id', 'numerical', 'integerOnly'=>true),
			array('number', 'length', 'max'=>20),
            array('number','match','pattern'=>'/[0][9][0-9]{8}/','message'=>'رقم الهاتف يجب ان يكون من الشكل: 09########','on'=>'mobile_no'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, number, type, owner_id', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'معرف رقم الهاتف',
			'number' => 'الرقم',
			'type' => 'نوع رقم الهاتف',
			'owner_id' => 'معرف صاحب رقم الهاتف',
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
		$criteria->compare('number',$this->number,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('owner_id',$this->owner_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    /**
     * @return array all phone number types
     */
    public static function getAllPhoneNumberTypes(){
        return array(
            self::HOME_NUMBER=>'هاتف ارضي',
            self::MOBILE_NUMBER=>'هاتف خليوي',
        );
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PhoneNumber the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
