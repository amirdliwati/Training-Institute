<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
    <div class="row">
        <div class="col-md-12 col-xs-12 col-sm-12">
            <div class="section-container section-container-padding">
                <h2 class="SubHeader"><?php echo $this->pageTitle; ?></h2>

                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div>
                            <?php
                            // The output of the render function goes here ...
                            echo $content;
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix">

    </div>
<?php $this->endContent(); ?>