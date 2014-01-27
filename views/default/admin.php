<h1>
    <?php echo Yii::t('app', 'Manage Migrations'); ?>
</h1>
<?php
echo CHtml::link('Create', array('create'));
?>
<hr/>

<h1><?php echo Yii::t('app', 'Avaiable'); ?></h1>
<?php echo CHtml::beginForm($this->createUrl('default/up')); ?>
<?php echo CHtml::submitButton('Up');?>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'migration-grid-avaiable',
    'dataProvider' => $avaiable,
    'enableHistory' => false,
    'nullDisplay' => '-',
    'ajaxUpdate' => 'migration-grid',
    'showTableOnEmpty' => true,
    'emptyText' => Yii::t('app', 'Empty'),
    'columns' => array(
        array(
            'id' => 'Up',
            'class' => 'CheckBoxPreviousColumn',
            'value' => function($d)
            {
                return $d->version;
            },
            'orientation' => 'nextAll'
        ),
        'id',
        'version',
        array(
            'name' => 'apply_time',
            'value' => function($d)
            {
                return '-';
            }
        ),
        array(
            'name' => 'status',
            'value' => function($d)
            {
                return ($d->status == Migration::AVAILABLE) ? Yii::t('app', 'Available') : Yii::t('app', 'Updated');
            }
        )
    ),
));
?>
<?php echo CHtml::endForm(); ?>

<hr/>

<h1><?php echo Yii::t('app', 'Updated'); ?></h1>
<?php echo CHtml::beginForm($this->createUrl('default/down')); ?>
<?php echo CHtml::submitButton('Down');?>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'migration-grid-updated',
    'dataProvider' => $provider,
    'enableHistory' => false,
    'nullDisplay' => '-',
    'ajaxUpdate' => 'migration-grid',
    'showTableOnEmpty' => true,
    'emptyText' => Yii::t('app', 'Empty'),
    'columns' => array(
        array(
            'id' => 'Down',
            'value' => function($d, $c, $v)
            {
                return $c + 1;
            },
            'class' => 'CheckBoxPreviousColumn',
        ),
        'id',
        'version',
        array(
            'name' => 'apply_time',
            'value' => function($d)
            {
                return date('d-m-Y H:i:s', $d->apply_time);
            }
        ),
        array(
            'name' => 'status',
            'value' => function($d)
            {
                return ($d->status == Migration::AVAILABLE) ? Yii::t('app', 'Available') : Yii::t('app', 'Updated');
            }
        )
    ),
));
?>
<?php echo CHtml::endForm(); ?>

