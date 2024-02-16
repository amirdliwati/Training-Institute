<?php
/*
 * Modal  box for create method
 * Ahmad Samilo
 * 9.1.2014
 * @$form  the view target , ex:
 *
 * $model
 */
class Modal extends CWidget
{
    public $form;
    public $model;
    public $title;
    public $id;
    public $type;
    public $modalName;
    public $width;
    public function run()
    {
        $this->render('Modal', array('form' => $this->form,'model' => $this->model, 'title' => $this->title, 'id' => $this->id, 'type' => $this->type,'modalName'=>$this->modalName,
            'width'=>$this->width));
    }
}


?>