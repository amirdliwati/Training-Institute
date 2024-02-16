$("#<?php echo $linkId;?>").click(function(){
    vex.defaultOptions.className = "vex-theme-plain";
    vex.dialog.<?php echo $type;?>(
        {
            message: "<?php echo $message;?>"<?php if($type=="open"):?>,
            input: <?php echo CJavaScript::encode($layout);?>,
            callback: function(value){
                <?php echo $callback;?>;
            }
            <?php endif;?>
        }
    );
});