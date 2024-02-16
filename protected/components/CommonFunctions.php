<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Johnny & Ahmad
 * Date: 10/23/13
 * Time: 10:56 AM
 * To change this template use File | Settings | File Templates.
 */

Yii::import('ext.Browser');

class CommonFunctions
{

    /*
   * Generate random password
     */
    const TYPE_active = 1;
    /*
   * Get status id active or not
   * $type => 1= active ,2= direction
     * 1=read | 0=new | 2=new reply | 3=waiting for reply|4=closed
   */
    const COURSE_STATUS = 1;
    const STUDENT_COURSE_FINANCIAL_STATUS = 2;
    const STUDENT_ASSESSMENT_STATUS = 3;
    const STUDENT_IS_TRANSFERED = 4;


    const ICDL_TICKET_STUDENT_STATUS = 5;
    const REGISTRATION_METHOD = 6;
    public static function generatePassword()
    {
        return Process::random_string(10, 10);
    }

    public static function getLabel($status, $type = self::COURSE_STATUS)
    {
        if ($type == self::COURSE_STATUS) {
            $array = array(
                Course::STATUS_NOT_YET_STARTED => '<span class="label label-primary">' . "لم تبدأ بعد" . '</span>',
                Course::STATUS_IN_PROGRESS => '<span class="label label-success">' . "فعالة" . '</span>',
                Course::STATUS_FINISHED => '<span class="label label-warning">' . "منتهية" . '</span>',
            );
        }
        if ($type == self::STUDENT_COURSE_FINANCIAL_STATUS) {
            $array = array(
                Course::STUDENT_COURSE_FINANCIAL_STATUS_OBLIGED => '<span class="label label-danger">' . "غير بريء الذمة المالية" . '</span>',
                Course::STUDENT_COURSE_FINANCIAL_STATUS_DONE => '<span class="label label-success">' . "بريء الذمة المالية" . '</span>',

            );
        }
        if ($type == self::REGISTRATION_METHOD) {
            $array = array(
                Registration::REGISTRATION_METHOD_DIRECT => '<span class="label label-success">' . "مباشر" . '</span>',
                Registration::REGISTRATION_METHOD_REMOTE => '<span class="label label-danger">' . "أونلاين" . '</span>',
            );
        }
        if($type == self::STUDENT_ASSESSMENT_STATUS){
            $array = array(
                Course::STUDENT_GRADE_NOT_SPECIFIED=>'<span class="label label-danger">'."لايوجد".'</span>',
                Course::STUDENT_GRADE_GOOD=>'<span class="label label-warning">'."جيد".'</span>',
                Course::STUDENT_GRADE_VERY_GOOD=>'<span class="label label-primary">'."جيد جدا".'</span>',
                Course::STUDENT_GRADE_EXCELLENT=>'<span class="label label-success">'."ممتاز".'</span>',
            );
        }

        if($type == self::STUDENT_IS_TRANSFERED){
            $array = array(
                Student::STATUS_STUDENT_IS_TRANSFERED=>'<span class="label label-success">'."مرحل".'</span>',
                Student::STATUS_STUDENT_IS_NOT_TRANSFERED=>'<span class="label label-danger">'."غير مرحل".'</span>',
            );
        }
        if($type == self::ICDL_TICKET_STUDENT_STATUS){
            $array = array(
                ICDLTicket::STATUS_WAITING=>'<span class="label label-default">'."بالانتظار".'</span>',
                ICDLTicket::STATUS_ABSENT=>'<span class="label label-warning">'."غائب".'</span>',
                ICDLTicket::STATUS_SUCCESS=>'<span class="label label-success">'."ناجح".'</span>',
                ICDLTicket::STATUS_FAILED=>'<span class="label label-danger">'."راسب".'</span>',
            );
        }
        return $array[$status];
    }

