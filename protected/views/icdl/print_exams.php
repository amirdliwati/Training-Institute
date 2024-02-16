<h2 style="text-align: center;">مركز إيكارد للعلوم</h2>
<hr/>

<?php
    $dayNo = date('w',strtotime($_GET['date']));
    $daysArray = CommonFunctions::getDaysArray();
    $day = $daysArray[$dayNo];
    $date = $_GET['date'];
?>
<h3 style="text-align: center;">جدول امتحانات يوم <?php echo $day?></h3>

<p style="font-size: 19px;text-align: center;">Session: <?php echo $_GET['time']?> | <span><?php echo $date;?></span></p>
<hr/>

<table class="table" style="background-color: #FFF !important;">

    <tr>
        <th style="text-align: center"><?php echo ICDLCard::model()->getAttributeLabel('lang'); ?></th>
        <th style="text-align: center"><?php echo ICDLTicket::model()->getAttributeLabel('exam_type'); ?></th>
        <th style="text-align: center"><?php echo ICDLCard::model()->getAttributeLabel('last_name_en'); ?></th>
        <th style="text-align: center"><?php echo ICDLCard::model()->getAttributeLabel('first_name_en'); ?></th>
        <th style="text-align: center"><?php echo ICDLCard::model()->getAttributeLabel('un_code'); ?></th>
    </tr>

    <?php foreach ($tickets as $ticket): ?>
        <tr>
            <td style="text-align: center"><?php echo $ticket->icdlCard->getLanguageText();?></td>
            <td style="text-align: center"><?php echo $ticket->getExamTypeText(); ?></td>
            <td style="text-align: center"><?php echo $ticket->icdlCard->last_name_en; ?></td>
            <td style="text-align: center"><?php echo $ticket->icdlCard->first_name_en; ?></td>
            <td style="text-align: center"><?php echo $ticket->icdlCard->un_code; ?></td>
        </tr>
    <?php endforeach; ?>

</table>