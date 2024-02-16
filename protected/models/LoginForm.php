<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{
    public $email;
    public $password;
    public $rememberMe;
    private $_identity;
    public $_id;
    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return array(
            // username and password are required
            array('email', 'required','message'=>'البريد الإلكتروني لايمكن ان يكون فارغا'),
            array('password', 'required','message'=>'كلمة السر لا يمكن ان تكون فارغة'),
            // rememberMe needs to be a boolean
            array('rememberMe', 'boolean'),
            array('email','match','pattern'=>'/([A-Za-z0-9._]+\@[a-z-]*\.com)/','message'=>'البريد الالكتروني يجب ان يكون من الشكل name@host.com'),
            // password needs to be authenticated
            array('password', 'authenticate'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'email'=>'البريد الالكتروني',
            'rememberMe'=>'تذكر كلمة المرور عند دخول التطبيق مرة اخرى',
            'password'=>'كلمة المرور',

        );
    }

    /**
     * Authenticates the password.
     * This is the 'authenticate' validator as declared in rules().
     */
    public function authenticate($attribute,$params)
    {
        if(!$this->hasErrors())
        {
            $this->_identity=new UserIdentity($this->email,$this->password);
            if(!$this->_identity->authenticate())
                $this->addError('password','خطأ في اسم المستخدم او كلمة المرور');
        }
    }

    /**
     * Logs in the user using the given username and password in the model.
     * @return boolean whether login is successful
     */
    public function login()
    {
        if($this->_identity===null)
        {
            $this->_identity=new UserIdentity($this->email,$this->password);
            $this->_identity->authenticate();
        }
        if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
        {
            $duration= 3600*24; // 1 day
            Yii::app()->user->login($this->_identity,$duration);
            return true;
        }
        else
            return false;
    }
}
