<?php
class RbacCommand extends CConsoleCommand
{
    private $_authManager;
    public function getHelp()
    {
        $description = "DESCRIPTION\n";
        $description .= ' '."This command generates an initial RBAC authorization hierarchy For Illaf Project.\n";
        return parent::getHelp() . $description;
    }

    /**
     * The default action - create the RBAC structure.
     */
    public function actionIndex()
    {
        $this->ensureAuthManagerDefined();
        $message = "Hey This is Borhan :):This command will create one role: Admin\n";

        $message .= "Would you like to continue?";
        if($this->confirm($message))
        {
            $user = new User;
            $user->username = "Hasan Haj Hasan";
            $user->email = "hasan@icard.com";
            $user->password = "#asAn390240";
            $user->password_repeat = "#asAn390240";
            $user->save();
            $this->_authManager->clearAll();
            $this->_authManager->createOperation('adminApp');
            $appManagement = $this->_authManager->createTask("AppManagement",'Manage App');
            $role = $this->_authManager->createRole("admin");
            $role->addChild("AppManagement");
            $appManagement->addChild("adminApp");
            $this->_authManager->assign("admin",User::model()->find('email=:email',array(
                ':email'=>'hasan@icard.com',
            ))->id);
        }
        else
            echo "Operation cancelled.\n";
    }

    public function actionDelete()
    {
        $this->ensureAuthManagerDefined();
        $message = "This command will clear all RBAC definitions.\n";
        $message .= "Would you like to continue?";
//check the input from the user and continue if they indicated
//yes to the above question
        if($this->confirm($message))
        {
            $this->_authManager->clearAll();
            echo "Authorization hierarchy removed.\n";
        }
        else
            echo "Delete operation cancelled.\n";
    }
    protected function ensureAuthManagerDefined()
    {
//ensure that an authManager is defined as this is mandatory for creating an auth heirarchy
        if(($this->_authManager=Yii::app()->authManager)===null)
        {
            $message = "Error: an authorization manager, named 'authManager' must be con-figured to use this command.";
            $this->usageError($message);
        }
    }
}