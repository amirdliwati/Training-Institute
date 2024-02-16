<?php

/*
 * Modal  box for ajax method
 * Ahmad Samilo
 * 9.1.2014
 *@title type string
 * @return empty modal
 * @title : model header text
 * @name : the id  of modal
 * @width : the width of modal in px
 * $model
 */

class Ajaxmodal extends CWidget
{

    public $title;
    public $name  = 'updateActionModal';
    public $width = '';

    public function run()
    {

        $this->render('ajaxmodal', array('title' => $this->title, 'name' => $this->name,'width'=>$this->width));

    }
}


?>