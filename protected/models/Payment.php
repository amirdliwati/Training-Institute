<?php

/**
 * This is the model class for table "tbl_payment".
 *
 * The followings are the available columns in table 'tbl_payment':
 * @property integer $id
 * @property integer $student_id
 * @property integer $course_id
 * @property integer $amount
 * @property string $date
 * @property integer $num
 * @property string $note
 *
 * The followings are the available model relations:
 * @property Student $student
 */
class Payment extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */

    public $course_type_id;
    public $student_course_id;


    const FROM_INITIAL_PAYMENT = "مدفوع من الانتظار";

    public function tableName()
    {
        return 'tbl_payment';
    }

    public $num = 0;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('student_id, course_id, amount, num,date', 'required', 'message' => 'الحقل " {attribute} " لايمكن ان يكون فارغا'),
            //array('student_id, course_id, amount, num', 'required', 'message' => 'الحقل " {attribute} " لايمكن ان يكون فارغا', 'on' => 'create'),
            array('date, num', 'required', 'message' => 'الحقل " {attribute} " لايمكن ان يكون فارغا','on'=>'update'),
            array('num','unique','on'=>'create'),
            array('student_id, course_id, amount, num', 'numerical', 'integerOnly' => true, 'message' => 'الحقل {attribute} يجب ان يكون رقما'),

            array('student_id', 'attendCourse'),
            array('amount', 'validAmount','on'=>'create'),
            array('note', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, student_id, course_id, amount, date, num, note', 'safe', 'on' => 'search'),
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
            'course' => array(self::BELONGS_TO, 'Course', 'course_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'معرف الفاتورة',
            'student_course_id'=>'اسم الطالب',
            'student_id' => 'الطالب',
            'course_id' => 'اسم الدورة',
            'amount' => 'قيمة الفاتورة',
            'date' => 'تاريخ دفع الفاتورة',
            'num' => 'رقم الفاتورة',
            'note' => 'ملاحظات حول الفاتورة',
            'course_type_id' => 'الدورة',
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

        $criteria->compare('id', $this->id);
        $criteria->compare('student_id', $this->student_id);
        $criteria->compare('course_id', $this->course_id);
        $criteria->compare('amount', $this->amount);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('num', $this->num);
        $criteria->compare('note', $this->note, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 20,
            ),
        ));


    }

    public function getLastPaymentNo($student_id, $course_id)
    {
        $command = Yii::app()->db->createCommand();
        $payments = $command->select('*')
            ->from('tbl_payment')
            ->where('student_id=:student_id AND course_id=:course_id', array(
                ':student_id' => $student_id,
                ':course_id' => $course_id,
            ))
            ->order('num DESC')
            ->queryAll();
        if (empty($payments)) {
            return 0;
        } else {
            return $payments[0]['num'];
        }
    }

    public function attendCourse($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $command = Yii::app()->db->createCommand();
            $rows = $command->select('*')
                ->from('tbl_student_course_assignment')
                ->where('student_id=:student_id AND course_id =:course_id', array(
                    ':student_id' => $this->student_id,
                    ':course_id' => $this->course_id,
                ))->queryAll();
            $status = !empty($rows);
            if (!$status) {
                $this->addError('student_id', 'الطالب غير موجود في الدورة');
            }
        }
    }
    public function validAmount($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $payments = Payment::model()->findAll("student_id=:student_id AND course_id=:course_id", array(
                ":student_id" => $this->student_id,
                "course_id" => $this->course_id,
            ));
            $course = Course::model()->findByPk($this->course_id);
            $courseCost = intval($course->getCostText());
            $paid = 0;
            foreach ($payments as $payment) {
                $paid += $payment->amount;
            }
            // Get the discount of the student ...
            $command = Yii::app()->db->createCommand();
            $assignments = $command->select('*')
                ->from('tbl_student_course_assignment')
                ->where('student_id = :student_id AND course_id = :course_id', array(
                    ':student_id' => $this->student_id,
                    ':course_id' => $this->course_id,
                ))
                ->queryAll();
            $assignment = $assignments[0];
            $discount =  $assignment['discount'];
            if($this->amount + $paid > $courseCost-$discount){
                $this->addError('amount', 'المبلغ اكبر من المطلوب');
            }
        }
    }


    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Payment the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
