<?php

/**
 * This is the model class for table "tbl_student".
 *
 * The followings are the available columns in table 'tbl_student':
 * @property integer $student_id
 * @property integer $course_type_id
 * @property integer $initial_payment
 * @property integer $status
 * @property string $start_date
 * @property string $end_date

 */

class WaitingListForm extends CFormModel{

    public $student_id;
    public $course_type_id;
    public $initial_payment = 0;
    public $status;
    public $start_date;
    public $end_date;
    public $preferred_time;
    public $note;

    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('student_id, course_type_id, status', 'required','message'=>'الحقل " {attribute} " لايمكن ان يكون فارغا'),
            array('initial_payment','numerical','max'=>20000,'message'=>'ادخل قيمة رقمية مناسبة في الحقل {attribute}'),
            array('student_id,course_type_id,initial_payment,status,preferred_time', 'safe', 'on'=>'create'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'student_id' => 'معرف الطالب',
            'course_type_id' => 'معرف نوع الدورة',
            'status' => 'حالة التسجيل',
            'start_date' => 'تاريخ البداية المقترح',
            'end_date' => 'تاريخ النهاية المقترح',
            'initial_payment' => 'دفعة اولى',
            'preferred_time'=>'الوقت المرغوب',
            'note'=>'ملاحظات',
        );
    }
}