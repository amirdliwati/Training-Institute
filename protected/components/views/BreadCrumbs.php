<ol class="breadcrumb">
    <?php foreach($breadcrumbs as $item):?>
    <li class="<?php echo !is_array($item)?"active":"";?>">
        <?php if (is_array($item)){
                echo CHtml::link($item['name'],$item['url']);
            }else{
                echo CHtml::encode($item);
            }
        ?>
    </li>
    <?php endforeach;?>
</ol>