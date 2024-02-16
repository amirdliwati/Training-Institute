<!-- <ul class="nav nav-pills nav-stacked">
    <?php //foreach($options as $option): ?>
        <li class="<?php //echo isset($option['active']) && $option['active']===true?'active':'';
        //echo isset($option['disabled']) && $option['disabled']===true?' disabled':'';
        ?>">
            <a href="<?php //echo CHtml::encode($option['url']);?>"
                    <?php //echo isset($option['id'])?' id="'.$option['id'].'"':'';?>
                >
                <?php //echo CHtml::encode($option['name']);?>
                <?php //if(isset($option['glyphicon'])):?>
                <?php //echo "<span class=\"pull-left glyphicon ".$option['glyphicon']."\"></span>";?>
                <?php //endif; ?>
            </a>
        </li>
    <?php //endforeach;?>
</ul>-->

<ul>
    <?php foreach($options as $option):?>
    <li>
        <a <?php echo isset($option['id'])?' id="'.$option['id'].'"':'';?> href="<?php echo CHtml::encode($option['url']);?>"><span>  </span><?php echo CHtml::encode($option['name']);?>
            <?php if(isset($option['glyphicon'])):?>
                <?php echo "<span class=\"pull-left glyphicon ".$option['glyphicon']."\"></span>";?>
            <?php endif; ?>
        </a>
    </li>
    <?php endforeach;?>
</ul>