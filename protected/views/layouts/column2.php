<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
        <div class="row">
            <div class="col-md-12 col-xs-12 col-sm-12">
                <div class="section-container section-container-padding">

                    <div class="row">
                        <div class="sidebar-container">
                            <h3>خيارات</h3>
                            <?php $this->widget('application.components.OptionsMenu',array(
                                'options'=>$this->options,
                            ));?>
                        </div>
                        <div class="col-sm-9 col-md-9 col-sm-offset-3 col-md-offset-3">
                            <h2 class="SubHeader"><?php echo $this->pageTitle;?></h2>
                            <br/>
                            <div class="panel panel-warning">
                                <div class="panel-heading">
                                    <span>تنبيه<span>
                                </div>
                                <div class="panel-body">
                                    <span>للاطلاع على التحديثات الجديدة للتطبيق - التوجه نحو رابط "البرامج الجديدة"</span>
                                </div>
                            </div>
                            <?php echo $content;?>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    <div class="clearfix"></div>
<?php $this->endContent(); ?>