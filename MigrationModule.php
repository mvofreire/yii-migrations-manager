<?php

class MigrationModule extends CWebModule
{
    public $viewIndex = 'index';
    public $viewAdmin = 'admin';
    public $viewCreate = 'create';
    public $template = 'application.modules.migration.data.template';
    public $phpPath = "php";
    
    public function init()
    {
        $this->setImport(array(
            'migration.models.*',
            'migration.components.*',
        ));
    }

    public function beforeControllerAction($controller, $action)
    {
        if(parent::beforeControllerAction($controller, $action))
            return true;
        else
            return false;
    }

}
