<?php

/**
 * This is the model class for table "migration".
 * Extended class description
 *
 * @author PH DESIGN
 * @version x.x.x.x
 * @package mkf.folder.folder
 *
 * @property integer $id
 * @property string $version
 * @property integer $apply_time
 */
class Migration extends CActiveRecord {

    const UPDATED = 0;
    const AVAILABLE = 1;

    public $status;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Migration the static model class
     */
    public static function model($className = __CLASS__) {
        
        try 
        {
            $model = parent::model($className);
            $model->getTableSchema();
        }
        catch (CDbException $e) 
        {
            self::createDbTable();
            $model = parent::model($className);
        }
        
        return $model;
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{migration}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('version', 'required'),
            array('apply_time', 'numerical', 'integerOnly' => true),
            array('version', 'length', 'max' => 255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, version, apply_time', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('model', 'ID'),
            'version' => Yii::t('model', 'Version'),
            'apply_time' => Yii::t('model', 'Apply Time'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('version', $this->version, true);
        $criteria->compare('apply_time', $this->apply_time);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => ConfigController::getConfig('pagination_page_size_default'),
            ),
        ));
    }

    /**
     * Behaviors attached to Migration model. 
     */
    public function behaviors() {
        return array();
    }

    /**
     * Default scopes for Migration model. 
     */
    public function defaultScope() {
        return array();
    }

    protected function afterFind() {
        $this->status = self::UPDATED;
        return parent::afterFind();
    }

    /**
     * Scopes for Migration model. 
     */
    public function scopes() {
        return array(
            'reverse' => array(
                'order' => 'id DESC',
            ),
            'recently' => array(
                'order' => 'id DESC',
                'limit' => 10,
            ),
            'last' => array(
                'order' => 'id DESC',
                'limit' => 1,
            ),
        );
    }

    /**
     * creates table for holding provider bindings	
     */
    protected static function createDbTable() {
        $sql = file_get_contents(dirname(__FILE__) . '/migration.sql');
        $sql = strtr($sql, array('{{migration}}' => Yii::app()->db->tablePrefix . 'migration'));
        Yii::app()->db->createCommand($sql)->execute();
    }

    /*
     * Set the datetime inclusion if is new register
     */

    public function beforeValidate() {
        return parent::beforeValidate();
    }

}