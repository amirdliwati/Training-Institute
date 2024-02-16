<?php
/**
 * Created by PhpStorm.
 * User: Dell 3521
 * Date: 11/09/14
 * Time: 06:30 م
 */
$message = "";
foreach($students as $student){
    $message .= empty($student->mobileNo(array("limit"=>1)))?"":$student->mobileNo(array("limit"=>1))[0]->number." ";
}
echo $message;?>

<?php
$messageTel = "";
$notFound = true;
foreach($students as $student){
    if(empty($student->mobileNo(array("limit"=>1)))){
        $notFound = false;
        $messageTel .= $student->getName();
        $messageTel .= " : ";
        $messageTel .= empty($student->telNo(array("limit"=>1)))?"":$student->telNo(array("limit"=>1))[0]->number;
        $messageTel .= "<br/>";
    }
}?>
<?php if($notFound==false):?>
<br/>
<h5>اسماء الطلاب الذين لم يسجلو ارقام هواتفهم:</h5>
<br/>
<?php endif;?>
<?php
if($notFound==false){
    echo $messageTel;
}
?>