<?php

/**
 * This is the model class for table "tbl_user".
 *
 * The followings are the available columns in table 'tbl_user':
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property string $password
 *
 */
class User extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'tbl_user';
    }
    public $password_repeat;
    const SALT = "jas#&12a1@(/as";
    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('username', 'required','message'=>'حقل اسم المستخدم لا يمكن ان يكون فارغا'),
            array('email', 'required','message'=>'حقل البريد الإلكتروني لا يمكن ان يكون فارغا'),
            array('password', 'required','message'=>'حقل كلمة السر لا يمكن ان يكون فارغا'),
            array('password_repeat','required', 'message'=>'حقل تاكيد كلمة السر لايمكن ان يكون فارغا'),
            array('username,email,password', 'length', 'max'=>255),
            array('email','unique','message'=>'البريد الإلكتروني مأخوذ مسبقا'),
            array('username','unique','message'=>'اسم المستخدم موجود مسبقا'),
            array('password','compare','message'=>'لايوجد تطابق في كلمة السر'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, username, email, password,password_repeat', 'safe', 'on'=>'search'),
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
            'id' => 'ID',
            'username' => 'اسم المستخدم',
            'email' => 'البريد الالكتروني',
            'password' => 'كلمة السر',
            'password_repeat'=>'تأكيد كلمة السر'
        );
    }

    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id);
        $criteria->compare('username',$this->username,true);
        $criteria->compare('email',$this->email,true);
        $criteria->compare('password',$this->password,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    public function assignAdmin($userId){
        try{
            Yii::app()->authManager->assign('admin',$userId);
        }catch (CDBExcetion $e){

        }
    }

    public function removeAdmin($userId){
        Yii::app()->authManager->revoke('admin',$userId);
    }

    public function isAdmin($userId){
        $users = Yii::app()->db->createCommand()
            ->select('*')
            ->from('authassignment')
            ->where('itemname=:itemname AND userid=:userid', array(':userid'=>$userId,':itemname'=>'admin'))
            ->queryAll();
        return !empty($users);
    }

    protected function afterValidate(){
        parent::afterValidate();
        $this->password = $this->hashPassword($this->password);
    }

    public function hashPassword($password){
        return sha1(self::SALT.$password);

    }

    public function validatePassword($password){
        return $this->password ===$this->hashPassword($password);
    }
    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return User the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}