    public static function getBootstrapModal($id = 'modal', $label = 'modalLabel', $title, $content, $width = 'auto', $height = 'auto')
    {

        $modal = '<!-- Boostrap modal dialog -->
                    <div class="modal fade" id="' . $id . '" tabindex="-1" role="dialog" aria-labelledby="' . $label . '" aria-hidden="true">
                        <div class="modal-dialog" style="width:' . $width . ';">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title">' . $title . '</h4>
                                </div>
                                <div class="modal-body" style="height:' . $height . ';">' . $content . '</div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->';
        return $modal;
    }

    /*
     * Tracking function
     * track visitors ad users
     */

    public static function Tracking()
    {
        $model = new Visitors;
        $b = new Browser;

        $model->link = $b->getUrl();
        $model->ip = $b->getIp();
        $model->os = $b->getPlatform();

        $model->browser = $b->getBrowser();
        $model->lang = $b->getLanguage();
        if (isset(Yii::app()->user->id)) {
            $model->user_id = Yii::app()->user->id;
        }
        $model->product_id = Helper::PRODUCT;
        $model->country = $b->getCountry();
        $model->save(false);


    }

    /*
       * detect language
       */

    public static function detectLanguage()
    {
        $app = Yii::app();
        $b = new Browser();
        $lang = $b->getLanguage();

        if (isset(yii::app()->request->cookies['lang'])) {
            if (yii::app()->request->cookies['lang'] == 'ar') {
                $app->theme = 'Genyx-ar';
                $app->language = 'ar';
            } else {
                $app->theme = 'Genyx';
                $app->language = 'en';
            }

        } else {
            if ($lang == 'ar') {
                $app->theme = 'Genyx-ar';
                $app->language = 'ar';
            } else {
                $app->theme = 'Genyx';
                $app->language = 'en';
            }
        }

    }

    public static function getMonthsArray()
    {

        return array(
            '1' => Yii::t('app', 'Jan'),
            '2' => Yii::t('app', 'Feb'),
            '3' => Yii::t('app', 'Mar'),
            '4' => Yii::t('app', 'Apr'),
            '5' => Yii::t('app', 'May'),
            '6' => Yii::t('app', 'Jun'),
            '7' => Yii::t('app', 'Jul'),
            '8' => Yii::t('app', 'Aug'),
            '9' => Yii::t('app', 'Sep'),
            '10' => Yii::t('app', 'Oct'),
            '11' => Yii::t('app', 'Nov'),
            '12' => Yii::t('app', 'Dec'),
        );
    }

    public static function getDaysArray()
    {
        return array(
            0=>'الأحد',
            1=>'الأثنين',
            2=>'الثلاثاء',
            3=>'الاربعاء',
            4=>'الخميس',
            5=>'الجمعة',
            6=>'السبت',
        );
    }


    public static function getYearsArray()
    {
        $years = array();
        $year = date('Y');
        for ($i = 0; $i < 100; $i++) {
            $years[$year] = $year;
            $year = date("Y", strtotime(-1 * $i . " year"));
        }
        if (Yii::app()->language == 'en') {

        }
        return $years;


    }


    /*
     * product languages
     *
     */

    public static function languagesList()
    {
        return array('en' => 'English Language', 'ar' => 'اللغة العربية', 'fr' => 'French Language');
    }


    /*
     * product Languages array
     */

    public static function languagesArray()
    {
        return array('en', 'ar', 'fr');
    }

    /*
 * get  related to language
 */

    public static function getDbSuffix()
    {
        if (Yii::app()->language == 'ar') {
            return 'ar_';
        } else {
            return 'en_';
        }
    }

    /*
     * sent language
     */

    public static function setPrefix()
    {
        if (language() == 'ar') {
            return '_ar';
        }
        if (language() == 'en') {
            return '_en';
        }
        if (language() == 'fr') {
            return '_fr';
        }
    }


    /*
     * Return user id
     */

