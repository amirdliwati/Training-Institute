<?php
/**
 * Created by PhpStorm.
 * User: Dell 3521
 * Date: 17/05/15
 * Time: 11:40 ص
 */
?>

<table class="table table-bordered" style="background-color: #FFF !important;">
    <tr>
        <th style="text-align: center"><?php echo ICDLTicket::model()->getAttributeLabel('exam_type'); ?></th>
        <th style="text-align: center"><?php echo ICDLTicket::model()->getAttributeLabel('status'); ?></th>
        <th style="text-align: center"><?php echo ICDLTicket::model()->getAttributeLabel('payment'); ?></th>
        <th style="text-align: center"><?php echo ICDLTicket::model()->getAttributeLabel('date'); ?></th>
        <th style="text-align: center"><?php echo ICDLTicket::model()->getAttributeLabel('time'); ?></th>
        <th style="text-align: center">خيارات</th>
    </tr>
    <?php foreach ($model->tickets as $ticket): ?>
        <tr>
            <td style="text-align: center"><?php echo $ticket->getExamTypeText(); ?></td>
            <td style="text-align: center"><?php echo CommonFunctions::getLabel($ticket->status, CommonFunctions::ICDL_TICKET_STUDENT_STATUS); ?></td>
            <td style="text-align: center"><?php echo $ticket->payment; ?></td>
            <td style="text-align: center"><?php echo $ticket->date; ?></td>
            <td style="text-align: center"><?php echo $ticket->time; ?></td>
            <td style="text-align: center">


                <?php echo CHtml::link('<span class="glyphicon glyphicon-trash"></span>', '#', array(
                    'class' => 'delete-icdl-ticket-link',
                    'data-id' => $ticket->id,
                    'style' => 'color: #444; font-size: 14px;margin-right: 5px;',
                    'data-toggle' => "tooltip",
                    'data-placement' => "bottom",
                    'title' => "حذف تذكرة امتحان",
                ));?>
                <?php echo CHtml::link('<span class="glyphicon glyphicon-pencil"></span>', '#', array(
                    'class' => 'update-icdl-ticket-link',
                    'data-id' => $ticket->id,
                    'style' => 'color: #444; font-size: 14px;margin-right: 5px;',
                    'data-toggle' => "tooltip",
                    'data-placement' => "bottom",
                    'title' => "تعديل تذكرة امتحان",
                ));?>
            </td>
        </tr>
    <?php endforeach; ?>

</table>