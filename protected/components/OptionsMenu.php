<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Dell 3521
 * Date: 06/04/14
 * Time: 10:43 م
 * To change this template use File | Settings | File Templates.
 */

class OptionsMenu extends CWidget{
    public $options = array();


    public function  run(){
        $this->render('optionsMenu',array(
            'options'=>$this->options,
        ));
    }

}