    public static function getUserID()
    {
        if (isset(Yii::app()->user->user_id)) {
            return Yii::app()->user->user_id;
        } else {
            return null;
        }
    }


    /*
     * fix dublicate files with Ajax requests
     *
     */

    public static function fixAjax()
    {
        if (Yii::app()->request->isAjaxRequest) {
//css
            Yii::app()->clientScript->scriptMap['app.css'] = false;
            Yii::app()->clientScript->scriptMap['bootstrap.css'] = false;
            Yii::app()->clientScript->scriptMap['bootstrap-theme.css'] = false;
            Yii::app()->clientScript->scriptMap['custom.css'] = false;
            Yii::app()->clientScript->scriptMap['bootstrapSwitch.css'] = false;
            Yii::app()->clientScript->scriptMap['spectrum.css'] = false;
            //Yii::app()->clientScript->scriptMap['datepicker.css'] = false;
            Yii::app()->clientScript->scriptMap['select2.css'] = false;
            Yii::app()->clientScript->scriptMap['ui.multiselect.css'] = false;
            Yii::app()->clientScript->scriptMap['bootstrap-wysihtml5.css'] = false;

//js

            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            // Yii::app()->clientscript->scriptMap['jquery.min.js'] = false;
            // Yii::app()->clientscript->scriptMap['jquery.yiiactiveform.js'] = false;
            // Yii::app()->clientscript->scriptMap['jquery.ba-bbq.js'] = false;
            // Yii::app()->clientscript->scriptMap['jquery.ba-bbq.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.pnotify.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.autosize-min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.inputlimiter.1.3.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.mask.min.js'] = false;
            Yii::app()->clientscript->scriptMap['bootstrapSwitch.js'] = false;
            Yii::app()->clientscript->scriptMap['globalize.js'] = false;
            Yii::app()->clientscript->scriptMap['spectrum.js'] = false;
           // Yii::app()->clientscript->scriptMap['bootstrap-datepicker.js'] = false;
            Yii::app()->clientscript->scriptMap['select2.js'] = false;
            Yii::app()->clientscript->scriptMap['ui.multiselect.js'] = false;
            Yii::app()->clientscript->scriptMap['bootstrap-wysihtml5.js'] = false;
            Yii::app()->clientscript->scriptMap['form-elements.js'] = false;
            Yii::app()->clientscript->scriptMap['bootstrap.js'] = false;
            Yii::app()->clientscript->scriptMap['conditionizr.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.nicescroll.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jRespond.min.js'] = false;
            // Yii::app()->clientscript->scriptMap['jquery.genyxAdmin.js'] = false;
            //  Yii::app()->clientscript->scriptMap['jquery.uniform.min.js'] = false;
            //  Yii::app()->clientscript->scriptMap['app.js'] = false;
            //  Yii::app()->clientscript->scriptMap['domready.js'] = false;

            //   Yii::app()->clientscript->scriptMap['jquery.yiigridview.js'] = false;

        }

    }

    /*
     * return files icons
     * @ext = extension
     */
    public static function getFilesIcons($ext)
    {

        $icon = "";
        switch ($ext) {

            case "jpg":
                $icon = "<i class='i-image'></i>";
                break;
            case "png":
                $icon = "<i class='i-image'></i>";
                break;
            case "gif":
                $icon = "<i class='i-image'></i>";
                break;
            case "doc":
                $icon = "<i class='i-file-word'></i>";
                break;
            case "docx":
                $icon = "<i class='i-file-word'></i>";
                break;
            case "pdf":
                $icon = "<i class='i-file-pdf'></i>";
                break;
            case "xlsx":
                $icon = "<i class='i-file-excel'></i>";
                break;
            case "rar":
                $icon = "<i class='i-file-zip'></i>";
                break;
            case "zip":
                $icon = "<i class='i-file-zip'></i>";
                break;
            default:
                $icon = "<i class='i-libreoffice'></i>";

        }
        return $icon;
    }


}

