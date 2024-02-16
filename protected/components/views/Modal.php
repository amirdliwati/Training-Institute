<!-- Boostrap modal dialog -->
<div class="modal fade" id="<?php echo $modalName; ?>" tabindex="-1" role="dialog" style="z-index: 10000;" aria-labelledby="myModalLabel" aria-hidden="true" style="display:none">
    <div class="modal-dialog modal-lg" style="width: <?php echo $width; ?>;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?php echo $title; ?></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <?php echo $this->controller->renderPartial("application.views.$form", array('model' => $model, 'id' => $id, 'type' => $type)); ?>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div><!-- /.modal -->
