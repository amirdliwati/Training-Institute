<?php
/**
 * @var $model Payment
 * @var $this PaymentController
 *
 */
?>
<p></p>
<div class="panel panel-default">

    <div class="panel-body">
        <?php
        $this->renderPartial('_form', array(
            'model'=>$model,
            'message'=>$message,
        ));
        ?>
    </div>
</div>

