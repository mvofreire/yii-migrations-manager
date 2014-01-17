<?php

class DefaultController extends Controller
{
    public $defaultAction = "admin";
    
    const path = 'application.migrations';
    
    public function filters()
    {
        return array('accessControl');
    }
    
    public function actionIndex()
    {
        $this->render(Yii::app()->getModule('migration')->viewIndex, array(
            
        ));
    }
    
    public function actionCreate()
    {
        $application = Yii::getPathOfAlias('application');
        
        if(isset($_POST['Migrate']))
        {
            if(empty($_POST['Migrate']['name']))
                Yii::app()->user->setFlash('alert-error', Yii::t('app', 'Please enter a name in migration'));
            else
            {
                $nome = $_POST['Migrate']['name'];
                $result = exec("php $application/yiic.php migrate create $nome --interactive=0");
                Yii::app()->user->setFlash('alert-success', $result);
            }
        }
        
        $this->render(Yii::app()->getModule('migration')->viewCreate);
    }
    
    public function actionAdmin()
    {
        $updated = Migration::model()->reverse()->findAll();
        $findName = CHtml::listData($updated, 'id', 'version');
        $avaiable = array();
        
        if ($handle = opendir(Yii::getPathOfAlias(self::path))) {
            while (false !== ($file = readdir($handle))) {
                if(in_array($file, array('..','.'))){continue;}
                list($name, $ext) = explode('.', $file);
                if(in_array($name, array('template'))){continue;}
                if(in_array($name, $findName)){continue;}
                
                $avaiable[] = $name;
            }

            closedir($handle);
        }
        
        rsort($avaiable);
        
        $list = array();
        foreach($avaiable as $key => $item)
        {
            $m = new Migration();
            $m->version = $item;
            $m->status = Migration::AVAILABLE;
            $list[] = $m;
        }
        
        if(empty($avaiable))
            Yii::app()->user->setFlash('alert-warning', Yii::t('app', 'There is no migration to be performed.'));
        
        $this->render(Yii::app()->getModule('migration')->viewAdmin, array(
            'provider'=>new CArrayDataProvider($updated),
            'avaiable'=>new CArrayDataProvider($list)
        ));
    }
    
    public function actionUp()
    {
        if(isset($_POST['Up'][0]))
        {
            $especific = $_POST['Up'][0]; 
            $application = Yii::getPathOfAlias('application');
            $result = exec("php $application/yiic.php migrate to $especific --interactive=0");
            
            Yii::app()->user->setFlash('alert-warning', Yii::t('app', $result));
        }
        else
        {
            Yii::app()->user->setFlash('alert-error', Yii::t('app', 'Nothing found'));
        }
        
        $this->redirect(array('admin'));
    }
    
    public function actionDown()
    {
        if(isset($_POST['Down'][0]))
        {
            $application = Yii::getPathOfAlias('application');
            $name = $_POST['Down'][0];
            $result = exec("php $application/yiic.php migrate down $name --interactive=0");
            Yii::app()->user->setFlash('alert-warning', Yii::t('app', $result));
        }
        else
        {
            Yii::app()->user->setFlash('alert-error', Yii::t('app', 'Nothing Found'));   
        }
        
        $this->redirect(array('admin'));
    }
}