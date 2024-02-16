<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Dell 3521
 * Date: 06/04/14
 * Time: 04:15 م
 * To change this template use File | Settings | File Templates.
 */

class BreadCrumbs extends CWidget {

    public $breadcrumbs = array();

    public function run(){
        $this->render('BreadCrumbs',array(
            'breadcrumbs'=>$this->breadcrumbs,
        ));
    }
}
